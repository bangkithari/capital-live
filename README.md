# CpitalLive Individual

Insurance CRM (Customer Relationship Management) built with **Laravel 13**, **Tailwind CSS**, **Alpine.js**, and **Livewire-style dynamic menus**. Designed for insurance agencies to manage customers, policies, agents, appointments, and tasks in one place.

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 13 (PHP 8.3+) |
| Frontend | Tailwind CSS 3 + Alpine.js 3 |
| Database | MySQL 8.x / MariaDB |
| Auth | Laravel Breeze + JWT (tymon/jwt-auth) |
| Icons | Lucide Icons (CDN) |
| Tables | jQuery DataTables (server-side) |
| Drag & Drop | jQuery UI Sortable |
| Build | Vite 8 |

## Features

- **Dashboard** — Real-time stats (customers, policies, appointments, agents)
- **Customer Management** — CRUD with DataTable server-side processing, individual & business types
- **Dynamic Sidebar Menu** — Database-driven menus with parent/child hierarchy, drag-drop reorder, toggle active/inactive via AJAX
- **Admin Menu Management** — Full CRUD for sidebar items, icon picker (Lucide names), permission & route mapping
- **Role-Based Users** — Admin, Manager, Agent, User roles with color-coded badges
- **Auth System** — Login, register, password reset, email verification (Breeze)
- **Responsive Layout** — Collapsible sidebar, mobile hamburger, breadcrumbs, toast notifications
- **JWT API Ready** — User model implements JWTSubject for future API endpoints

## Database Schema

### Core Tables
- `users` — Auth users with roles (admin/manager/agent/user)
- `customers` — Individual or business customers with full contact info
- `customer_addresses` — Multiple addresses per customer
- `customer_dependents` — Family/dependent records

### Insurance Tables
- `agents` — Agent profiles with NPI, license info, state
- `policies` — Policies linked to customers, agents, carriers
- `policy_riders` — Policy add-ons/riders
- `appointments` — Scheduled appointments with status tracking
- `tasks` — Task management with assignment & due dates
- `documents` — File attachments for customers/policies/appointments

### Lookup Tables (18 tables)
`appointment_status`, `task_status`, `source_type`, `gender`, `title`, `marital_status`, `suffix`, `preferred_contact`, `preferred_language`, `address_type`, `license_status`, `license_type`, `carrier`, `policy_status`, `policy_type`, `payment_mode`, `relationship`, `state`, `lead_source`

### Menu System
- `menus` — Hierarchical menu tree (parent_id self-referencing)

## Requirements

- PHP >= 8.3
- Composer
- Node.js >= 18 + npm
- MySQL 8.x or MariaDB 10.6+
- nginx or Apache

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/emuII/cpital-live.git
cd cpital-live
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cpital_live
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

Generate JWT secret:

```bash
php artisan jwt:secret
```

### 4. Create Database

```bash
mysql -u root -p -e "CREATE DATABASE cpital_live CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "CREATE USER 'laravel'@'127.0.0.1' IDENTIFIED BY 'your_password'; GRANT ALL ON cpital_live.* TO 'laravel'@'127.0.0.1'; FLUSH PRIVILEGES;"
```

### 5. Run Migrations & Seed

```bash
php artisan migrate
php artisan db:seed
```

This creates:
- All database tables (14 migrations)
- Default admin user: `admin@cpitallive.com` / `password`
- Default menu items (Dashboard, Customers, Policies, Appointments, Agents, Tasks, Admin submenu)

### 6. Build Frontend

```bash
npm run build
```

For development with hot-reload:

```bash
npm run dev
```

### 7. Start Development Server

**Option A: Laravel built-in (simple)**

```bash
php artisan serve
```

**Option B: Full dev stack (recommended)**

```bash
composer dev
```

This runs concurrently:
- `php artisan serve` (HTTP server)
- `php artisan queue:listen` (Queue worker)
- `php artisan pail` (Live logs)
- `npm run dev` (Vite HMR)

### 8. Nginx Production Config

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

Set permissions:

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## Default Credentials

| Field | Value |
|-------|-------|
| Email | `admin@cpitallive.com` |
| Password | `password` |

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/            # Breeze auth controllers
│   │   │   ├── CustomerController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── MenuController.php
│   │   │   └── ProfileController.php
│   │   └── Requests/
│   └── Models/
│       ├── User.php             # JWT-capable user model
│       ├── Customer.php         # Individual + business customers
│       ├── Menu.php             # Self-referencing menu tree
│       ├── Policy.php
│       ├── Agent.php
│       ├── Appointment.php
│       ├── Task.php
│       └── ... (18 lookup models)
├── database/
│   ├── migrations/              # 14 migration files
│   └── seeders/
│       ├── DatabaseSeeder.php   # Admin user + menu seed
│       └── MenuSeeder.php       # Default sidebar menus
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php    # Main layout (sidebar + navbar)
│       │   └── guest.blade.php  # Auth pages layout
│       ├── customers/           # CRUD views
│       ├── admin/menus/         # Menu management views
│       ├── components/          # Reusable Blade components
│       └── dashboard.blade.php
└── routes/
    ├── web.php                  # Main routes
    └── auth.php                 # Breeze auth routes
```

## Routes

| Method | URI | Controller | Description |
|--------|-----|-----------|-------------|
| GET | `/` | Redirect | Redirects to `/dashboard` |
| GET | `/dashboard` | DashboardController | Stats overview |
| GET | `/customers` | CustomerController | Customer list (DataTable) |
| GET | `/customers/list` | CustomerController | JSON endpoint for DataTable |
| GET/POST | `/customers/create` | CustomerController | Create customer |
| GET | `/customers/{id}` | CustomerController | View customer |
| GET/PUT | `/customers/{id}/edit` | CustomerController | Edit customer |
| DELETE | `/customers/{id}` | CustomerController | Delete customer |
| GET | `/admin/menus` | MenuController | Menu management |
| POST | `/admin/menus` | MenuController | Create menu item |
| POST | `/admin/menus/reorder` | MenuController | Drag-drop reorder (AJAX) |
| POST | `/admin/menus/{id}/toggle` | MenuController | Toggle active (AJAX) |
| GET | `/profile` | ProfileController | User profile |

## Key Architecture Decisions

1. **Dynamic Menus** — Sidebar is fully database-driven. Add/remove/reorder items via Admin > Menu Management without touching code.

2. **DataTable Server-Side** — Customer list uses server-side processing for performance with large datasets. Search, sort, and pagination all happen via AJAX.

3. **Lookup Tables** — 18 normalized lookup tables (gender, status, type, etc.) keep the main tables clean and allow easy dropdown management.

4. **SoftDeletes** — Customers, policies, agents, tasks, and documents use soft deletes. Records are never permanently lost.

5. **JWT Ready** — User model implements `JWTSubject` for future API/mobile app integration. JWT secret configured via `JWT_SECRET` env variable.

## License

This project is proprietary software. All rights reserved.
