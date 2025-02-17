<?php
// Function to add a message to the session
// This function stores the message type ('error' or 'success') and the message text in the session's 'messages' array.
function addMessage($type, $text) {
    // Append the new message to the session's 'messages' array
    $_SESSION['messages'][] = ["type" => $type, "text" => $text];
}

// Function to display messages stored in the session
// It displays all messages of type 'error' or 'success' and clears them after displaying.
function displayMessages() {
    // Check if there are any messages stored in the session
    if (isset($_SESSION['messages']) && !empty($_SESSION['messages'])) {
        // Iterate through each message in the session
        foreach ($_SESSION['messages'] as $message) {
            // Determine the CSS class to apply based on the message type
            // If the message type is 'error', apply the 'error' class; otherwise, apply the 'success' class.
            $messageClass = $message['type'] === 'error' ? 'error' : 'success';
            
            // Echo the message text wrapped in a paragraph with the appropriate class for styling
            echo "<p class='$messageClass'>" . htmlspecialchars($message['text']) . "</p>";
        }

        // After displaying the messages, remove them from the session to prevent them from being shown again
        unset($_SESSION['messages']);
    }
}
?>
