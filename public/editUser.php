<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../src/utils.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeCode = $_POST["id"];
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (!checkManagerAuthorization($connection, $employeeCode)) {
        addMessage("error", "You are not authorized to edit this employee's details.");
        header("Location: manageUsersForm.php");
        exit();
    }

    // Check if the new email already exists for another user
    $stmt = $connection->prepare("SELECT employee_code FROM users WHERE email = ? AND employee_code != ?");
    $stmt->bind_param("si", $email, $employeeCode);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        addMessage("error", "Email is already in use by another user.");
        header("Location: manageUsersForm.php");
        exit();
    }

    $stmt->close();

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
        header("Location: manageUsers.php");  // Redirect to manageUsers.php
        exit();  // Always call exit after header to prevent further code execution
    }
} else {
    addMessage("error", "Invalid request.");
    header("Location: manageUsersForm.php");
    exit();
}
?>
