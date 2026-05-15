# Project Setup Guide

This file explains how to set up this Laravel ecommerce project on a new device from scratch.

## 1. Install the required software

Make sure the new device has these installed:

- PHP `8.2` or newer
- Composer
- Node.js and npm
- MySQL
- Git

You can verify them with:

```bash
php -v
composer --version
node -v
npm -v
mysql --version
git --version
```

## 2. Get the project code

Clone the repository to your machine:

```bash
git clone <your-repository-url>
cd ecom
```

If the project was copied manually instead of cloned, just open the project folder in your terminal.

## 3. Install PHP dependencies

Run:

```bash
composer install
```

## 4. Install frontend dependencies

Run:

```bash
npm install
```

## 5. Create the environment file

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows PowerShell, use:

```powershell
Copy-Item .env.example .env
```

## 6. Configure the `.env` file

Open `.env` and update the database values for your device:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecom
DB_USERNAME=root
DB_PASSWORD=
```

Important notes:

- Create a MySQL database named `ecom` before running migrations, or change `DB_DATABASE` to the database name you want to use.
- This project also includes mail-related settings such as `RESEND_API_KEY`. For local setup, you can leave those blank unless you want email sending to work.
- For local development, do not set `AWS_URL` unless you intentionally want to use cloud storage.

## 7. Generate the application key

Run:

```bash
php artisan key:generate
```

## 8. Create the database

Create the database in MySQL if it does not already exist.

Example:

```sql
CREATE DATABASE ecom;
```

You can do this from MySQL Workbench, phpMyAdmin, or the MySQL command line.

## 9. Run migrations and seeders

Run the database migrations:

```bash
php artisan migrate
```

Then seed the default roles and demo users:

```bash
php artisan db:seed
```

This project seeds these default login accounts:

- Super Admin: `admin@ecom.com` / `password`
- Admin: `admin.user@ecom.com` / `password`
- Editor: `editor@ecom.com` / `password`
- Viewer: `viewer@ecom.com` / `password`

Change these passwords after first login.

## 10. Create the storage link

Run:

```bash
php artisan storage:link
```

This is recommended so uploaded files from Laravel storage are publicly accessible.

## 11. Build frontend assets

For a one-time production-style build:

```bash
npm run build
```

For local development with live reload:

```bash
npm run dev
```

## 12. Start the Laravel application

In a separate terminal, run:

```bash
php artisan serve
```

Then open:

```text
http://127.0.0.1:8000
```

Admin login page:

```text
http://127.0.0.1:8000/login
```

## 13. Optional: run the full local development stack

The project includes a Composer shortcut that starts multiple development services together:

```bash
composer run dev
```

This starts:

- Laravel local server
- Queue listener
- Laravel log viewer
- Vite dev server

Use this if you want the full local workflow in one command.

## 14. Quick setup shortcut

This project also has a Composer setup script:

```bash
composer run setup
```

It runs these steps automatically:

- `composer install`
- copies `.env` if missing
- `php artisan key:generate`
- `php artisan migrate --force`
- `npm install`
- `npm run build`

Use it only after your database settings in `.env` are correct.

## 15. If Git shows a "dubious ownership" warning

On some new Windows devices, Git may show a safe directory warning. If that happens, run:

```bash
git config --global --add safe.directory "C:/Users/handmade handicraft/Desktop/Dev/ecom"
```

Only do this if you trust the project folder.

## 16. Common problems

### Database connection error

Check:

- MySQL is running
- `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` are correct in `.env`
- the database already exists

### Vite or frontend assets not loading

Run:

```bash
npm install
npm run dev
```

or build the assets again:

```bash
npm run build
```

### App key missing

Run:

```bash
php artisan key:generate
```

### Seeded users not available

Run:

```bash
php artisan db:seed
```

## 17. Recommended first checks after setup

After the project is running:

1. Open the homepage and confirm products page loads without errors.
2. Open `/login` and sign in with `admin@ecom.com`.
3. Change the default password immediately.
4. Open the admin dashboard and confirm categories, products, shipping, and blog sections load properly.

## Summary

For most new devices, the normal setup order is:

1. Install PHP, Composer, Node.js, npm, MySQL, and Git.
2. Clone the project.
3. Run `composer install`.
4. Run `npm install`.
5. Copy `.env.example` to `.env`.
6. Update database settings in `.env`.
7. Create the MySQL database.
8. Run `php artisan key:generate`.
9. Run `php artisan migrate`.
10. Run `php artisan db:seed`.
11. Run `php artisan storage:link`.
12. Run `npm run dev` and `php artisan serve`.

