# Bangla Travel Spot — Raw PHP Tourism Platform

A responsive destination discovery and trip-planning application built with **Core/Raw PHP, MySQL, HTML, CSS and vanilla JavaScript**. No Laravel, framework or Composer package is required.

## Included features
- Home page with featured destinations
- Destination search, category and budget filters
- Destination detail with overview, transport, accommodation, activities, gallery, budget and reviews
- Separate user and admin login portals with role-based access
- User dashboard, favorites, trip plans, reviews and profile settings
- Admin dashboard, destination CRUD, category management, user blocking, review moderation and contact messages
- PDO prepared statements, password hashing, CSRF tokens, output escaping and session ID regeneration

## Requirements
- PHP 8.0+ (8.1+ recommended)
- MySQL 5.7+ / MariaDB 10.4+
- Apache (XAMPP/WAMP/Laragon)

## Installation (XAMPP)
1. Extract the `Bangla-Travel-Spot` folder into `C:\xampp\htdocs\`.
2. Start Apache and MySQL.
3. Open `http://localhost/phpmyadmin` and create/import the database by importing `database.sql`.
4. Open `config.php` and confirm DB settings. Default XAMPP settings are `root` with an empty password.
5. Keep `BASE_URL` as `/Bangla-Travel-Spot` if the folder name is unchanged. If hosted in another folder/domain, update it.
6. Visit `http://localhost/Bangla-Travel-Spot/`.

## Admin login
- Open `http://localhost/Bangla-Travel-Spot/admin/login.php`.
- Email: `admin@explorebangladesh.test`
- Password: `password`

**Important:** Change the default admin password immediately after first login. This is a demo credential for local installation only.

## User login
- Open `http://localhost/Bangla-Travel-Spot/auth/login.php` to sign in as a user.
- Create a user account at `http://localhost/Bangla-Travel-Spot/auth/register.php`.
- User accounts can save destinations, plan trips, submit reviews and update their profile. Administrators use the separate admin portal to manage the site.

## Adding destinations
Login as admin → Manage Places → Add New Destination. Add a remote image URL or a relative path such as `uploads/places/cox.jpg`. For reliable production use, upload optimized images to the uploads folder using your hosting file manager. The seed places use Unsplash image URLs and therefore need internet access to display those photos.

## Production checklist
- Change the database password and admin password.
- Set `BASE_URL` correctly.
- Enable HTTPS and secure session cookie settings in production.
- Configure PHP upload limits and add an authenticated image-upload handler before allowing public file uploads.
- Back up the database and uploads directory regularly.
- Consider adding email verification, password reset and pagination before public launch.

## Project structure
- `config.php` — database connection and base URL
- `includes/` — shared helpers, header and footer
- `auth/` — registration, login and logout
- `user/` — account dashboard, favorites, trips, reviews, profile
- `admin/` — admin dashboard and management modules
- `assets/` — CSS and JavaScript
- `database.sql` — schema, starter categories, destinations and admin account
