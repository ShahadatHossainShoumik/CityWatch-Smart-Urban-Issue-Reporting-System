<?php

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('../Model/UserModel.php');

// Helper to clear remember-me cookies
function clearRememberCookies()
{
    $expire = time() - 3600;
    setcookie('citywatch_user_id', '', $expire, '/', '', false, true);
    setcookie('citywatch_user_email', '', $expire, '/', '', false, true);
    setcookie('citywatch_user_role', '', $expire, '/', '', false, true);
    setcookie('citywatch_user_name', '', $expire, '/', '', false, true);
    setcookie('citywatch_remember', '', $expire, '/', '', false, true);
}

// for signup
if (isset($_POST['signup'])) {

    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $nid = $_POST['nid'];
    $password = $_POST['password'];

    $imagePath = "";

    if ($_FILES['profile_image']['name'] != "") {
        $imageName = time() . "_" . $_FILES['profile_image']['name'];
        $imagePath = "profiles/" . $imageName;
        $imageDir = "../Images/profiles";

        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }

        move_uploaded_file($_FILES['profile_image']['tmp_name'], $imageDir . "/" . $imageName);
    }

    if (getUserByEmail($email)) {
        $_SESSION['msg'] = "Email already exists";
        $_SESSION['msg_type'] = "error";
        header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/signup.php");
        exit();
    } else {
        $result = insertUser($name, $dob, $mobile, $email, $nid, $password, $imagePath);
        if ($result) {
            $_SESSION['msg'] = "Registration successful! Please login with your credentials.";
            $_SESSION['msg_type'] = "success";
            header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/login.php");
            exit();
        } else {
            $_SESSION['msg'] = "Registration failed. Please try again.";
            $_SESSION['msg_type'] = "error";
            header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/signup.php");
            exit();
        }
    }
}

// for login
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $remember = isset($_POST['remember']) ? 1 : 0;

    $user = getUserByEmail($email);

    if ($user) {
        if (isset($user['is_blocked']) && $user['is_blocked'] == 1) {
            clearRememberCookies();
            $_SESSION['msg'] = "Your account is blocked. Please contact support.";
            header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/login.php");
            exit();
        }

        if ($user['password'] == $password && $user['role'] == $role) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Set cookies if "Remember Me" is checked
            if ($remember) {
                $cookie_expiry = time() + (7 * 24 * 60 * 60); // 7 days
                setcookie('citywatch_user_id', $user['id'], $cookie_expiry, '/', '', false, true);
                setcookie('citywatch_user_email', $user['email'], $cookie_expiry, '/', '', false, true);
                setcookie('citywatch_user_role', $role, $cookie_expiry, '/', '', false, true);
                setcookie('citywatch_user_name', $user['name'], $cookie_expiry, '/', '', false, true);
                setcookie('citywatch_remember', '1', $cookie_expiry, '/', '', false, true);
            }

            // Redirect based on role
            if ($role === 'citizen') {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/Citizen/citizen_dashboard.php");
            } elseif ($role === 'authority') {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/Authority/authority_dashboard.php");
            } elseif ($role === 'admin') {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/Admin/admin_dashboard.php");
            } else {
                header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/index.php");
            }
            exit();

        } else {
            $_SESSION['msg'] = "Invalid password or role";
            header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/login.php");
            exit();
        }

    } else {
        $_SESSION['msg'] = "User not found with email: $email";
        header("Location: /Projects/CityWatch-Smart-Urban-Issue-Reporting-System/View/login.php");
        exit();
    }
}
?>