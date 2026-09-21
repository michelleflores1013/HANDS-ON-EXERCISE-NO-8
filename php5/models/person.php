<?php

class Person
{
    private $conn;
    private $table = "persons";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create(
        $name,
        $age,
        $gender,
        $email,
        $address,
        $contact_num
    ) {
        $sql = "INSERT INTO {$this->table}
                (name, age, gender, email, address, contact_num)
                VALUES
                (:name, :age, :gender, :email, :address, :contact_num)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':age' => $age,
            ':gender' => $gender,
            ':email' => $email,
            ':address' => $address,
            ':contact_num' => $contact_num
        ]);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}
                ORDER BY id DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}