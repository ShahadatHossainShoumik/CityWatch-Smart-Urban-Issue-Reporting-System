<?php
session_start();
require_once('../Model/IssueModel.php');

// only citizens can manage their uploads
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../View/login.php");
    exit();
}

$user_id = $_SESSION['id'];

// handle edit issue
if (isset($_POST['edit_issue'])) {

    $issue_id = (int) $_POST['issue_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // basic validation
    if (empty($title) || empty($description) || empty($location)) {
        $_SESSION['msg'] = "All fields are required";
        header("Location: ../View/Citizen/citizen_my_uploads.php");
        exit();
    }

    // verify issue belongs to this user
    $issue = getIssueById($issue_id, $user_id);
    if (!$issue) {
        $_SESSION['msg'] = "Issue not found";
        header("Location: ../View/Citizen/citizen_my_uploads.php");
        exit();
    }

    $imagePath = $issue['image']; // keep existing image by default

    // handle new image upload
    if (isset($_FILES['issue_image']) && $_FILES['issue_image']['name'] != "") {

        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        $mime = mime_content_type($_FILES['issue_image']['tmp_name']);
        $sizeOk = $_FILES['issue_image']['size'] <= 5 * 1024 * 1024; // 5MB

        if (!in_array($mime, $allowed) || !$sizeOk) {
            $_SESSION['msg'] = "Image must be JPG/PNG and under 5MB";
            header("Location: ../View/Citizen/citizen_my_uploads.php");
            exit();
        }

        $imageName = time() . "_" . $_FILES['issue_image']['name'];
        $imageDir = "../Images";

        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }

        $uploadPath = $imageDir . "/" . $imageName;
        if (move_uploaded_file($_FILES['issue_image']['tmp_name'], $uploadPath)) {
            $imagePath = $imageName;
        }
    }

    $ok = updateIssue($issue_id, $user_id, $title, $description, $location, $imagePath);

    if ($ok) {
        $_SESSION['msg'] = "Issue updated successfully";
    } else {
        $_SESSION['msg'] = "Update failed";
    }

    header("Location: ../View/Citizen/citizen_my_uploads.php");
    exit();
}

// handle delete issue
if (isset($_POST['delete_issue'])) {

    $issue_id = (int) $_POST['issue_id'];

    // verify issue belongs to this user
    $issue = getIssueById($issue_id, $user_id);
    if (!$issue) {
        $_SESSION['msg'] = "Issue not found";
        header("Location: ../View/Citizen/citizen_my_uploads.php");
        exit();
    }

    $ok = deleteIssue($issue_id, $user_id);

    if ($ok) {
        $_SESSION['msg'] = "Issue deleted successfully";
    } else {
        $_SESSION['msg'] = "Delete failed";
    }

    header("Location: ../View/Citizen/citizen_my_uploads.php");
    exit();
}

// default fallback
header("Location: ../View/Citizen/citizen_my_uploads.php");
exit();
?>