<?php
session_start();

// Destroy all session data, effectively logging the user out
session_destroy();
header("Location: index.php");
exit();
?>
