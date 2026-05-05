<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<!-- <p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p> -->

# Gym Membership Management System

A comprehensive web application built with **Laravel** designed to manage gym operations, including member registrations, membership plans, trainer assignments, class bookings, and payment tracking.

---

## 🚀 Features

### **Admin Dashboard**
*   **Member Management**: Full CRUD operations for gym members.
*   **Trainer Management**: Manage fitness instructors and their specialties.
*   **Membership Plans**: Create and customize various tiers of membership (e.g., Monthly, Yearly).
*   **Class Scheduling**: Organize and manage gym classes (Yoga, HIIT, etc.).
*   **Booking Tracking**: Monitor class attendance and bookings.
*   **Payment Monitoring**: View and verify member payments.

### **Member Portal**
*   **Authentication**: Secure registration and login for gym members.
*   **Personal Profile**: Update personal details and profile photos.
*   **Membership Status**: View active plans and renewal dates.
*   **Class Booking**: Browse available classes and book spots.
*   **Payments**: Submit and track payment history.

---

## 🛠️ Tech Stack

*   **Framework**: Laravel (PHP)
*   **Frontend**: Blade Templates, CSS, JavaScript (Vite)
*   **Database**: MySQL / SQLite
*   **Deployment**: Docker-ready, Render/Railpack support

---

## 💻 Installation Guide

### **Prerequisites**
*   PHP $\ge$ 8.1
*   Composer
*   Node.js & NPM
*   MySQL or SQLite

### **Steps**

1.  **Clone the repository**
    ```bash
    git clone https://github.com/Devaaa01/gym-membership.git
    cd gym-membership
    ```

2.  **Install dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    ```
    *Update the `.env` file with your database credentials.*

4.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

5.  **Run Migrations & Seeders**
    
    ```bash
    php artisan migrate --seed
    ```

6.  **Link Storage**
    ```bash
    php artisan storage:link
    ```

7.  **Compile Assets & Start Server**
    ```bash
    npm run dev
    # In a new terminal:
    php artisan serve
    ```

---

## 🐳 Docker Support

The project includes a `Dockerfile` and `docker-start.sh` for easy containerization.

```bash
docker build -t gym-membership .
docker run -p 8000:80 gym-membership
```

---

## 📂 Project Structure Highlights

*   **`app/Http/Controllers/Admin`**: Contains logic for administrative tasks.
*   **`app/Http/Controllers/Member`**: Handles member-specific portal logic.
*   **`app/Models`**: Includes models for `Member`, `MembershipPlan`, `Trainer`, `GymClass`, `Payment`, etc.
*   **`resources/views`**: Organized Blade templates for Admin, Member, and Auth views.
*   **`database/migrations`**: Database schema definitions.

---

## 📄 License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
