# Clinic Management System

A full-stack Clinic Management System built using **HTML**, **JavaScript**, **PHP**, and **MySQL**. It supports role-based access for Admins, Receptionists, and Inventory Managers. The system provides modules for Appointment Scheduling, Billing, Department Management, Employee Records, Inventory Tracking, Patient Registration, Patient Medicine Allocation, and User Management.

---

## 🔧 Features

- **Modular design** — each feature/module is separated by functionality
- **Role-based UI** — Admin, Reception, and Inventory dashboards
- **Dynamic Forms** — Add/Edit using popup forms
- **Centralized Controller** — Handles all backend logic through `master_controller.php`
- **Database Integration** — MySQL support with SQL setup files
- **Frontend-Backend Communication** — Using `fetch` and JSON

---

## 🗂️ Project Structure

```bash
ClinicManagementSystem/
│
├── Controller/                      # PHP backend handlers
│   ├── master_controller.php
│   ├── appointment_select.php
│   ├── billing_select.php
│   ├── department_select.php
│   ├── employee_select.php
│   ├── Inventory_select.php
│   ├── patient_medicine_select.php
│   ├── patient_select.php
│   └── user_select.php
│
├── View/                           # All frontend UI and client-side logic
│   ├── AppointmentModule/
│   │   ├── Appointment_page.html
│   │   ├── Appointment_form.html
│   │   └── Appointment.js
│   │
│   ├── BillingModule/
│   │   ├── Billing_page.html
│   │   ├── Billing_form.html
│   │   └── Billing.js
│   │
│   ├── DepartmentModule/
│   │   ├── Department_page.html
│   │   ├── Department_form.html
│   │   └── Department.js
│   │
│   ├── EmployeeModule/
│   │   ├── Employee_page.html
│   │   ├── Employee_form.html
│   │   └── Employee.js
│   │
│   ├── InventoryModule/
│   │   ├── Inventory_page.html
│   │   ├── Inventory_form.html
│   │   └── Inventory.js
│   │
│   ├── PatientMedicineModule/
│   │   ├── PatientMedicine_page.html
│   │   ├── PatientMedicine_form.html
│   │   └── PatientMedicine.js
│   │
│   ├── PatientRegistrationModule/
│   │   ├── Registration_page.html
│   │   ├── Registration_form.html
│   │   └── Registration.js
│   │
│   ├── UserModule/
│   │   ├── User_page.html
│   │   ├── User_form.html
│   │   └── User.js
│   │
│   ├── HomePageModule/
│   │   ├── AdminHomePage.html
│   │   ├── ReceptionHomePage.html
│   │   ├── InventoryHomePage.html
│   │   └── homePage.js
│   │
│   ├── login_page_2.html
│   ├── login_page_2.js
│   └── Images/                     # Icons and media used in the UI
│       ├── add.jpeg
│       ├── appointment.jpg
│       ├── billing.jpg
│       ├── department.jpg
│       ├── doctor.png
│       ├── inventory.jpg
│       ├── medical.png
│       ├── patient-medicine.jpg
│       ├── registration.png
│       ├── search.jpg
│       ├── second_healthcare.jpg
│       └── user.png
│
├── Database/                       # Contains DB schema and seed data
│   ├── create.sql
│   └── load.sql
│
└── README.md
```

---

## 🛠️ How to Run the Project

### 1. **Environment Requirements**

- XAMPP / WAMP / MAMP or any local web server
- PHP >= 7.4
- MySQL/MariaDB

### 2. **Steps to Set Up**

#### ✅ Option 1: XAMPP (Recommended)

1. Download and install XAMPP: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
2. Start **Apache** and **MySQL** from XAMPP Control Panel
3. Place the project folder inside `htdocs/`
   ```bash
   C:/xampp/htdocs/ClinicManagementSystem
   ```
4. Import the Database:
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin`)
   - Create a new database (e.g., `clinic_db`)
   - Run `create.sql` and then `load.sql` from the `Database/` folder

#### ✅ Option 2: Manually (Linux/Mac)

1. Clone the repository:
   ```bash
   git clone https://github.com/shyamc757/ClinicManagementSystem.git
   ```
2. Move into the project and configure Apache + PHP + MySQL
3. Import database into MySQL using the `Database/` SQL files

---

## ⚙️ Configuring the Environment

- If your environment differs, update DB credentials in `Controller/master_controller.php`
  ```php
  $username = "root";
  $password = "root";
  $database = "clinic_db";
  ```
- Make sure your JS `fetch` URLs point to the correct file paths (e.g., `../../Controller/master_controller.php`)

---

## 👥 User Roles (Hardcoded for Demo)

| Username | Password | Role              |
| -------- | -------- | ----------------- |
| admin    | admin    | Admin Dashboard   |
| recp     | recp     | Reception Module  |
| invm     | invm     | Inventory Manager |

You can expand login logic to connect with the User table and Employee table in the database.

---

## 📊 Data Source

The sample data used in this project was **randomly generated using [Mockaroo](https://www.mockaroo.com/)**. Minor adjustments were made to ensure **referential integrity** between tables (e.g., matching foreign keys). This is **not real-world data**.

---

## 🧾 License
This project is open-source and available under the **MIT License**.
Feel free to fork, modify, and contribute!

