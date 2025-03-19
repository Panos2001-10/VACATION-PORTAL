<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\authService;
use App\classes\database;
use App\classes\messageHandler;
use App\classes\user;
use App\classes\valueObjects\email;
use App\dto\LoginRequestDTO;


$database = new database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $loginRequest = new LoginRequestDTO($_POST['email'] ?? '', $_POST['password'] ?? '');
    } catch (InvalidArgumentException $e) {
        messageHandler::addMessage('error', 'Please enter a valid email address.');
        header("Location: index.php");
        exit();
    }

    // Validate the email format.
    $emailObject = $loginRequest->getEmail();

    // Define the columns and condition for the query.
    $columns = ['manager_code', 'employee_code', 'full_name', 'email', 'password', 'role'];
    $table = 'users';
    $where = 'email = ?';
    $whereType = 's'; // For email (string).

    // Use the generic findBy method to fetch the user.
    $user = user::findBy($database, $columns, $table, $where, $whereType, $emailObject);

    if ($user && authService::verifyPassword($loginRequest->getPassword(), $user->getHashedPassword() )) {
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
        messageHandler::addMessage('error', 'Incorrect credentials.');
        header("Location: index.php");
        exit();
    }
}
