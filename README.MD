# Curjos Full Stack Assignment

This repository contains a small **full-stack application** built as part of the Curjos assignment.
The project is split into parts:

1. Backend
    A **REST API** using:
        - Symfony
        - Doctrine
        - Authentication using JWT
        - Authorization using Voters.

2. Frontend
   The frontend is a **single-page application** that consumes the backend API.
        - React, React-Router
        - TypeScript
        - Vite
        - TailWindCSS

---

### Database Diagram
A visual representation of the schema is available here:
![Database Diagram](/docs/db-diagram.png)

---

## Running the project with Docker Compose

The easiest way to test the project is using **Docker Compose**.  
This will start the backend API, frontend application, and database.

### Start the project

From the root of the repository, run:

```bash
docker compose build
docker compose up
```

The default urls are:

- http://localhost:3000 - Frontend
- http://localhost:8000 - Backend

You can change the container ports on compose.yaml.

---

## API Testing (Postman Collection)

A **Postman collection** is available in the [docs/Curjos-API.postman_collection.json](/docs/Curjos-API.postman_collection.json)  to help test the backend API.

### How to use the collection

1. Import the collection into Postman.
2. Run the **`/api/login`** request with valid credentials.
3. On successful login, the API returns a **JWT token**.
4. The collection automatically stores this token as a **global variable**.
5. All subsequent requests use this JWT for authentication.

### Access credentials
The Docker image has a pre-populated database, containing sample data for:

- Organizations
- Users
- Courses
- Course contents

This allows the application to be tested immediately, without any manual setup.

##### Admin access

Use the following credentials to log in as an administrator:

```json
{
    "username": "admin@gmail.com",
    "password": "12345678"
}
```

##### Organization managers

Each organization has an associated content manager account.

manager+`<organizationId>`@gmail.com

```json
{
    "username": "manager+1@gmail.com",
    "password": "12345678"
}
```

##### Students

Each organization also has students accounts.
student+`<organizationId>`@gmail.com

```json
{
    "username": "student+1@gmail.com",
    "password": "12345678"
}
```


All users have the same password `12345678`