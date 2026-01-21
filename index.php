<?php
session_start();

// Public access check
if (!isset($_SESSION['role'])) {
    header("Location: View/home.php");
    exit();
}

// Role-based redirection
if ($_SESSION['role'] == 'admin') {
    header("Location: View/admin/admin_dashboard.php");
    exit();
}

if ($_SESSION['role'] == 'citizen') {
    header("Location: View/citizen/citizen_dashboard.php");
    exit();
}

if ($_SESSION['role'] == 'authority') {
    header("Location: View/authority/authority_dashboard.php");
    exit();
}

// Safety fallback
echo "Invalid role";
session_destroy();
?>
