<?php
session_start();
require_once('../Model/AnnouncementModel.php');

// Only admin and authority can create announcements
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'authority'])) {
    $_SESSION['msg'] = "Access denied";
    header("Location: ../View/login.php");
    exit();
}

$user_id = $_SESSION['id'];
$role = $_SESSION['role'];

// Handle create announcement
if (isset($_POST['create_announcement'])) {

    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['description'] ?? '');

    // Validation
    if (empty($title) || empty($message)) {
        $_SESSION['msg'] = "Title and message are required";
        if ($role === 'authority') {
            header("Location: ../View/Authority/new_announcement.php");
        } else {
            header("Location: ../View/Admin/manage_announcement.php");
        }
        exit();
    }
    // Title length check
    if (strlen($title) > 200) {
        $_SESSION['msg'] = "Title must be less than 200 characters";
        if ($role === 'authority') {
            header("Location: ../View/Authority/new_announcement.php");
        } else {
            header("Location: ../View/Admin/manage_announcement.php");
        }
        exit();
    }

    // Create announcement
    $result = createAnnouncement($title, $message, $user_id);

    if ($result) {
        $_SESSION['msg'] = "Announcement created successfully!";
        if ($role === 'authority') {
            header("Location: ../View/Authority/all_announcements.php");
        } else {
            header("Location: ../View/Admin/manage_announcement.php");
        }
    } else {
        $_SESSION['msg'] = "Failed to create announcement";
        if ($role === 'authority') {
            header("Location: ../View/Authority/new_announcement.php");
        } else {
            header("Location: ../View/Admin/manage_announcement.php");
        }
    }
    exit();
}

// Handle update announcement
if (isset($_POST['update_announcement'])) {

    $announcement_id = (int) ($_POST['announcement_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['description'] ?? '');

    if ($announcement_id === 0) {
        $_SESSION['msg'] = "Invalid announcement";
        header("Location: ../View/Admin/manage_announcement.php");
        exit();
    }

    if (empty($title) || empty($message)) {
        $_SESSION['msg'] = "Title and message are required";
        header("Location: ../View/Admin/manage_announcement.php");
        exit();
    }

    $result = updateAnnouncement($announcement_id, $user_id, $title, $message);

    if ($result) {
        $_SESSION['msg'] = "Announcement updated successfully!";
    } else {
        $_SESSION['msg'] = "Failed to update announcement or you don't have permission";
    }

    header("Location: ../View/Admin/manage_announcement.php");
    exit();
}

// Handle delete announcement (admin only)
if (isset($_POST['delete_announcement']) && $role === 'admin') {

    $announcement_id = (int) ($_POST['announcement_id'] ?? 0);

    if ($announcement_id === 0) {
        $_SESSION['msg'] = "Invalid announcement";
        header("Location: ../View/Admin/manage_announcement.php");
        exit();
    }

    $result = deleteAnnouncement($announcement_id);

    if ($result) {
        $_SESSION['msg'] = "Announcement deleted successfully!";
    } else {
        $_SESSION['msg'] = "Failed to delete announcement";
    }

    header("Location: ../View/Admin/manage_announcement.php");
    exit();
}

// If no valid action, redirect
header("Location: ../View/login.php");
exit();

?>