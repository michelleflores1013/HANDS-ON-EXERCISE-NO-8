<?php

class Faculty
{
    private $conn;
    private $table = "faculty";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data)
    {
        $sql = "INSERT INTO faculty
                (
                    first_name,
                    middle_name,
                    last_name,
                    age,
                    gender,
                    address,
                    position,
                    salary
                )
                VALUES
                (
                    :first_name,
                    :middle_name,
                    :last_name,
                    :age,
                    :gender,
                    :address,
                    :position,
                    :salary
                )";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute($data);
    }

    public function getAll()
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM faculty ORDER BY faculty_id DESC"
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare(
            "SELECT * FROM faculty WHERE faculty_id = :id"
        );

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE faculty SET
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    age = :age,
                    gender = :gender,
                    address = :address,
                    position = :position,
                    salary = :salary
                WHERE faculty_id = :id";

        $stmt = $this->conn->prepare($sql);

        $data[':id'] = $id;

        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare(
            "DELETE FROM faculty WHERE faculty_id = :id"
        );

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}