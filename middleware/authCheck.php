<?
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Check if the user is already loged-in
if (!isset($_SESSION["user_id"])) {
    echo "User ID is not found, the user might not be logged in.";
    header("Location: index.php");
    exit();
}
?>