# AI Coding Agent Instructions

## Project Overview
This is a **Laravel 11** application built on the **Metronic 8 admin theme**, featuring a dual-architecture design with both admin panel and public-facing frontend. The project uses XAMPP for local development on Windows with PowerShell.

## Architecture & Theme System

### Custom Theme Bootstrap System
The application uses a unique theme initialization pattern via `App\Core\KTBootstrap`:
- Theme configuration is driven by `config/settings.php` with bootstrap classes in `app/Core/Bootstrap/`
- `KTBootstrap::init()` is called in `AppServiceProvider::boot()` to initialize layout attributes
- Three bootstrap types: `BootstrapDefault`, `BootstrapAuth`, `BootstrapSystem`
- Layout is configured via `addHtmlAttribute()` helper calls (not config files)

Example from `BootstrapDefault::initDarkSidebarLayout()`:
```php
addHtmlAttribute('body', 'data-kt-app-layout', 'dark-sidebar');
addHtmlAttribute('body', 'data-kt-app-sidebar-enabled', 'true');
```

### Global Helper Functions
Critical helpers in `app/Helpers/Helpers.php` provide theme integration:
- `addHtmlAttribute($scope, $name, $value)` - Add HTML attributes to body/html tags
- `addJavascriptFile($file)` / `addVendors($vendors)` - Asset management
- `getIcon($name, $class)` - Render Metronic SVG icons
- `image($path)` - Asset path helper for theme images
- `theme()` - Access `App\Core\Theme` instance

These are NOT standard Laravel helpers - they're custom to this Metronic integration.

## Key Conventions

### View Structure
- **Admin views**: `resources/views/admin/` with subdirs: `apps/`, `auth/`, `dashboards/`
- **Frontend views**: `resources/views/front/` with `layout.blade.php` as master
- **Layout templates**: `resources/views/layout/` contains `_default.blade.php`, `_auth.blade.php`, `_system.blade.php`
- All admin layouts extend `layout.master` which includes `@livewireStyles` and `@livewireScripts`

### Routing Pattern
Routes follow a hierarchical prefix structure in `routes/web.php`:
```php
Route::prefix('users')->name('apps.users.')->controller(UserManagementController::class)->group(function () {
    // Custom actions first
    Route::post('/{user}/toggle-status', 'toggleStatus')->name('toggle-status');
    // Then resource routes manually defined
    Route::get('/', 'index')->name('index');
    Route::get('/{user}', 'show')->name('show');
});
```
**Important**: Manual resource route definitions, not `Route::resource()`, for custom actions.

### DataTables Integration
Uses `yajra/laravel-datatables` with dedicated DataTable classes in `app/DataTables/`:
```php
class UsersDataTable extends DataTable {
    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->editColumn('user', function (User $user) {
                return view('admin/apps.user-management.users.columns._user', compact('user'));
            })
            ->addColumn('action', function (User $user) {
                return view('admin/apps.user-management.users.columns._actions', compact('user'));
            });
    }
}
```
Pattern: Render partials in `columns/` subdirectories for custom DataTable columns.

### Livewire Component Pattern
Livewire 3 components are namespaced by feature in `app/Livewire/`:
- `app/Livewire/User/AddUserModal.php` - Modal forms for CRUD operations
- `app/Livewire/Permission/` - Permission management components
- Use `WithFileUploads` trait for avatar/image uploads
- French validation messages in `messages()` method

### User Management & Permissions
- Uses `spatie/laravel-permission` for roles/permissions
- Users have `HasRoles` trait and soft deletes (`SoftDeletes`)
- Custom fields: `first_name`, `last_name`, `phone`, `is_active`, `last_login_at`, `last_login_ip`
- Avatar stored in `profile_photo_path` with custom accessor `getProfilePhotoUrlAttribute()`

### Breadcrumbs
Breadcrumbs use `diglactic/laravel-breadcrumbs` defined in `routes/breadcrumbs.php`:
```php
Breadcrumbs::for('apps.users.show', function (BreadcrumbTrail $trail, User $user) {
    $trail->parent('apps.users.index');
    $trail->push(ucwords($user->name), route('apps.users.show', $user));
});
```
Always define breadcrumbs for new admin routes.

## Development Workflow

### Local Environment
- **Server**: XAMPP (Apache + MySQL) on Windows
- **Database**: MySQL via phpMyAdmin at `localhost/phpmyadmin`
- **Shell**: PowerShell (use `;` for command chaining, not `&&`)

### Essential Commands
```powershell
# Start development
php artisan serve                    # Start Laravel dev server
npm run dev                          # Watch assets with Laravel Mix

# Database operations
php artisan migrate                  # Run migrations
php artisan db:seed                  # Seed database

# Cache management (required after config changes)
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Production build
composer run build                   # Runs npm prod + caches config/routes/views
```

### Asset Management
- Uses **Laravel Mix** (see `package.json` scripts)
- Assets compiled to `public/assets/` with manifest at `public/mix-manifest.json`
- Metronic theme assets in `public/assets/plugins/global/`
- Custom CSS in `public/assets/css/custom.css`

### Database Schema Evolution
- Active migrations show incremental feature additions (soft deletes, roles, galleries, blog)
- Use `first_name`/`last_name` pattern, not single `name` field
- French language convention: table/column names in English, UI text in French

## Critical Patterns

### When Adding New CRUD Module:
1. Create controller extending `Controller` in `app/Http/Controllers/Apps/`
2. Define routes in `web.php` with prefix/name/controller grouping
3. Create DataTable class in `app/DataTables/` if listing needed
4. Add breadcrumbs in `routes/breadcrumbs.php`
5. Create views in `resources/views/admin/apps/{module}/` with `columns/` subdir for DataTable partials
6. Update sidebar in `resources/views/layout/partials/sidebar-layout/_sidebar.blade.php`

### When Modifying Theme:
- Never directly edit body/html attributes in Blade - use `addHtmlAttribute()` in Bootstrap classes
- Add new assets via `addJavascriptFile()` or `addVendors()` in Bootstrap `initAssets()` method
- Use `getIcon()` helper for Metronic icons, not hardcoded SVG paths

### Authentication:
- Laravel Breeze for auth scaffolding
- Custom login tracking: `last_login_at` and `last_login_ip` updated on login
- Socialite integration present (routes defined for `auth/redirect/{provider}`)

## Important Notes
- **Language**: UI is in French - maintain this in views, validation messages, breadcrumbs
- **Permissions**: Check role-based access in controllers/routes when adding features
- **File Uploads**: Use `storage/app/public/` with symlink to `public/storage`
- **Email**: Uses `phpmailer/phpmailer` for mail (see `app/Mail/DevisSubmitted.php` for pattern)
- **Exports**: Uses `maatwebsite/excel` for Excel exports (see `app/Exports/DevisExport.php`)
