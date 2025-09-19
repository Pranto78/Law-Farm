<?php
session_start();
session_unset();  // remove all session variables
session_destroy(); // destroy the session
header("Location: lawyer_login.html"); // redirect to login form
exit;
?>
