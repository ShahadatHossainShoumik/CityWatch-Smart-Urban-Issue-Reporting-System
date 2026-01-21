<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Clear remember-me cookies
setcookie('citywatch_user_id', '', time() - 3600, '/', '', false, true);
setcookie('citywatch_user_email', '', time() - 3600, '/', '', false, true);
setcookie('citywatch_user_role', '', time() - 3600, '/', '', false, true);
setcookie('citywatch_user_name', '', time() - 3600, '/', '', false, true);
setcookie('citywatch_remember', '', time() - 3600, '/', '', false, true);

// Redirect to public home page 
header("Location: ../home.php");
exit();
?>