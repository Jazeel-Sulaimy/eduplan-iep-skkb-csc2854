# IEP Management System SK Kuala Berang

This is a Laravel starter system for a diploma final project.

## Technology
- Frontend: Blade, HTML, CSS, basic JavaScript
- Backend: Laravel / PHP
- Database: MySQL
- Server: XAMPP / Laravel artisan server
- Editor: Visual Studio Code

## Setup Steps

1. Create a fresh Laravel project:

```bash
composer create-project laravel/laravel iep_skkb
cd iep_skkb
```

2. Create an empty MySQL database in phpMyAdmin:

```text
iep_skkb
```

3. Update `.env`:

```env
DB_DATABASE=iep_skkb
DB_USERNAME=root
DB_PASSWORD=
```

4. Copy these folders/files from this package into your Laravel project and replace existing files:

```text
app
routes
database
resources
public
README.md
```

5. Run:

```bash
php artisan optimize:clear
php artisan migrate:fresh --seed
php artisan serve
```

6. Open:

```text
http://127.0.0.1:8000
```

## Demo Login

```text
ADMIN001 / 12345
TEACHER001 / 12345
COUNSELLOR001 / 12345
PARENT001 / 12345
SYSADMIN001 / 12345
```

## Image Setup

Put your real images in:

```text
public/assets/images/jata-negara.png
public/assets/images/school-logo.png
public/assets/images/school-bg.jpg
```

## Main Modules
- Login by User ID
- Role-based dashboard
- Student Profile
- Manage Users
- IEP Form / Goals
- Behaviour and Reward Points
- Progress Status
- Student Case and Consultation
- IEP Review
- Parent Consent Letter
- Generate Printable Report
- Backup Log
- Profile Picture Upload
