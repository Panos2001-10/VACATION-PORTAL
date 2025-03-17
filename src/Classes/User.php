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

    public function __construct($managerCode, $employeeCode, $fullName, $email, $hashedPassword, $role)
    {
        $this->managerCode   = $managerCode;
        $this->employeeCode  = $employeeCode;
        $this->fullName      = $fullName;
        $this->email         = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role          = $role;
    }

    /**
     * Find user by email in the database.
     *
     * @param \mysqli $connection
     * @param string  $email
     * @return User|null
     */
    public static function findByEmail(\mysqli $connection, string $email): ?User
    {
        $stmt = $connection->prepare(
            "SELECT manager_code, employee_code, full_name, email, password, role 
             FROM users 
             WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($managerCode, $employeeCode, $fullName, $userEmail, $hashedPassword, $role);
            $stmt->fetch();

            return new User($managerCode, $employeeCode, $fullName, $userEmail, $hashedPassword, $role);
        }

        return null;
    }

    /**
     * Verify a raw password against the hashed password in the database.
     */
    public function verifyPassword(string $rawPassword): bool
    {
        return password_verify($rawPassword, $this->hashedPassword);
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
}
