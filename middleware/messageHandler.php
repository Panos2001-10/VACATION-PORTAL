<?php
// Function to add a message to the session
// This function stores the message type ('error' or 'success') and the message text in the session's 'messages' array.
function addMessage($type, $text) {
    $_SESSION['messages'][] = ["type" => $type, "text" => $text];
}

// Function to display messages stored in the session
// It displays all messages of type 'error' or 'success' and clears them after displaying.
function displayMessages() {
    if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
        foreach ($_SESSION['messages'] as $message) {
            $messageClass = $message['type'] === 'error' ? 'error' : 'success';
            echo "<p class='$messageClass'>" . htmlspecialchars($message['text']) . "</p>";
        }
        unset($_SESSION['messages']);
    }
}
?>
