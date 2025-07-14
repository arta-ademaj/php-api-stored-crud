# PHP API with MySQL CRUD Using Stored Procedures

A RESTful PHP API built with Laravel that performs full CRUD (Create, Read, Update, Delete) operations on a `users` table using **MySQL stored procedures**.

---

## 🚀 Technologies Used

- **PHP 7.4.19**
- **Laravel 8.83.29**
- **MySQL 8+** (with stored procedures)
- **Docker & Docker Compose**
- **Composer**
- **Postman** (for testing API endpoints)

---

## 🛠️ Setup Instructions

### 1. Clone the Repository

```
git clone https://github.com/arta-ademaj/php-api-stored-crud.git
cd php-api-stored-crud
```

### 2. Install Dependencies

```
composer install
```

### 3. Create `.env` File

```
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your DB credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=company_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Create Database

Create a database named `company_db` (or the one you specified in `.env`) in MySQL:

```
CREATE DATABASE company_db;
```

### 5. Run Migrations

This project uses Laravel migrations to create both the database schema and the stored procedures. Run the following command:

```
php artisan migrate
```

This will:
- Create the `users` table
- Create the stored procedures needed for CRUD operations

---

### 6. Clear and Cache Configuration (Optional)

After updating your `.env` or configuration files, run:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

## 🐳 Running with Docker

### 1. Start Containers

```
docker-compose up -d --build
```

### 2. Install Dependencies inside the Container

```
docker exec -it laravel-app bash
composer install
php artisan key:generate
```

### 3. Access the App

Visit: [http://localhost:8000](http://localhost:8000)

---

## 🧱 Importing DB Schema and Stored Procedures

### 1. Connect to the MySQL Container

```
docker exec -it mysql-container mysql -u root -p
```

### 2. Import Schema and Procedures

Run the SQL script located in `database/schema.sql` (example):

```sql
SOURCE /docker-entrypoint-initdb.d/schema.sql;
```

Or from host (if you're not using Docker):

```
mysql -u root -p company_db < database/schema.sql
```

Make sure `schema.sql` includes:

- `CREATE TABLE users (...)`
- Stored procedures:
  - `get_all_users()`
  - `get_user_by_id(IN userId INT)`
  - `create_user(...)`
  - `update_user(...)`
  - `delete_user(IN userId INT)`

---

## 📬 API Endpoints (Example Requests)

**Authorization:**  
All endpoints require the header:  
Authorization: Bearer p2lbgWkFrykA4QyUmpHihzmc5BNzIABq

All requests use the base URL: `http://localhost:8000/api`

### ➕ Create a User

**POST** `/api/users`

```json
{
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com"
}
```

### 📥 Get All Users

**GET** `/api/users`

Optional query parameters for pagination:  
- `page` — the page number (e.g., `3`)  
- `per_page` — number of results per page (e.g., `4`)  

Example:  
**GET** `/api/users?page=3&per_page=4`

### 🔍 Get User by ID

**GET** `/api/users/{id}`

### ✏️ Update a User

**PUT** `/api/users/{id}`

```json
{
  "first_name": "Jane",
  "last_name": "Smith",
  "email": "jane@example.com"
}
```

### ❌ Delete a User

**DELETE** `/api/users/{id}`

---

## 🔐 Authentication

This API uses **API Key Bearer Token** authentication.

### How to Authenticate

Include the following header with every request to protected endpoints:
## 🧪 Testing the API
### Example

```bash
curl -H "Authorization: Bearer p2lbgWkFrykA4QyUmpHihzmc5BNzIABq" \
     -X GET http://localhost:8000/api/users
```


----

## 🧪 Testing the API

You can test the API using:

- [Postman](https://www.postman.com/)
- CURL
- Frontend client

Example with CURL:

```
curl -X GET http://localhost:8000/api/users
```

---

## 📁 Folder Structure Overview

```
app/
├── Http/
│   └── Controllers/
│       └── UserController.php
database/
├── schema.sql          <-- contains table + stored procedures
routes/
├── api.php             <-- API route definitions
```

---

## 📝 License

This project is licensed under the MIT License.