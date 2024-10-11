# AdvanceRole for Laravel CMS

- Roles & Permissions
- Organization & Departments
- Teams

<p align="center">
    <a href="https://packagist.org/packages/vswb/advanced-role"><img src="https://img.shields.io/packagist/v/vswb/advanced-role.svg?style=flat-square" alt="Latest Version"></a>
    <a href="/LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></a>
    <a href="https://packagist.org/packages/vswb/advanced-role"><img src="https://img.shields.io/packagist/dt/vswb/advanced-role.svg?style=flat-square" alt="Total Downloads"></a>
</p>

## Installation

You can install the package via composer:

```shell
composer require dev-extension/advanced-role
```

## Documentation

### Seeding data for app_permission

```shell
Step 1: php artisan db:seed --class=\\Dev\\AdvancedRole\\Seeders\\LaratrustSeeder
Step 2: php artisan db:seed --class=\\Dev\\AdvancedRole\\Seeders\\ScopeSeeder
Step 3: php artisan db:seed --class=\\Dev\\AdvancedRole\\Seeders\\RoleSeeder
Step 4: php artisan db:seed --class=\\Dev\\AdvancedRole\\Seeders\\PermissionSeeder
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

