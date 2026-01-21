<?php
session_start();
require_once('../Model/UserModel.php');

// Verify user is logged in and is a citizen
if (!isset($_SESSION['id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'citizen') {
    header("Location: ../View/login.php");
    exit();
}

$user_id = $_SESSION['id'];

// handle profile update
if (isset($_POST['update_profile'])) {

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];

    // basic validation 
    if (!preg_match('/^\d{11}$/', $mobile)) {
        $_SESSION['msg'] = "Mobile must be 11 digits";
        header("Location: ../View/Citizen/citizen_profile.php");
        exit();
    }

    // keep existing image if none uploaded
    $currentUser = getUserById($user_id);
    $imagePath = $currentUser ? $currentUser['profile_image'] : "";

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != "") {

        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        $mime = mime_content_type($_FILES['profile_image']['tmp_name']);
        $sizeOk = $_FILES['profile_image']['size'] <= 2 * 1024 * 1024; // 2MB

        if (!in_array($mime, $allowed) || !$sizeOk) {
            $_SESSION['msg'] = "Image must be JPG/PNG and under 2MB";
            header("Location: ../View/Citizen/citizen_profile.php");
            exit();
        }

        $imageName = time() . "_" . $_FILES['profile_image']['name'];
        $imageDir = "../Images/profiles";

        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }
        // store relative path
        $uploadPath = $imageDir . "/" . $imageName;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
            $imagePath = "profiles/" . $imageName;
        }
    }

    $ok = updateUserProfile($user_id, $name, $dob, $mobile, $imagePath);

    if ($ok) {
        $_SESSION['msg'] = "Profile updated";
    } else {
        $_SESSION['msg'] = "Update failed";
    }

    header("Location: ../View/Citizen/citizen_profile.php");
    exit();
}

// handle password change
if (isset($_POST['change_password'])) {

    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    // basic validation of passwords
    if ($new !== $confirm) {
        $_SESSION['msg'] = "New passwords do not match";
        header("Location: ../View/Citizen/citizen_profile.php");
        exit();
    }
    // ensure new password is different
    if ($current == $new) {
        $_SESSION['msg'] = "New password must be different from current";
        header("Location: ../View/Citizen/citizen_profile.php");
        exit();
    }
    $ok = updateUserPassword($user_id, $current, $new);

    if ($ok) {
        $_SESSION['msg'] = "Password changed";
    } else {
        $_SESSION['msg'] = "Password change failed";
    }

    header("Location: ../View/Citizen/citizen_profile.php");
    exit();
}

// default fallback
header("Location: ../View/Citizen/citizen_profile.php");
exit();
?>