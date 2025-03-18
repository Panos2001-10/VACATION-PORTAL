<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config.php';

use App\AuthService;
use App\Database;
use App\MessageHandler;
use App\User;
use App\valueObjects\email;

$database = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture user input.
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the email format.
    try {
        $emailObject = new Email($email);
    } catch (InvalidArgumentException $e) {
        MessageHandler::addMessage('error', 'Please enter a valid email address.');
        header("Location: index.php");
        exit();
    }


    // Define the columns and condition for the query.
    $columns = ['manager_code', 'employee_code', 'full_name', 'email', 'password', 'role'];
    $table = 'users';
    $where = 'email = ?';
    $whereType = 's'; // For email (string).

    // Use the generic findBy method to fetch the user.
    $user = User::findBy($database, $columns, $table, $where, $whereType, $email);

    if ($user && AuthService::verifyPassword($password, $user->getHashedPassword() )) {
        $_SESSION['user_manager_code']  = $user->getManagerCode();
        $_SESSION['user_employee_code'] = $user->getEmployeeCode();
        $_SESSION['user_full_name']     = $user->getFullName();
        $_SESSION['user_email']         = $user->getEmail();
        $_SESSION['user_role']          = $user->getRole();

        if ($user->getRole() === 'manager') {
            header("Location: manageUsersForm.php");
            exit();
        } elseif ($user->getRole() === 'employee') {
            header("Location: vacationRequestsForm.php");
            exit();
        }
    } else {
        // Invalid credentials.
        MessageHandler::addMessage('error', 'Incorrect credentials.');
        header("Location: index.php");
        exit();
    }
}
