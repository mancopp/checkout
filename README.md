
# Checkout

This is a web application built using Laravel, Vue.js, and Tailwind CSS to provide a feature-rich and user-friendly checkout form. The checkout form allows customers to input various details related to their account, personal data, delivery address, and choose delivery and payment methods. Additionally, customers have the option to apply discount codes to avail discounts. The form validates user inputs both on the frontend and backend, ensuring data integrity and a seamless user experience.

## Table of Contents

- [Technologies Used](#technologies-used)
- [Additional Features](#additional-features)
- [Installation & Usage](#installation-and-usage)
- [Technologies Used](#technologies-used)
- ["Most Changes" Folders](#most-changes-folders)

## Technologies Used

- Laravel v10.10 - A powerful PHP framework for building web applications.
- Vue.js v3.2 - A progressive JavaScript framework for building user interfaces.
- Tailwind CSS v3.3 - A utility-first CSS framework for creating custom and responsive designs.

## Additional Features
- **Login:** Button "Log in" shows the login modal

- **Tests:** Tests are included in project's source

- **Discount Code:** Customers have the option to apply a discount code during checkout to avail discounts.

- **Frontend Validation:** User inputs are validated on the frontend to provide immediate feedback to users and prevent invalid data submissions.

- **Backend Validation:** The submitted data is validated on the backend to ensure data integrity and security.

## Installation and Usage

#### Install dependencies

1. Install front-end dependencies

```bash
npm i
```

2. Install back-end dependencies

```bash
composer update
```

#### Set up the environment

3. Edit database credentials in `.env.example` and rename the file to `.env`
4. Generate an app key

```bash
php artisan key:generate
```

5. Execute database migrations

```bash
php artisan migrate
```

6. Seed the database with necessary data

```bash
php artisan db:seed --class=InitialSeeder
```

#### Run

7. Start the back-end server

```bash
php artisan serve
```

8. Start the front-end server

```bash
npm run dev
```

#### Tests

To run all the tests:

```bash
php artisan test
```

## "Most Changes" Folders

```
laravel-project/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
└── tests/
```
