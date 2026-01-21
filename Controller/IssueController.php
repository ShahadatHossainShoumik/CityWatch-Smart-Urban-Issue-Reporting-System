<?php
session_start();
require_once('../Model/IssueModel.php');
//insert new issue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // User must be logged in
    if (!isset($_SESSION['id'])) {
        $_SESSION['msg'] = "Please login first";
        header("Location: ../View/login.php");
        exit();
    }

    $user_id     = $_SESSION['id'];
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $location    = $_POST['location'];

    //image upload
    $imageName = "";

    if (!empty($_FILES['issue_image']['name'])) {

        // Clean filename
        $originalName = $_FILES['issue_image']['name'];
        $originalName = str_replace(" ", "_", $originalName);

        // Unique filename
        $imageName = time() . "_" . $originalName;

        // Absolute Images directory (capital I)
        $imageDir = __DIR__ . '/../Images';

        // Create Images folder if not exists
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }

        $uploadPath = $imageDir . '/' . $imageName;

        if (!move_uploaded_file($_FILES['issue_image']['tmp_name'], $uploadPath)) {
            $_SESSION['msg'] = "Image upload failed";
            header("Location: ../View/citizen/citizen_new_incident.php");
            exit();
        }
    }

    //insert issue into database
    $status = insertIssue($user_id, $title, $description, $location, $imageName);

    if ($status) {
        $_SESSION['msg'] = "Issue submitted successfully";
        header("Location: ../View/citizen/citizen_dashboard.php");
        exit();
    } else {
        $_SESSION['msg'] = "Issue submission failed";
        header("Location: ../View/citizen/citizen_new_incident.php");
        exit();
    }
}

//admin approve/reject issue
if (isset($_GET['issue_id']) && isset($_GET['action'])) {

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../View/login.php");
        exit();
    }

    $issue_id = $_GET['issue_id'];
    $action   = $_GET['action']; 

    if ($action === 'approve') {
        updateIssueStatus($issue_id, 'approved');
    }

    if ($action === 'reject') {
        updateIssueStatus($issue_id, 'rejected');
    }

    header("Location: ../View/admin/manage_incidents.php");
    exit();
}
?>
