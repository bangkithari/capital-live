# CpitalLive

Insurance CRM (Customer Relationship Management) built with **Laravel 13**, **Tailwind CSS**, **Alpine.js**, and **database-driven dynamic menus**. Designed for insurance agencies to manage CIF (Customer Information File), policies, roles, and multi-department access control in one place.

---

## Tech Stack

| Layer         | Technology                              |
|---------------|-----------------------------------------|
| Backend       | Laravel 13 (PHP 8.3+)                   |
| Frontend      | Tailwind CSS 3 + Alpine.js 3            |
| Database      | MySQL 8.x / MariaDB 10.6+              |
| Auth          | Laravel Breeze + JWT (tymon/jwt-auth)   |
| Icons         | Lucide Icons (CDN)                      |
| Tables        | jQuery DataTables (server-side)         |
| Drag & Drop   | jQuery UI Sortable                      |
| URL Encryption| vinkla/hashids (Hashids) + Laravel Crypt|
| Build         | Vite 8                                  |

---

## Features

### Core
- **Dashboard** — Real-time stats (customers, policies, appointments, agents)
- **CIF Management** — Customer Information File with individual & business types, server-side DataTable processing
- **Reports** — Placeholder module for reporting dashboard (expandable)

### Menu System
- **Dynamic Sidebar** — Fully database-driven with parent/child hierarchy, drag-drop reorder
- **Menu Management** — Full CRUD for sidebar items via Admin panel (icon picker, route mapping, active toggle)
- **Menu Visibility** — Per-role, per-department visibility with `menu_type` column + `role_department_menu` pivot table

### Access Control
- **Role-Based Access Control (RBAC)** — Roles + Departments with per-menu access control
- **Role Access Management** — Admin UI to configure which roles can access which menus (checkbox matrix)
- **Middleware Authorization** — `CheckMenuAccess` middleware checks `role_department_menu` table per route (replaces hardcoded admin check)

### Security
- **Encrypted URLs (Hashids)** — All model IDs in URLs are encoded via Hashids (e.g., `/admin/users/qYQL0Qmj/edit` instead of `/admin/users/000001/edit`)
- **Encrypted Route Keys (Crypt)** — CIF model uses Laravel Crypt for even stronger URL encryption
- **IDOR Prevention** — Sequential database IDs never exposed in URLs, forms, or API responses
- **JWT Ready** — User model implements `JWTSubject` for future API/mobile app integration

### UI/UX
- **Responsive Layout** — Collapsible sidebar, mobile hamburger, breadcrumbs, toast notifications
- **Lucide Icons** — Consistent icon set via CDN
- **Alpine.js Modals** — Inline edit modals for menu management without page reload

---

## How to Use

### Requirements

- PHP >= 8.3 (with `bcmath` extension)
- Composer
- Node.js >= 18 + npm
- MySQL 8.x or MariaDB 10.6+
- nginx or Apache

### 1. Clone Repository

```bash
git clone https://github.com/bangkithari/capital-live.git
cd capital-live
git checkout SUPERAGENT
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run build
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

Edit `.env`:

```env
APP_URL=http://your-domain.com
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cpital_live
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
JWT_SECRET=your_jwt_secret
```

### 4. Create Database

```bash
mysql -u root -p -e "CREATE DATABASE cpital_live CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "CREATE USER 'laravel'@'127.0.0.1' IDENTIFIED BY 'your_password'; GRANT ALL ON cpital_live.* TO 'laravel'@'127.0.0.1'; FLUSH PRIVILEGES;"
```

### 5. Run Migrations & Seed

```bash
php artisan migrate --seed
```

This creates:
- All database tables (14 migrations)
- 3 default users (see Default Credentials below)
- Menu items, roles, departments, and role-menu access entries

### 6. Set Permissions

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### 7. Development Server

```bash
# Simple
php artisan serve

