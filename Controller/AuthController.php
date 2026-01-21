<?php
session_start();
require_once('../Model/UserModel.php');

//for signup
if(isset($_POST['signup'])){

    $name     = $_POST['name'];
    $dob      = $_POST['dob'];
    $mobile   = $_POST['mobile'];
    $email    = $_POST['email'];
    $nid      = $_POST['nid'];
    $password = $_POST['password'];

    $imagePath = "";

    if($_FILES['profile_image']['name'] != ""){
        $imageName = time() . "_" . $_FILES['profile_image']['name'];
        $imagePath = "profiles/" . $imageName;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], "../images/".$imagePath);
    }

    if(getUserByEmail($email)){
        echo "Email already exists";
    } else {
        insertUser($name,$dob,$mobile,$email,$nid,$password,$imagePath);
        header("Location: ../View/login.php");
        exit();
    }
}
//for login
if(isset($_POST['login'])){

    $email    = $_POST['email'];
    $password = $_POST['password'];
    $role     = $_POST['role'];   

    $user = getUserByEmail($email);

    if($user){

        if($user['password'] == $password && $user['role'] == $role){

            $_SESSION['id']   = $user['id'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../index.php");
            exit();

        } else {
            echo "Invalid password or role";
        }

    } else {
        echo "User not found";
    }
}
?>
