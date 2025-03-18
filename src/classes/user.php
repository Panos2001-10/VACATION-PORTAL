<?php

namespace App\classes;

class user
{
    private $managerCode;
    private $employeeCode;
    private $fullName;
    private $email;
    private $hashedPassword;
    private $role;

    public function __construct($managerCode, $employeeCode, $fullName, $email, $hashedPassword, $role)
    {
        $this->managerCode    = $managerCode;
        $this->employeeCode   = $employeeCode;
        $this->fullName       = $fullName;
        $this->email          = $email;
        $this->hashedPassword = $hashedPassword;
        $this->role           = $role;
    }

    /**
     * Generic method to find a user by a specific condition.
     *
     * @param database $db         The database instance.
     * @param array    $columns    Array of columns to select.
     * @param string   $table      The table name.
     * @param string   $where      The WHERE clause (e.g., "email = ?").
     * @param string   $whereType  The type for the where parameter (e.g., "s" for string).
     * @param mixed    $whereValue The value for the where clause.
     *
     * @return user|null           Returns a user object if found, otherwise null.
     */
    public static function findBy(database $db, array $columns, string $table, string $where, string $whereType, $whereValue): ?user
    {
        // Build a comma-separated list of columns.
        $columnsList = implode(', ', $columns);

        // Construct the SQL query dynamically.
        $sql = "SELECT $columnsList FROM $table WHERE $where";

        // Execute the query using the database class.
        $row = $db->fetchRow($sql, [$whereValue], $whereType);

        if ($row) {
            return new user(
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

    // Getters for properties.
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
    public function getHashedPassword(): string {
        return $this->hashedPassword;
    }
}
