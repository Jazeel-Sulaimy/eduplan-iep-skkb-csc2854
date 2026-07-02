# IEP SKKB Parent and Teacher Workflow Update

This update modifies the existing Laravel 12 project without replacing its EduPlan interface.

## Main additions

- Public parent self-registration linked to an existing student by student name and IC.
- Parent login using User ID or email.
- Parent **My Children**, IEP, progress, behaviour, consent and report access restricted to linked children.
- Teacher **My Students** page restricted to assigned students.
- Working School Administrator assignment form for teacher, counsellor and parent.
- Laravel 12 role middleware and controller-level student authorization.
- New English and Malay translations for the workflow.
- Feature tests for registration, login, assignment and authorization.

## Run commands

```bash
composer install
php artisan optimize:clear
php artisan migrate
php artisan route:list
php artisan test
php artisan serve
```

Use `php artisan migrate`, not `migrate:fresh`, when preserving existing data.

## Parent registration demo

1. Confirm that the student already exists and has no parent account linked.
2. Open `/parent/register` or click **Register as Parent** on the login page.
3. Enter the parent details and the exact student name and student IC.
4. Submit the form and copy the generated parent User ID.
5. Log in using either the generated User ID or parent email.

## School Administrator assignment demo

1. Log in as `ADMIN001`.
2. Open **Assign Staff**.
3. Select a student.
4. Select a teacher, counsellor and parent account.
5. Select review frequency, enter notes and save.

## Teacher My Students demo

1. Log in as `TEACHER001`.
2. Open **My Students**.
3. Only students assigned to that teacher are displayed.
4. Use the action links to open a profile, add an IEP goal, record behaviour or record progress.

## SQLite note

The uploaded SQLite file contained only the default empty Laravel schema and did not match this project’s custom migrations. It is preserved as `database/database.sqlite.backup`. A clean `database/database.sqlite` is included so `php artisan migrate` can create the correct schema when SQLite is selected.
