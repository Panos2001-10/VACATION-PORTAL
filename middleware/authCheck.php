<?
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Check if the user is already loged-in
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
?>