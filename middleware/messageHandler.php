<?php

function addMessage($type, $text) {
    $_SESSION['messages'][] = ["type" => $type, "text" => $text];
}

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
