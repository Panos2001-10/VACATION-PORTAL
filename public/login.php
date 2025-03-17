<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config.php';

use App\AuthService;
use App\Database;
use App\MessageHandler;
use App\User;

$database = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture user input
    $email    = $_POST['email']    ?? '';
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        MessageHandler::addMessage('error', 'Please enter a valid email address.');
        header("Location: index.php");
        exit();
    }

    $user = User::findByEmail($database, $_POST['email'] ?? '');

    if ($user && AuthService::verifyPassword($user, $_POST['password'] ?? '')) {

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
        // Invalid credentials
        MessageHandler::addMessage('error', 'Incorrect credentials.');
        header("Location: index.php");
        exit();
    }
}
