# Job Portal Web Application

This is a comprehensive job portal application built with PHP, MySQL, and vanilla JavaScript. It follows industry best practices for security, performance, and maintainability.

## Features

*   **User Roles:** Admin, HR, and User with separate dashboards.
*   **Secure Authentication:** Password hashing (bcrypt), CSRF protection, secure sessions.
*   **Job Postings:** Separate systems for Private jobs (by any HR) and Sarkari notifications (by Admin/approved HR).
*   **Admin Panel:** User management, HR permission control, content moderation.
*   **SEO & Accessibility:** Clean URLs, semantic HTML, and a focus on navigability.
*   **Responsive Design:** Mobile-first CSS for a great experience on all devices.
*   **Shared Hosting Ready:** Optimized for environments like Hostinger.

## Setup & Deployment on Hostinger

Follow these steps to get the application running on your Hostinger account.

### Step 1: Database Setup

1.  Log in to your Hostinger hPanel.
2.  Navigate to **Databases** -> **MySQL Databases**.
3.  Create a new database. Note down the database name (e.g., `u123456789_dbname`).
4.  Create a new MySQL user. Use a strong, generated password and note it down.
5.  Add the new user to the new database, granting **all privileges**.
6.  Go to **phpMyAdmin** from the database section. Select your newly created database.
7.  Click the **Import** tab.
8.  Upload and import `database/create_tables.sql`. This will create the necessary table structure.
9.  Import `database/sample_data.sql` in the same way. This will add an admin user and some sample content.

### Step 2: Configuration

1.  In the project files, find `config.php.sample`.
2.  Rename it to `config.php`.
3.  Open `config.php` and fill in the database credentials you noted down in Step 1.

    ```php
    define('DB_HOST', 'localhost'); // Usually localhost on Hostinger
    define('DB_USER', 'u123456789_user');
    define('DB_PASS', 'YourStrongPassword');
    define('DB_NAME', 'u123456789_dbname');
    define('SITE_URL', 'https://yourdomain.com');
    ```

### Step 3: Upload Files

1.  Connect to your Hostinger account via FTP (using a client like FileZilla) or use the **File Manager** in hPanel.
2.  Navigate to the `public_html` directory.
3.  Upload all the project files and folders into `public_html`. The `.htaccess` file should be directly inside `public_html`.

### Step 4: Test the Application

1.  Visit `https://yourdomain.com` in your browser. You should see the homepage.
2.  Go to `/login` and log in with the default admin credentials:
    *   **Email:** `admin@example.com`
    *   **Password:** `password123`
3.  You should be redirected to the Admin Dashboard.

### How to Grant an HR Sarkari Posting Rights

1.  Log in as the admin.
2.  Navigate to the Admin Dashboard and click on "Manage Users & HR Permissions".
3.  Find the HR user you want to grant access to.
4.  Click the **"Grant Sarkari Access"** button next to their name.
