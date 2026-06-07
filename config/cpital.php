<?php

return [
    'admin_role_name' => env('CPITAL_ADMIN_ROLE_NAME', 'Administrator'),
    'default_role_name' => env('CPITAL_DEFAULT_ROLE_NAME', 'Officer'),
    'default_department_code' => env('CPITAL_DEFAULT_DEPARTMENT_CODE', 'IT'),
    'generated_user_id_length' => (int) env('CPITAL_GENERATED_USER_ID_LENGTH', 6),

    'default_department_name' => env('CPITAL_DEFAULT_DEPARTMENT_NAME', 'IT'),

    // Auth rate limiting
    'auth_max_attempts' => (int) env('CPITAL_AUTH_MAX_ATTEMPTS', 5),
    'auth_decay_seconds' => (int) env('CPITAL_AUTH_DECAY_SECONDS', 60),

    // Pagination
    'per_page' => (int) env('CPITAL_PER_PAGE', 15),

    'role_badges' => [
        'Administrator' => ['bg' => 'bg-violet-100 text-violet-700 border-violet-200', 'label' => 'Administrator'],
        'Division Head' => ['bg' => 'bg-blue-100 text-blue-700 border-blue-200', 'label' => 'Division Head'],
        'Department Head' => ['bg' => 'bg-blue-100 text-blue-700 border-blue-200', 'label' => 'Department Head'],
        'Section Head' => ['bg' => 'bg-emerald-100 text-emerald-700 border-emerald-200', 'label' => 'Section Head'],
        'Officer' => ['bg' => 'bg-slate-100 text-slate-700 border-slate-200', 'label' => 'Officer'],
        'Direktur' => ['bg' => 'bg-amber-100 text-amber-700 border-amber-200', 'label' => 'Direktur'],
    ],
];
