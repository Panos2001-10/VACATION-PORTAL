<?php

namespace App;

class messageHandler
{
    /**
     * Add a message to the session.
     *
     * @param string $type The type of message (e.g., 'error' or 'success').
     * @param string $text The message text.
     */
    public static function addMessage(string $type, string $text): void
    {
        // Ensure the messages array exists
        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
        $_SESSION['messages'][] = [
            'type' => $type,
            'text' => $text
        ];
    }

    /**
     * Retrieve all messages and clear them from the session.
     *
     * @return array The array of messages.
     */
    public static function getMessages(): array
    {
        $messages = $_SESSION['messages'] ?? [];
        unset($_SESSION['messages']); // Clear messages after retrieval
        return $messages;
    }

    /**
     * Display messages stored in the session.
     * Messages are wrapped in a paragraph element with a CSS class based on their type.
     */
    public static function displayMessages(): void
    {
        $messages = self::getMessages();
        foreach ($messages as $message) {
            $messageClass = $message['type'] === 'error' ? 'error' : 'success';
            echo "<p class='$messageClass'>" . htmlspecialchars($message['text']) . "</p>";
        }
    }
}
