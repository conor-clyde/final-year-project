# Library Management System

A comprehensive Library Management System built with Laravel 10, featuring book cataloging, loan management, author tracking, and user administration.

## Features

- **Book Management**: Add, edit, archive, and delete books with detailed cataloging
- **Author Management**: Manage authors with full CRUD operations
- **Genre Management**: Organize books by genres with bulk operations
- **Publisher Management**: Track book publishers
- **Loan Management**: Handle book loans and returns
- **User Management**: Role-based access control (Admin, Librarian, Patron)
- **Data Export**: Export data to CSV format
- **Responsive Design**: Modern UI with Bootstrap and Tailwind CSS

## Technology Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Bootstrap 5, Tailwind CSS, Alpine.js
- **Database**: MySQL/PostgreSQL
- **JavaScript**: jQuery, DataTables
- **Authentication**: Laravel Breeze

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd final-year-project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   - Update `.env` file with your database credentials
   - Run migrations: `php artisan migrate`
   - Seed the database: `php artisan db:seed`

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## User Roles

- **Admin (role=3)**: Full access to all features including user management
- **Librarian (role=2)**: Access to book, author, genre, publisher, and loan management
- **Patron (role=0/1)**: Basic access to view catalog

## Database Structure

The system includes the following main entities:
- Users (with role-based access)
- Books (with copies and catalog entries)
- Authors (with soft deletes and archiving)
- Genres (with bulk operations)
- Publishers (with soft deletes and archiving)
- Loans (with return tracking)
- Staff and Patrons

## Key Features

### Book Management
- Create new books with multiple authors
- Track book copies and conditions
- Archive and restore books
- Export book lists

### Loan System
- Create and manage loans
- Track return dates
- Handle overdue books

### Data Integrity
- Soft deletes for data preservation
- Archive functionality for inactive records
- Validation rules for data consistency

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support, please contact the development team or create an issue in the repository.
