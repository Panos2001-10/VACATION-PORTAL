<?php
session_start();
include __DIR__ . '/../src/config.php';
include __DIR__ . '/messageHandler.php';

// Check if the user is logged in and is a manager
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "manager") {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $employee_code = $_POST["employee_code"];
    $password = trim($_POST["password"]);

    // Prepare the update query
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("UPDATE users SET name = ?, email = ?, employee_code = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $fullname, $email, $employee_code, $hashed_password, $id);
    } else {
        $stmt = $connection->prepare("UPDATE users SET name = ?, email = ?, employee_code = ? WHERE id = ?");
        $stmt->bind_param("sssi", $fullname, $email, $employee_code, $id);
    }

    if ($stmt->execute()) {
        addMessage("success", "User updated successfully!");
        header("Location: manageUsersForm.php");
        exit();
    } else {
        addMessage("error", "Error updating record: " . $connection->error);
    }
} else {
    addMessage("error", "Invalid request");
}
?>