# 🏙️ CityWatch - Smart Urban Issue Reporting System

![CityWatch Banner](https://img.shields.io/badge/CityWatch-Smart%20Urban%20Reporting-blue?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 📋 Overview

**CityWatch** is a web-based smart urban issue reporting system designed to bridge the gap between citizens and municipal authorities. Built for **Dhaka, Bangladesh**, it enables residents to report urban problems like damaged roads, waste management issues, and public safety concerns directly to authorities.

The platform features a **multi-role authentication system** (Citizen, Authority, Admin) with real-time issue tracking, voting mechanisms, announcement systems, and **dynamic toast notifications**.

---

## ✨ Key Features

### 👤 **For Citizens**
- 📝 Report urban issues with image uploads
- 🗳️ Upvote/downvote community issues
- 👁️ Track issue status (Pending → Reviewed → Resolved)
- 🔔 View announcements from authorities
- 👤 Manage profile and change password
- ✏️ Edit/delete submitted reports
- 🔔 Real-time toast notifications for actions

### 🏛️ **For Authorities**
- 📊 Dashboard with statistics
- 📢 Create public announcements
- 👁️ View and manage reported issues
- 📍 Filter issues by location/status
- 🔔 Instant feedback notifications

### 🛡️ **For Admins**
- 👥 Manage users (Citizens & Authorities)
- ✅ Approve/reject reported issues
- 📢 Manage announcements
- 🚫 Block/unblock user accounts
- 📊 View system-wide analytics
- 🗑️ AJAX-powered delete operations
- 🔔 **Toast notification system** for all actions
- 💾 User preference management (search, sort, filters)

---

## 🛠️ Technology Stack

### **Frontend**
- ![HTML5](https://img.shields.io/badge/-HTML5-E34F26?logo=html5&logoColor=white) **HTML5** - Semantic markup and page structure
- ![CSS3](https://img.shields.io/badge/-CSS3-1572B6?logo=css3&logoColor=white) **CSS3** - Responsive styling, animations, and transitions
- ![JavaScript](https://img.shields.io/badge/-JavaScript-F7DF1E?logo=javascript&logoColor=black) **JavaScript** - Client-side validation, AJAX requests, slider functionality, **notification system**

### **Backend**
- ![PHP](https://img.shields.io/badge/-PHP-777BB4?logo=php&logoColor=white) **PHP 7+** - Server-side logic and MVC architecture
- ![MySQL](https://img.shields.io/badge/-MySQL-4479A1?logo=mysql&logoColor=white) **MySQL** - Relational database management

### **Architecture**
- **MVC Pattern** - Model-View-Controller separation
- **Session Management** - Secure user authentication
- **Cookie-based Remember Me** - Persistent login
- **AJAX/JSON** - Asynchronous operations
- **Toast Notifications** - Real-time user feedback system

---

## 📁 Project Structure

```
CityWatch-Smart-Urban-Issue-Reporting-System/
│
├── Controller/               # Business logic & request handlers
│   ├── AuthController.php    # Login, signup, remember-me
│   ├── AdminController.php   # Admin CRUD operations
│   ├── IssueController.php   # Issue submission & approval
│   ├── VoteController.php    # Upvote/downvote system
│   ├── AnnouncementController.php
│   ├── ajax.js               # AJAX utilities & notification system
│   ├── home.js               # Homepage slider
│   └── signup.js             # Form validation
│
├── Model/                    # Database interactions
│   ├── db.php                # Database connection
│   ├── UserModel.php         # User operations
│   ├── IssueModel.php        # Issue management
│   ├── VoteModel.php         # Voting system
│   ├── AdminModel.php        # Admin operations
│   └── AnnouncementModel.php
│
├── View/                     # User interface
│   ├── home.php              # Public landing page
│   ├── login.php             # Login page
│   ├── signup.php            # Registration
│   ├── *.css                 # Stylesheets
│   ├── Admin/                # Admin dashboard views
│   ├── Citizen/              # Citizen dashboard views
│   └── Authority/            # Authority dashboard views
│
├── Images/                   # Uploaded images
│   └── profiles/             # User profile pictures
│
└── index.php                 # Entry point & routing
```

---

## 🚀 Installation & Setup

### **Prerequisites**
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx web server
- XAMPP/WAMP (recommended for local development)

### **Step 1: Clone Repository**
```bash
git clone https://github.com/ShahadatHossainShoumik/CityWatch-Smart-Urban-Issue-Reporting-System.git
cd CityWatch-Smart-Urban-Issue-Reporting-System
```

### **Step 2: Database Setup**
1. Create MySQL database:
```sql
CREATE DATABASE citywatch;
```

2. Import database schema:
```sql
USE citywatch;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    mobile VARCHAR(15),
    nid VARCHAR(20),
    dob DATE,
    role ENUM('citizen', 'authority', 'admin') DEFAULT 'citizen',
    profile_image VARCHAR(255),
    is_blocked TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Issues table
CREATE TABLE issues (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(200),
    description TEXT,
    location VARCHAR(255),
    image VARCHAR(255),
    status ENUM('pending', 'reviewed', 'resolved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Votes table
CREATE TABLE votes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    issue_id INT,
    user_id INT,
    vote ENUM('up', 'down'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (issue_id, user_id)
);

-- Announcements table
CREATE TABLE announcements (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200),
    message TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);
```

### **Step 3: Configure Database Connection**
Edit `Model/db.php`:
```php
<?php
$host = "localhost";
$user = "root";
$pass = ""; // Your MySQL password
$db_name = "citywatch";
$port = 3306;
?>
```

### **Step 4: Start Server**
```bash
# Using PHP built-in server
php -S localhost:8000

# Or place in XAMPP htdocs folder and access via:
# http://localhost/CityWatch-Smart-Urban-Issue-Reporting-System
```

### **Step 5: Access Application**
```
http://localhost:8000/View/home.php
```

---

## 🎯 Usage Guide

### **Default Login Credentials**
After database setup, create an admin account:
```sql
INSERT INTO users (name, email, password, role) 
VALUES ('Admin', 'admin@citywatch.com', 'admin123', 'admin');
```

### **User Roles**
1. **Citizen** - Register via signup page
2. **Authority** - Created by admin
3. **Admin** - Database seeded account

---

## 🏗️ System Architecture

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ HTTP/AJAX
       ▼
┌─────────────────────┐
│   index.php         │  ◄── Entry Point
│   (Routing)         │
└──────┬──────────────┘
       │
       ▼
┌─────────────────────┐
│   Controllers       │  ◄── Business Logic
│   - Auth            │
│   - Issue           │
│   - Admin           │
│   - Vote            │
└──────┬──────────────┘
       │
       ▼
┌─────────────────────┐
│   Models            │  ◄── Database Layer
│   - UserModel       │
│   - IssueModel      │
│   - VoteModel       │
└──────┬──────────────┘
       │
       ▼
┌─────────────────────┐
│   MySQL Database    │  ◄── Data Storage
│   - users           │
│   - issues          │
│   - votes           │
│   - announcements   │
└─────────────────────┘
```

---

## 🔔 **Notification System**

The application features a **custom-built toast notification system** powered by JavaScript:

### **Features:**
- ✅ **Success notifications** (green) - Confirmations for successful operations
- ❌ **Error notifications** (red) - Alerts for failed operations
- ⏱️ **Auto-dismiss** - Notifications disappear after 3 seconds
- 🎬 **Smooth animations** - Slide-in/slide-out effects
- 📍 **Non-intrusive** - Fixed position at top-right corner

### **Implementation:**
```javascript
// Show success notification
showNotification('Issue submitted successfully!', 'success');

// Show error notification
showNotification('Failed to delete user', 'error');
```

### **Use Cases:**
- User account management (add/edit/delete)
- Issue submission and updates
- Vote actions (upvote/downvote)
- Announcement creation
- Block/unblock operations
- Form validation feedback

---

## 👥 Contributors

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/MH-SHUVO20">
        <img src="https://avatars.githubusercontent.com/u/125986989?v=4" width="100px;" alt="MH SHUVO"/>
        <br />
        <sub><b>MH SHUVO</b></sub>
      </a>
      <br />
      <sub>6 commits</sub>
      <br />
      <sub>
        💻 Backend Development<br/>
        🐛 Bug Fixes<br/>
        🔐 Authentication System<br/>
        ⚡ AJAX Operations<br/>
        🔔 Notification System<br/>
        🎨 UI Enhancements
      </sub>
    </td>
    <td align="center">
      <a href="https://github.com/ShahadatHossainShoumik">
        <img src="https://avatars.githubusercontent.com/u/242239238?v=4" width="100px;" alt="Shahadat Hossain Shoumik"/>
        <br />
        <sub><b>Shahadat Hossain Shoumik</b></sub>
      </a>
      <br />
      <sub>2 commits</sub>
      <br />
      <sub>
        🎨 Frontend (HTML/CSS/JS)<br/>
        ✨ UI/UX Design<br/>
        ✅ Form Validation<br/>
        🐛 Bug Fixes<br/>
        ⚙️ Code Optimization
      </sub>
    </td>
  </tr>
</table>

### **Contribution Breakdown**

#### **MH SHUVO** ([@MH-SHUVO20](https://github.com/MH-SHUVO20))
- Implemented backend controllers (Admin, Issue, Vote, Announcement)
- Developed AJAX/JSON operations for dynamic updates
- **Built custom toast notification system with animations**
- Built remember-me cookie authentication system
- Fixed critical bugs in signup and database connections
- **Added user preference management (search, sort, filters)**
- **Implemented notification system and voting visualization**
- Comprehensive code comments and documentation

#### **Shahadat Hossain Shoumik** ([@ShahadatHossainShoumik](https://github.com/ShahadatHossainShoumik))
- Designed responsive frontend using HTML5/CSS3
- Implemented JavaScript form validation (signup.js)
- Created user interface for all dashboards
- Developed slider functionality for homepage
- Bug fixes and performance optimization
- System testing and refinement

---

## 🔒 Security Features

- ✅ Prepared statements (SQL injection prevention)
- ✅ Password hashing with secure algorithms
- ✅ Session-based authentication
- ✅ HttpOnly cookies for remember-me
- ✅ Role-based access control (RBAC)
- ✅ Password validation (client & server-side)
- ✅ **File upload validation** (MIME type checking: JPG/PNG only, size limits: 2-5MB)
- ✅ XSS protection via htmlspecialchars()

---

## 🐛 Known Issues & Future Enhancements

### **Current Limitations**
- No email verification system

### **Planned Features**
- 📧 Email notifications for issue updates
- 📱 Enhanced mobile responsive design
- 🗺️ Google Maps integration for precise location marking
- 📊 Advanced analytics dashboard with charts
- 🌙 Dark mode theme
- 🔔 WebSocket-based real-time push notifications
- 📲 Progressive Web App (PWA) support
- 🌐 Multi-language support (Bangla/English)

---

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 📞 Contact

For queries or suggestions, reach out to the contributors:

- **MH SHUVO**: [@MH-SHUVO20](https://github.com/MH-SHUVO20) | mdmehedihasanshuvo994@gmail.com
- **Shahadat Hossain Shoumik**: [@ShahadatHossainShoumik](https://github.com/ShahadatHossainShoumik) | shahadatshoumik@gmail.com

---

## 🙏 Acknowledgments

- Built for the citizens of **Dhaka, Bangladesh**
- Inspired by modern civic engagement platforms
- Thanks to all contributors and testers

---

<p align="center">
  <b>⭐ Star this repository if you find it helpful!</b>
  <br/>
  <sub>Made with ❤️ for a better Dhaka</sub>
</p>
