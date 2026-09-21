<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Person.php';

class PersonController
{
    private $person;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->person = new Person($db);
    }

    public function index()
    {
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name'] ?? '');
            $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
            $gender = $_POST['gender'] ?? '';
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $contact_num = trim($_POST['contact_num'] ?? '');

            $errors = [];

            if ($name === '') {
                $errors[] = "Name is required.";
            }

            if ($age === false || $age < 1 || $age > 120) {
                $errors[] = "Age must be between 1 and 120.";
            }

            if (!in_array($gender, ['Male', 'Female'])) {
                $errors[] = "Please select a valid gender.";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email address.";
            }

            if ($address === '') {
                $errors[] = "Address is required.";
            }

            if (!preg_match('/^[0-9+\-\s]+$/', $contact_num)) {
                $errors[] = "Invalid contact number.";
            }

            if (empty($errors)) {

                $this->person->create(
                    $name,
                    $age,
                    $gender,
                    $email,
                    $address,
                    $contact_num
                );

                $message = "Person successfully registered!";
            } else {
                $message = implode("<br>", $errors);
            }
        }

        $persons = $this->person->getAll();

        require __DIR__ . '/../views/person/index.php';
    }
}