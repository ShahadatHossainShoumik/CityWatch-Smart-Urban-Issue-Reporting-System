<?php
session_start();

//Destroy all session data
session_unset();
session_destroy();

//Redirect to public home page 
header("Location: ../home.php");
exit();
?>