# Full dev stack (recommended)
composer dev
```

### 8. Production (nginx)

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/cpital-live/public;
    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* { deny all; }
}
```

Cache config for performance:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Default Credentials

| User     | Email                 | Password | Role               | Role ID |
|----------|-----------------------|----------|--------------------|---------|
| Admin    | admin@capital.com     | `admin`  | Administrator      | 1       |
| Dummy    | dummy@gmail.com       | `admin`  | Direktur           | 6       |
| Lorem    | loremipsum@gmail.com  | `admin`  | Department Head    | 3       |

> **Note:** Change all passwords before production use.

---

## Alur Data (Data Flow)

### 1. Authentication Flow

```
User → Login Form → Breeze AuthController
  → Validate credentials (users table: email + password_hash)
  → Create session → Redirect to /dashboard
  → All routes behind auth middleware → $request->user() available
```

### 2. Menu Visibility Flow

```
User loads page → Menu::getMenuTree($user)
  → Fetch all active menus (is_active = 1)
  → For each menu:
      ├─ Admin user? → Show everything (isAdmin bypass)
      ├─ menu_type is NULL? → Show (public menu)
      └─ Check role_department_menu table:
           → role_id + department_id + is_access = 1?
           → Yes → Show menu + its children
           → No  → Hide menu + its children
  → Return tree structure → Blade renders sidebar
```

### 3. Route Authorization Flow (CheckMenuAccess Middleware)

```
User clicks menu item → Route request
  → auth middleware (must be logged in)
  → menu-access middleware (CheckMenuAccess):
      ├─ Admin? → Allow immediately
      ├─ Resolve route_name → menu_id (cached map)
      ├─ No menu found? → Allow (route not menu-gated)
      ├─ menu_type is blank? → Allow (public menu)
      └─ Check allowed_menus:{role_id}:{dept_id} cache:
           → menu_id in allowed list? → Allow
           → Not in list → 403 Forbidden
  → Controller handles request
```

### 4. URL Encryption Flow (Hashids)

```
Controller returns view → route('admin.users.edit', $user)
  → $user->getRouteKey() called
  → HasHashid trait → getHashidAttribute()
  → Hashids::encode(1) → "qYQL0Qmj"
  → URL: /admin/users/qYQL0Qmj/edit

User visits URL → Laravel resolves {user} route binding
  → HasHashid::resolveRouteBinding("qYQL0Qmj")
  → Hashids::decode("qYQL0Qmj") → 1
  → str_pad(1, 6, '0', STR_PAD_LEFT) → "000001"
  → User::where('user_id', '000001')->first()
```

### 5. Role Access Management Flow

```
Admin opens Role Access page → RoleAccessController::index()
  → Fetch all roles, departments, menus
  → Build $roleAccessMap from role_department_menu table
  → Render checkbox matrix

Admin toggles checkbox → PUT /admin/role-access
  → RoleAccessController::update()
  → Sync role_department_menu table (insert/update/delete)
  → Sync menu_type column (comma-separated role names)
  → Flush cache: menu_route_map, menu_url_map, menu_types, allowed_menus:*
```

### 6. Caching Architecture

```
Layer 1: menu_route_map (24h TTL)
  → Maps route_name → menu_id for all active menus
  → Used by CheckMenuAccess to resolve which menu a route belongs to

Layer 2: menu_url_map (24h TTL)
  → Maps url path → menu_id as fallback for route name resolution

Layer 3: menu_types (24h TTL)
  → Maps menu_id → menu_type for quick "is public?" check

Layer 4: allowed_menus:{role_id}:{dept_id} (30min TTL)
  → Set of menu_ids a role+dept combo can access
  → Invalidated when RoleAccessController::update() is called
```

**Performance:** ~0.22ms per request with caching vs ~2.41ms without (10x improvement).

---

## Keamanan (Security)

### 1. URL Parameter Encryption (IDOR Prevention)

