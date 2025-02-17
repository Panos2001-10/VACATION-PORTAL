# Vacation Portal

The Vacation Portal is a web-based application that allows employees to submit vacation requests and managers to approve or reject those requests. The system supports multiple managers, each with their own set of employees, making it easy to manage vacation requests within different teams. The portal also includes functionality for maintaining session-based user authentication.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technologies](#technologies)
- [Installation](#installation)
- [Usage](#usage)
- [Database](#database)
- [Screenshots](#screenshots)

## Overview
This project implements a simple vacation portal system using PHP, MySQL, and vanilla CSS. The system allows:
- Employees to submit vacation requests.
- Managers to view and manage vacation requests and can also create new users and delete existing ones.
- An employee portal to track vacation request status.
- User authentication with role-based access (Employee/Manager).

## Features
- **Login System**: Employee and manager authentication using session variables.
- **Employee Dashboard**: Employees can submit vacation requests and view the status of their requests.
- **Manager Dashboard**: Managers can view all employees in their team, approve/reject vacation requests, and manage(add, edit, and delete) employee records.
- **Message Notifications**: Users receive notifications on successful or failed actions (e.g., submitting requests, errors).


## Technologies
- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL
- **Server**: Apache (via Docker)

## Installation

To set up the project locally, follow the steps below:

### Prerequisites
- Docker
- Docker Compose
- PHP (with Apache)
- MySQL (via Docker image)

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/vacation-portal.git
    cd vacation-portal
    ```

2. Build and start the containers using Docker Compose:
    ```bash
    docker-compose up --build
    ```

    This will build the Docker images and start both the application and the database services.

3. Access the application:
    Open your browser and visit `http://localhost:8000` to use the application(every user currently has the same password: `123456`).

4. Set up the database:
    The database is automatically set up using the `vacation_db.sql` file provided. It will create necessary tables such as `users`, `requests`, and others.

## Usage

1. **Login**: When you visit the portal, you will be prompted to log in as either an Employee or a Manager.
2. **Employee Dashboard**: Employees can submit new vacation requests and view the status of their current requests.
3. **Manager Dashboard**: Managers can view, approve/reject vacation requests, and manage employee records (add/edit/delete users).

## Database

The database schema includes tables for:
- **users**: Stores employee information, including `employee_code`, `name`, `email`, `password`, `role` (employee/manager), and `manager_code`.
- **requests**: Stores vacation requests with fields like `id`, `employee_code`, `start_date`, `end_date`, `reason`, `status`, and `submitted_date`.

## Screenshots

Here are some screenshots of the application to give you a better idea of the user interface and how it works:

### Login Page
![image](https://github.com/user-attachments/assets/1ea136f4-8606-4a84-ad56-19d776b22e0a)
---

### Employee Dashboard
![image](https://github.com/user-attachments/assets/8467cdb9-efc1-4123-a234-41e2b3c8d95e)
---

### Vacation Request Form
![image](https://github.com/user-attachments/assets/5c8d63e2-0cb6-41f8-9680-9882db8c1de4)
---

### Manager Dashboard
![image](https://github.com/user-attachments/assets/3ed83e85-47eb-46a3-89ed-b5a096b9d9e1)
---

### Create New User Form
![image](https://github.com/user-attachments/assets/f3002835-4fc2-4c12-9a84-f1d50c82b887)
---

### Edit Existing User
![image](https://github.com/user-attachments/assets/049fc580-1ef2-48ce-8c65-81c461a6f39a)
---
