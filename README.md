# EduPlan – IEP Management System SKKB

EduPlan is a web-based Individual Education Plan Management System
developed for Sekolah Kebangsaan Kuala Berang as a CSC2854 Final Year
Project.

## Technologies

- Laravel 12
- PHP 8.2
- Blade
- HTML5
- CSS3
- Basic JavaScript
- MySQL / MariaDB
- SQLite compatible
- XAMPP
- Composer

## Main Roles

- School Administrator
- Teacher
- Counsellor
- Parent / Guardian
- System Administrator

## XAMPP Installation

1. Install XAMPP with PHP 8.2.
2. Start MySQL from the XAMPP Control Panel.
3. Clone the repository into:

   C:\xampp\htdocs\IEP_SKKB

4. Open the project folder in Visual Studio Code.
5. Install PHP dependencies:

   composer install

6. Copy the environment file:

   copy .env.example .env

7. Generate the application key:

   php artisan key:generate

8. Create a MySQL database named:

   iep_skkb

9. Configure `.env`:

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=iep_skkb
   DB_USERNAME=root
   DB_PASSWORD=

10. Import `database/sql/iep_skkb_demo.sql` through phpMyAdmin,
    or run:

    php artisan migrate --seed

11. Clear Laravel cache:

    php artisan optimize:clear

12. Start the Laravel server:

    php artisan serve

13. Open:

    http://127.0.0.1:8000

## Important Database Note

Do not run `php artisan migrate:fresh` when the database contains
important records because it removes all existing tables and data.