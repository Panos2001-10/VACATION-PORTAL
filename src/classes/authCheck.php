<?php

namespace App\classes;

class authCheck
{
    public static function ensureAuthenticated(): void
    {
        session_start();

        if ((!isset($_SESSION["user_manager_code"]) || !isset($_SESSION["user_employee_code"])) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
            header("Location: index.php");
            exit();
        }
    }
}
