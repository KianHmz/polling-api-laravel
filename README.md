# Polls API

This is a RESTful API built with Laravel for user authentication and managing polls. Users can register, login, create polls (admin only), vote on polls, and see poll results.

---

## Built With

![Laravel](https://img.shields.io/badge/Laravel-framework-red?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-dbms-orange?logo=mysql&logoColor=white)

---

## Features

-   User registration, login, logout with **Laravel Sanctum**
-   Role-based access with **middleware**
-   Admin: create, update, delete polls
-   Users: view polls, vote once
-   Validation + error handling (403, 404, 422, 500)
-   Postman collection included

---

## Postman Collection

You can import the Postman collection for easier testing and exploration:

1. Download the `public/etc/polls_api_postman_collection.json`.
2. Import to Postamn.
3. Set the `base_url`, `access_token`, and `pollId` variables.
4. Use the pre-configured requests.

---

## Installation & Running Locally (Laravel)

1. `git clone https://github.com/KianHmz/polling-api-laravel.git`
2. `composer install`
3. `cp .env.example .env`
4. `php artisan migrate`
5. `php artisan serve`
6. Access API at `http://localhost:8000/api`

---

## Base URL

```
https://your-api-domain.com/api
```

---

## Authentication

All endpoints (except register and login) require authentication via Bearer token (Laravel Sanctum).

---

## Endpoints

### Public (No Auth Required)

#### Register

-   **POST** `/register`
-   Request Body:
    ```json
    {
        "name": "John Doe",
        "email": "john@example.com",
        "password": "password",
        "password_confirmation": "password"
    }
    ```
-   Response:
    -   200 OK with access token on success
    -   422 Validation errors

#### Login

-   **POST** `/login`
-   Request Body:
    ```json
    {
        "email": "john@example.com",
        "password": "password"
    }
    ```
-   Response:
    -   200 OK with access token on success
    -   422 Validation errors

---

### Authenticated User Endpoints

Use the `Authorization: Bearer {access_token}` header for all requests.

#### Logout

-   **POST** `/logout`
-   Response:
    -   200 OK on success

#### Get Current User

-   **GET** `/user`
-   Response: User object JSON

#### List Active Polls

-   **GET** `/polls`
-   Response: Array of active polls that have not expired

#### Vote on a Poll

-   **POST** `/polls/{pollId}/vote`
-   Request Body:
    ```json
    {
        "choice": "Option Text"
    }
    ```
-   Responses:
    -   200 OK on success
    -   403 if poll inactive or user already voted
    -   404 if poll or option not found

#### Get Poll Results

-   **GET** `/polls/{pollId}/results`
-   Response:
    ```json
    {
      "poll": "Poll Title",
      "results": [
        {
          "choice_text": "Option 1",
          "votes_count": 5
        },
        ...
      ]
    }
    ```

---

### Admin Endpoints (Require `role:admin`)

#### Create Poll

-   **POST** `/polls`
-   Request Body:
    ```json
    {
        "title": "Favorite Food?",
        "description": "Choose your favorite food",
        "choices": ["Pizza", "Burger", "Pasta"],
        "status": "active",
        "expires_at": "2025-12-31T00:00:00Z"
    }
    ```
-   Response: Created poll JSON (201)

#### Update Poll

-   **PUT** `/polls/{pollId}`
-   Request Body (any subset):
    ```json
    {
        "title": "Updated Title",
        "description": "Updated description",
        "choices": ["Option 1", "Option 2"],
        "status": "inactive",
        "expires_at": "2025-11-30T00:00:00Z"
    }
    ```
-   Response: Updated poll JSON (201)

#### Delete Poll

-   **DELETE** `/polls/{pollId}`
-   Response:
    -   200 OK on success

---

## Error Handling

-   Validation errors return status `422` with details.
-   Not found resources return `404`.
-   Unauthorized actions return `403`.
-   Server errors return `500`.

---
