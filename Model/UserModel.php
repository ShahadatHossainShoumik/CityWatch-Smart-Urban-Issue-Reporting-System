<?php
require_once('db.php');

//for user insertion
function insertUser($name,$dob,$mobile,$email,$nid,$password,$profile_image){

    $role = "citizen";
    $conn = dbConnect();

    $query = "INSERT INTO users
              (name,dob,mobile,email,nid,password,profile_image,role)
              VALUES
              (?,?,?,?,?,?,?,?)";

    $stmt = mysqli_prepare($conn,$query);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"ssssssss",$name,$dob,$mobile,$email,$nid,$password,$profile_image,$role);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}

//for fetching user by email
function getUserByEmail($email){

    $conn = dbConnect();
    $query = "SELECT * FROM users WHERE email=?";
    $stmt = mysqli_prepare($conn,$query);

    if($stmt){
        mysqli_stmt_bind_param($stmt,"s",$email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $user;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    return false;
}

//fetch user by id
function getUserById($id){

    $conn = dbConnect();
    $query = "SELECT * FROM users WHERE id=?";
    $stmt = mysqli_prepare($conn,$query);

    if($stmt){
        mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0){
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $user;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    return false;
}

//update profile info (name, dob, mobile, profile image)
function updateUserProfile($id,$name,$dob,$mobile,$profile_image){

    $conn = dbConnect();
    $query = "UPDATE users
              SET name=?, dob=?, mobile=?, profile_image=?
              WHERE id=?";

    $stmt = mysqli_prepare($conn,$query);
    if($stmt){
        mysqli_stmt_bind_param($stmt,"ssssi",$name,$dob,$mobile,$profile_image,$id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}

//change password (plain text match)
function updateUserPassword($id,$current_password,$new_password){

    $user = getUserById($id);
    if(!$user){
        return false;
    }

    // check old password
    if($user['password'] != $current_password){
        return false;
    }

    $conn = dbConnect();
    $query = "UPDATE users SET password=? WHERE id=?";
    $stmt = mysqli_prepare($conn,$query);

    if($stmt){
        mysqli_stmt_bind_param($stmt,"si",$new_password,$id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $result;
    }
    mysqli_close($conn);
    return false;
}
?>
