# ⚖️ Law Firm Management System

A robust **role-based web application** designed to streamline legal service operations by connecting **Clients, Lawyers, and Admins** in a centralized system.

Built using **PHP, MySQL, HTML, CSS**, and deployed locally with **XAMPP**, this project demonstrates full-stack development with authentication, session management, and CRUD operations.

---

## 🚀 Key Features

### 👤 Client Panel

* Secure registration & login system
* Browse and view lawyer profiles
* Book appointments easily
* Track appointment status

### ⚖️ Lawyer Panel

* View and manage appointment requests
* Interact with client bookings
* Update availability and profile details

### 🛠️ Admin Panel

* Full system control and monitoring
* Approve or reject lawyer registrations
* Manage all appointments
* Maintain platform integrity

---

## 🧠 Core Functionalities

* 🔐 **Session-Based Authentication System**
* 👥 **Role-Based Access Control (Client / Lawyer / Admin)**
* 📅 **Appointment Scheduling & Management**
* 🗂️ **CRUD Operations for All Entities**
* ⚡ **Dynamic Data Handling with PHP & MySQL**

---

## 🏗️ Tech Stack

| Layer    | Technology |
| -------- | ---------- |
| Frontend | HTML, CSS  |
| Backend  | PHP        |
| Database | MySQL      |
| Server   | XAMPP      |

---

## 📂 Project Structure

```
📁 Law-Firm-System
│
├── 📁 uploads/                # File uploads
├── 📁 style/                  # CSS styles
│
├── 📄 admin_dashboard.php
├── 📄 admin_login.php
├── 📄 admin_lawyers.php
├── 📄 appointment.php
├── 📄 approve_appointment.php
├── 📄 approve_lawyer.php
├── 📄 client-login.html
├── 📄 client_logout.php
├── 📄 contact.html
├── 📄 db.php                  # Database connection
├── 📄 delete_appointment.php
├── 📄 delete_lawyer.php
├── 📄 LawyerCard.php
├── 📄 SignUp.html
│
└── ...
```

---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/your-username/law-firm-system.git
```

### 2️⃣ Move to XAMPP Directory

```
C:\xampp\htdocs\
```

### 3️⃣ Start XAMPP Services

* Apache ✅
* MySQL ✅

### 4️⃣ Setup Database

* Open **phpMyAdmin**
* Create a new database (e.g., `law_firm`)
* Import the provided `.sql` file



---

## 🔐 User Roles Overview

| Role   | Access Level               |
| ------ | -------------------------- |
| Client | Book & manage appointments |
| Lawyer | Handle requests & profile  |
| Admin  | Full system control        |

---

---

## 💡 Future Enhancements

* 💳 Payment Integration (Stripe)
* 🔔 Real-time Notifications
* 🔍 Advanced Search & Filtering
* ☁️ Cloud Deployment (AWS / VPS)
* 📱 Mobile Responsive Improvements

---

## 👨‍💻 Author

**Md. Fahim Shahriyar Pranto**

---



## 📜 License

This project is licensed under the **MIT License**.
