<?php

$twig = require_once __DIR__ . '/../src/bootstrap.php';

use App\classes\messageHandler;

ob_start();
messageHandler::displayMessages();
$messagesHtml = ob_get_clean();

echo $twig->render('login.twig', [
    'messages' => $messagesHtml,
]);