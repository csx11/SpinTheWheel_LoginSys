# PHP Project Setup Guide

This project uses **PHP** for backend development and **Intelephense** for code assistance.

---

## Requirements

Make sure you have the following installed:

- [PHP](https://www.php.net/downloads)
- [XAMPP](https://www.apachefriends.org/index.html) (for local PHP server & MySQL)
- [Visual Studio Code](https://code.visualstudio.com/)
- Intelephense Extension (VS Code Extension)

---

## How to Run the Project

### Install XAMPP (Includes PHP Server)

1. Download XAMPP from [XAMPP Official Website](https://www.apachefriends.org/index.html)  
2. Install it following the installer instructions.  
3. Open **XAMPP Control Panel**  
4. Start **Apache** (this runs your PHP server)  
5. Optional: Start **MySQL** if your project uses a database  

---

### Install Intelephense (VS Code)

1. Open **Visual Studio Code**  
2. Go to **Extensions**  
3. Search for **PHP Intelephense**  
4. Click **Install**  

> Intelephense provides **PHP IntelliSense, error checking, and code navigation**. It doesn’t run PHP — it only helps while coding.

---

### Disable Built-in PHP Language Features (Optional but Recommended)

1. Go to **Extensions** in VS Code  
2. Search for:  @builtin php
3. Disable **PHP Language Features**  
4. Leave **PHP Language Basics** enabled (for syntax highlighting)

> This prevents conflicts between VS Code’s default PHP support and Intelephense.

---

### 4️⃣ Run the PHP Project with XAMPP


1. Create a folder (e.g. your-project-folder)
2. Move your project folder into XAMPP’s `htdocs` directory, e.g.:
   
`C:\xampp\htdocs\your-project-folder`

3. Move the file `LoginSys.php` in the folder.
4. Open your browser and go to:

`http://localhost/your-project-folder/LoginSys.php`
