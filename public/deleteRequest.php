<?php
require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;
use App\classes\database;

$database = new database();
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    messageHandler::addMessage("error", "Invalid request ID.");
    header("Location: vacationRequestsForm.php");
    exit();
}

$requestId = (int) $_GET['id'];

if (!isset($_SESSION['user_employee_code'])) {
    messageHandler::addMessage("error", "Session error: Employee code is missing.");
    header("Location: vacationRequestsForm.php");
    exit();
}

// Check if the request exists and is still pending
$stmt = $database->getConnection()->prepare("SELECT status FROM requests WHERE id = ? AND employee_code = ?");
$stmt->bind_param("ii", $requestId, $_SESSION['user_employee_code']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    messageHandler::addMessage("error", "Request not found or you don't have permission to delete it.");
} elseif ($row['status'] !== 'pending') {
    messageHandler::addMessage("error", "You can only delete requests that are still pending.");
} else {
    // Delete the request
    $stmt = $database->getConnection()->prepare("DELETE FROM requests WHERE id = ?");
    $stmt->bind_param("i", $requestId);
    if ($stmt->execute()) {
        messageHandler::addMessage("success", "Vacation request deleted successfully.");
    } else {
        messageHandler::addMessage("error", "Error deleting vacation request.");
    }
}

header("Location: vacationRequestsForm.php");
exit();