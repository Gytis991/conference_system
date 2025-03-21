# Conference Management System

This is a web-based **Conference Management System** built with Laravel. It supports multiple features such as:

- User registration/login
- Multiple roles support for one user
- Profile management: information update, email update, deletion
- Seeing the list of all current and past conferences

For users who have role **ADMIN** assigned:

- Conference creation
- Conference update (only before conference starts)
- Conference cancellation (only before conference starts)
- Viewing conference attendees
- Viewing users with client role

For users who have role **CLIENT** assigned:

- Registration to conferences (only before conference starts)
- Cancellation of registration to conferences
- Viewing history of all active and past conference registrations

## Prerequisites
Before setting up the project, ensure you have the following installed on your machine:

- **PHP** (>= 8.1)
- **MySQL** database ready to use
- **Composer** (latest version)
- **Node.js** (>= 16.x) & **npm**
- **Laravel** (latest version)

## Launching the App
Follow these steps to set up and run the **Conference Management System** locally.

### 1. Clone the Repository
Run this commands to clone the repository.
```sh
git clone https://github.com/Gytis991/conference_system.git
cd conference_system
```

### 2. Install Dependencies and Build
Install dependencies and build the application
```sh
composer install
npm install
npm run build
```

### 3. Set Up Environment Variables
Copy the `.env.example` file and rename it to `.env`:
```sh
cp .env.example .env
```
Then update the database credentials to your own inside the `.env`. You do not need to change other variables.

### 4. Generate Application Key
```sh
php artisan key:generate
```

### 5. Run Database Migrations
```sh
php artisan migrate --seed
```

### 6. Run Seeders for Data
This will create 5 users and 5 conferences
```sh
php artisan db:seed
```

### 7. (Optional) Run Automatic Tests
```sh
php artisan test
```

### 8. Start the Development Server
```sh
php artisan serve
```

### 9. Use the Application
Seeder file should create a user with both **client** and **admin** roles for you to use right away. Credentials to login:
```sh
EMAIL: admin@admin.com
PASSWORD: password123
```
If you decide to login with other seeded users, **password will be the same**. You can also register, but such self-registered users will only have **client** role.

Now your Laravel **Conference Management System** should be up and running!  

