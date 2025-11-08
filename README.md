# Library Management Web App (Final Year Project)

A full–stack web application built with **Laravel** for managing library books, categories/genres, and users.  
This was my final year university project, focusing on building a real role-based CRUD system using a modern PHP framework.

## Features

- Admin / standard user roles (role-based access)
- Manage books (create, update, delete, view)
- Manage genres/categories
- Borrow / return workflows
- Secure routing + middleware
- Server-side form validation

## Tech Stack

- Laravel (PHP Framework)
- PHP
- MySQL
- Blade Templates
- JavaScript

## What I Built / Learning Outcomes

- Designed & built a full CRUD application from scratch
- Implemented authentication + authorization
- Structured Laravel controllers, services, middleware, and views
- Used migrations + seeders to manage database schema

## Screenshots

_Adding screenshots here soon..._

(coming soon)

## Run Locally

```bash
git clone <repo-url>
cd final-year-project
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
