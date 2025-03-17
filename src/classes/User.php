<?php

namespace App;

class User
{
    private $managerCode;
    private $employeeCode;
    private $fullName;
    private $email;
    private $hashedPassword;
    private $role;

    public function __construct( $managerCode, $employeeCode, $fullName, $email, $hashedPassword, $role ) {
        $this->managerCode    = $managerCode;
        $this->employeeCode   = $employeeCode;
        $this->fullName       = $fullName;
        $this->email          = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role           = $role;
    }

    /**
     * Find user by email using the Database class.
     */
    public static function findByEmail(Database $db, string $email): ?User
    {
        $sql = "SELECT manager_code, employee_code, full_name, email, password, role
                FROM users
                WHERE email = ?";

        $row = $db->fetchRow($sql, [$email]);

        if ($row) {
            return new User(
                $row['manager_code'],
                $row['employee_code'],
                $row['full_name'],
                $row['email'],
                $row['password'],
                $row['role']
            );
        }

        return null;
    }

    public function getManagerCode() {
        return $this->managerCode;
    }
    public function getEmployeeCode() {
        return $this->employeeCode;
    }
    public function getFullName() {
        return $this->fullName;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getRole() {
        return $this->role;
    }
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}
