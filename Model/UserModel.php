<?php
require_once('db.php');
///for user insertion
function insertUser($name,$dob,$mobile,$email,$nid,$password,$profile_image){

    $role = "citizen";   

    $query = "INSERT INTO users
              (name,dob,mobile,email,nid,password,profile_image,role)
              VALUES
              ('$name','$dob','$mobile','$email','$nid','$password','$profile_image','$role')";

    $conn = dbConnect();
    return mysqli_query($conn,$query);
}
///for fetching user by email
function getUserByEmail($email){

    $query = "SELECT * FROM users WHERE email='$email'";
    $conn = dbConnect();
    $result = mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0){
        return mysqli_fetch_assoc($result);
    }
    return false;
}
?>