All database IDs exposed in URLs are encrypted using two approaches:

**Hashids (User, Menu models):**
- `/admin/users/qYQL0Qmj/edit` instead of `/admin/users/000001/edit`
- One-way encoding with configurable salt (in `config/hashids.php`)
- Minimum 8 characters output
- Decoded only by Laravel's route model binding

**Laravel Crypt (Cif model):**
- `/cif/aBcDeFgHiJkLmNoPqRsT` instead of `/cif/1`
- Uses Laravel's AES-256-CBC encryption (stronger, but longer URLs)
- Key derived from `APP_KEY`

### 2. Route-Level Authorization

**CheckMenuAccess middleware** replaces hardcoded admin-only checks:

```php
// Before (old): Only admins can access
Route::middleware('admin')  // EnsureUserIsAdmin → abort(403) for non-admins

// After (new): Menu-based access control
Route::middleware('menu-access')  // CheckMenuAccess → checks role_department_menu
```

**How it works:**
1. Admin users bypass all checks (see everything)
2. Public menus (blank `menu_type`) are accessible to all authenticated users
3. Restricted menus check `role_department_menu` for the user's `role_id` + `department_id`
4. Route-to-menu mapping is cached (24h) for performance
5. Access cache per role+dept is cached (30min) and invalidated on role access updates

### 3. CSRF Protection

- All POST/PUT/DELETE requests require CSRF token (Laravel default)
- Blade `@csrf` directive in all forms
- AJAX requests include `X-CSRF-TOKEN` header

### 4. XSS Prevention

- All user input is escaped via Blade `{{ }}` syntax (auto-escaping)
- `@js()` directive for safely injecting data into JavaScript
- Alpine.js `x-text` and `:class` bindings are auto-escaped

### 5. SQL Injection Prevention

- Eloquent ORM with parameterized queries throughout
- No raw SQL or `DB::raw()` with user input
- DataTable server-side processing uses query builder

### 6. Session Security

- Session cookies are HTTP-only, same-site lax
- Session driver: database (sessions table)
- Password hashing: bcrypt (12 rounds)

### 7. Cache Invalidation

Role access caches are flushed immediately when an admin updates permissions:

```php
// RoleAccessController::update()
Cache::forget('menu_route_map');
Cache::forget('menu_url_map');
Cache::forget('menu_types');
Cache::forget('allowed_menus:' . $roleId . ':' . $deptId);
```

No stale permissions — changes take effect on the next request.

### 8. Soft Deletes

Customers, policies, agents, tasks, and documents use soft deletes. Records are never permanently lost from the database, providing audit trail and recovery capability.

---

## Database Schema

### Core Tables
- `users` — Auth users with role_id + department_id foreign keys
- `cif` — Customer Information File (individual & business)
- `menus` — Hierarchical menu tree (parent_id self-referencing)
- `roles` — Role definitions (Administrator, Direktur, Department Head, etc.)
- `departments` — Department definitions
- `role_department_menu` — Pivot table: which roles can access which menus

### Insurance Tables
- `agents` — Agent profiles with NPI, license info, state
- `policies` — Policies linked to customers, agents, carriers
- `policy_riders` — Policy add-ons/riders
- `appointments` — Scheduled appointments with status tracking
- `tasks` — Task management with assignment & due dates
- `documents` — File attachments for customers/policies/appointments

### Lookup Tables (18 tables)
`appointment_status`, `task_status`, `source_type`, `gender`, `title`, `marital_status`, `suffix`, `preferred_contact`, `preferred_language`, `address_type`, `license_status`, `license_type`, `carrier`, `policy_status`, `policy_type`, `payment_mode`, `relationship`, `state`, `lead_source`

