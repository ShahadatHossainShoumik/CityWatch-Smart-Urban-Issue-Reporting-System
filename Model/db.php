<?php
// Database configuration
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "citywatch";
$port = 3306;
// Create database connection
function dbConnect(){
    global $host, $user, $pass, $db_name, $port;

    $conn = mysqli_connect($host, $user, $pass, $db_name, $port);

    if(!$conn){
        die("Database connection failed: " . mysqli_connect_error());
    } else {
        return $conn;
    }
}
?>
