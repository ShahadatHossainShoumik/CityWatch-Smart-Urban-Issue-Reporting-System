<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "citywatch";
$port = 3306;

function dbConnect(){
    global $host, $user, $pass, $db_name, $port;

    $conn = mysqli_connect($host, $user, $pass, $db_name, $port);

    if(!$conn){
        echo mysqli_error($conn);
    } else {
        return $conn;
    }
}
?>