---

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── RoleAccessController.php   # RBAC checkbox matrix
│   │   │   │   └── UserController.php          # User CRUD
│   │   │   ├── Auth/                           # Breeze auth
│   │   │   ├── CifController.php               # CIF CRUD + DataTable
│   │   │   ├── DashboardController.php         # Stats overview
│   │   │   ├── MenuController.php              # Menu CRUD + reorder
│   │   │   ├── ReportsController.php           # Reports placeholder
│   │   │   └── ProfileController.php           # User profile
│   │   └── Middleware/
│   │       ├── CheckMenuAccess.php             # Menu-based RBAC middleware
│   │       └── EnsureUserIsAdmin.php           # Legacy admin-only (unused)
│   ├── Models/
│   │   ├── Concerns/
│   │   │   └── HasEncodedRouteKey.php          # Laravel Crypt URL encryption
│   │   ├── User.php                            # HasHashid + isAdmin()
│   │   ├── Cif.php                             # HasEncodedRouteKey
│   │   ├── Menu.php                            # HasHashid + visibility logic
│   │   ├── RoleDepartmentMenu.php              # Pivot model
│   │   └── ... (18 lookup models)
│   ├── Traits/
│   │   └── HasHashid.php                       # Hashids URL encryption trait
│   └── Providers/
├── config/
│   └── hashids.php                             # Hashids salt + min length
├── database/
│   ├── migrations/                             # 14 migration files
│   └── seeders/                                # Menu, role, dept, user seeds
├── resources/
│   └── views/
│       ├── layouts/app.blade.php               # Main layout (sidebar + navbar)
│       ├── admin/
│       │   ├── menus/index.blade.php           # Menu management (Alpine.js)
│       │   ├── users/                          # User CRUD views
│       │   └── role-access/index.blade.php     # RBAC matrix UI
│       ├── cif/                                # CIF list + detail views
│       ├── reports/index.blade.php             # Reports placeholder
│       └── dashboard.blade.php                 # Dashboard stats
├── routes/
│   ├── web.php                                 # Main routes
│   └── auth.php                                # Breeze auth routes
└── backups/                                    # File backups (gitignored)
```

---

## Routes

| Method | URI                          | Controller            | Middleware   | Description                    |
|--------|------------------------------|-----------------------|--------------|--------------------------------|
| GET    | `/`                          | Redirect              | —            | Redirects to `/dashboard`      |
| GET    | `/dashboard`                 | DashboardController   | auth         | Stats overview                 |
| GET    | `/cif`                       | CifController         | auth         | CIF list (DataTable)           |
| GET    | `/cif/list`                  | CifController         | auth         | JSON endpoint for DataTable    |
| GET    | `/cif/{cif}`                 | CifController         | auth         | View CIF (encrypted ID)        |
| GET    | `/reports`                   | ReportsController     | auth         | Reports page                   |
| GET    | `/admin/menus`               | MenuController        | menu-access  | Menu management                |
| POST   | `/admin/menus`               | MenuController        | menu-access  | Create menu item               |
| POST   | `/admin/menus/reorder`       | MenuController        | menu-access  | Drag-drop reorder (AJAX)       |
| GET    | `/admin/menus/{menu}/edit`   | MenuController        | menu-access  | Edit menu (encrypted ID)       |
| PUT    | `/admin/menus/{menu}`        | MenuController        | menu-access  | Update menu                    |
| DELETE | `/admin/menus/{menu}`        | MenuController        | menu-access  | Delete menu                    |
| GET    | `/admin/users`               | UserController        | menu-access  | User list                      |
| GET    | `/admin/users/{user}/edit`   | UserController        | menu-access  | Edit user (encrypted ID)       |
| PUT    | `/admin/users/{user}`        | UserController        | menu-access  | Update user                    |
| GET    | `/admin/role-access`         | RoleAccessController  | menu-access  | RBAC matrix                    |
| PUT    | `/admin/role-access`         | RoleAccessController  | menu-access  | Update role access             |
| GET    | `/profile`                   | ProfileController     | auth         | User profile                   |

---

## License

This project is proprietary software. All rights reserved.
