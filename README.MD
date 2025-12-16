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
