<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeCode = $_POST["id"];
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Prepare the update query
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connection->prepare("UPDATE users SET full_name = ?, email = ?, password = ? WHERE employee_code = ?");
        $stmt->bind_param("sssi", $fullname, $email, $hashed_password, $employeeCode);
    } else {
        $stmt = $connection->prepare("UPDATE users SET full_name = ?, email = ? WHERE employee_code = ?");
        $stmt->bind_param("ssi", $fullname, $email, $employeeCode);
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