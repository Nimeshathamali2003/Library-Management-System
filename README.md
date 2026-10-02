# 📚 Library Management System

A web-based Library Management System developed for the **Advanced Technological Institute (ATI) – Tangalle** to automate and streamline daily library operations.

---

## 📋 About the Project

The Library Management System is a web-based application designed to replace the traditional manual record-keeping methods with an efficient, accurate, and user-friendly digital solution. It provides three distinct user roles: **Admin**, **Librarian**, and **Member**.

---

## 🎯 Objectives

- To develop a user-friendly Library Management System for ATI Tangalle
- To automate core library functions such as book issuing, returning, and cataloging
- To maintain accurate records of all books, members, and transactions
- To reduce manual errors and improve overall efficiency
- To implement an automatic fine calculation system for overdue books
- To provide a secure login system with role-based access

---

## 🛠️ Technologies Used

| Component | Technology |
|-----------|-----------|
| **Frontend** | HTML, CSS, Bootstrap 5, JavaScript |
| **Backend** | PHP |
| **Database** | MySQL |
| **Server** | Apache (XAMPP) |
| **IDE** | VS Code |
| **OS** | Windows 10 |

---

## ✨ Key Features

- 📚 **Book Management** – Add, view, update, and mark books as damaged
- 👥 **Member Management** – Register, view, and remove library members
- 📖 **Borrowing & Returning** – Issue and accept books with due dates
- 🔖 **Book Reservation** – Reserve unavailable books
- 💰 **Automatic Fine Calculation** – Fines for overdue books
- ⏰ **Overdue Tracking** – Books overdue by more than 7 days
- 🔍 **Search Function** – Search by title, author, or category
- 📊 **Real-time Reports** – Reports on books, members, borrowings
- 🔐 **Secure Login** – Role-based access (Admin / Librarian / Member)
- 👤 **Member Dashboard** – Members view their own data

---

## 🗄️ Database Tables

1. **Users** – Member details (user_id, name, email, role, password)
2. **Category** – Book categories (category_id, category_name)
3. **Books** – Book details (book_id, title, author, category_id, quantity, status)
4. **Borrow** – Borrowing transactions (borrow_id, user_id, book_id, borrow_date, return_date, status)
5. **Reservation** – Book reservations (reservation_id, user_id, book_id, reservation_date, status)
6. **Fine** – Fine details (fine_id, borrow_id, amount, status)

---

## 🚀 How to Run

1. Install **XAMPP**
2. Copy the project folder to `C:\xampp\htdocs\`
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`)
4. Import the `library_management_db.sql` file
5. Open browser and go to `http://localhost/library_system`

---

## 📸 Screenshots

### Login Page
![Login](screenshots/login.png)

### Admin Dashboard
![Admin Dashboard](screenshots/admin_dashboard.png)

### View Books
![View Books](screenshots/view_books_admin.png)

### Borrow Book
![Borrow Book](screenshots/borrow_book.png)

### Fine Calculation
![Fine Calculation](screenshots/fine_calculation.png)

---

## 📏 System Rules

- A member can borrow a maximum of **5 books** at a time
- The same book copy cannot be borrowed twice
- Automatic fine calculation for late returns

---

## 👩‍💻 Author

**U.G. Nimesha Thamali**

- **Reg No:** TAN/IT/2324/F/0044
- **Institution:** SLIATE – Advanced Technological Institute, Tangalle
- **Email:** nimeshathamali151@gmail.com

---

## 📄 License

This project is submitted in partial fulfillment of the requirements for the **Higher National Diploma in Information Technology** at Advanced Technological Institute, Tangalle, Sri Lanka.

---

## 🙏 Acknowledgements

- **Supervisor:** Mr. MAM Altaf
- **Head of Department:** Mr. G.R.C. Kumara
- Advanced Technological Institute (ATI) – Tangalle
