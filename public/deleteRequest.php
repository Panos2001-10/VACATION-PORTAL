<?php
include __DIR__ . '/../src/config.php';
include __DIR__ . '/../middleware/messageHandler.php';
include __DIR__ . '/../middleware/authCheck.php';

// Ensure a request ID is provided
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    addMessage("error", "Invalid request ID.");
    header("Location: vacationRequestsForm.php");
    exit();
}

$requestId = (int) $_GET['id'];

if (!isset($_SESSION['user_employee_code'])) {
    addMessage("error", "Session error: Employee code is missing.");
    header("Location: vacationRequestsForm.php");
    exit();
}

// Check if the request exists and is still pending
$stmt = $connection->prepare("SELECT status FROM requests WHERE id = ? AND employee_code = ?");
$stmt->bind_param("ii", $requestId, $_SESSION['user_employee_code']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    addMessage("error", "Request not found or you don't have permission to delete it.");
} elseif ($row['status'] !== 'pending') {
    addMessage("error", "You can only delete requests that are still pending.");
} else {
    // Delete the request
    $stmt = $connection->prepare("DELETE FROM requests WHERE id = ?");
    $stmt->bind_param("i", $requestId);
    if ($stmt->execute()) {
        addMessage("success", "Vacation request deleted successfully.");
    } else {
        addMessage("error", "Error deleting vacation request.");
    }
}

header("Location: vacationRequestsForm.php");
exit();
?>
