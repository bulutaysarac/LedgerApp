
# LedgerApp API

## Overview

LedgerApp is a simple API that allows users to manage credits, transfer credits between users, and view balances. The API supports role-based authentication, ensuring that only authorized users can perform certain actions.

## Endpoints

### 1. Register a New User

#### Request
```sh
curl --location 'http://127.0.0.1:8000/api/register' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Test",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
}'
```

### 2. Add Credits to Users

#### Request
```sh
curl --location 'http://127.0.0.1:8000/api/admin/add-credits' \
--header 'Authorization: Bearer ADMIN_TOKEN' \
--header 'Content-Type: application/json' \
--data '{
    "user_id": 2,
    "amount": 100.00
}'
```

### 3. Get All Users' Balances

#### Request
```sh
curl --location 'http://127.0.0.1:8000/api/admin/all-balances' \
--header 'Authorization: Bearer ADMIN_TOKEN'
```

### 4. Get Individual User's Balance

#### Request
```sh
curl --location 'http://127.0.0.1:8000/api/balance' \
--header 'Authorization: Bearer USER_TOKEN'
```

### 5. Transfer Credits Between Users

#### Request
```sh
curl --location 'http://127.0.0.1:8000/api/transfer' \
--header 'Authorization: Bearer USER_TOKEN' \
--header 'Content-Type: application/json' \
--data '{
    "recipient_id": 3,
    "amount": 50.00
}'
```

### 6. Check User's Balance at a Given Time

#### Request
```sh
curl --location 'http://127.0.0.1:8000/api/admin/balance-at-time' \
--header 'Authorization: Bearer ADMIN_TOKEN' \
--header 'Content-Type: application/json' \
--data '{
    "user_id": 2,
    "time": "2024-06-30 18:55:17"
}'
```

## Authentication and Roles

- **Admin**: Can add credits to any user, view all users' balances, and check balances at a given time.
- **User**: Can view their own balance and transfer credits to other users.

## Best Practices for High Volume Transactions

The system keeps the `balance` column in the `users` table updated with each transaction. In case of any exception, the process is rolled back to prevent discrepancies between the user's balance and their transaction history.

## Setup and Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/your-repo/ledger-app.git
    cd ledger-app
    ```

2. Install dependencies:
    ```sh
    composer install
    ```

3. Copy `.env.example` to `.env` and configure your database:
    ```sh
    cp .env.example .env
    ```

4. Generate application key:
    ```sh
    php artisan key:generate
    ```

5. Run migrations:
    ```sh
    php artisan migrate
    ```

6. Seed the database with roles:
    ```sh
    php artisan db:seed --class=RolesTableSeeder
    ```

## Running the Application

Start the application using Laravel's built-in server:
```sh
php artisan serve
```

## Testing

You can use tools like Postman or cURL to test the endpoints as shown in the examples above.

## License

This project is open-source and available under the MIT License.
