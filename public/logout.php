<?php
// Start a new session or resume the existing session
session_start();

// Destroy all session data, effectively logging the user out
session_destroy();

// Redirect the user to the 'index.php' page (or any page you want after logout)
header("Location: index.php");

// Terminate the script to ensure no further code is executed after the redirect
exit();
?>
