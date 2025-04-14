<?php
session_start();
session_destroy(); // Unset all session variables
header("Location: p3index.php"); // Redirect to the index page
exit(); // Ensure no further code is executed after the redirect
?>