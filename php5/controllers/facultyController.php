<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Faculty.php';

class FacultyController
{
    private $faculty;

    public function __construct()
    {
        $database = new Database();
        $db = $database->connect();

        $this->faculty = new Faculty($db);
    }

    public function index()
    {
        $message = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $action = $_POST['action'] ?? 'create';

            if ($action === 'delete') {

                $id = filter_input(
                    INPUT_POST,
                    'faculty_id',
                    FILTER_VALIDATE_INT
                );

                if ($id) {
                    $this->faculty->delete($id);
                    $message = "Faculty deleted successfully.";
                }

            } else {

                $data = [
                    ':first_name' => trim($_POST['first_name'] ?? ''),
                    ':middle_name' => trim($_POST['middle_name'] ?? ''),
                    ':last_name' => trim($_POST['last_name'] ?? ''),
                    ':age' => filter_input(
                        INPUT_POST,
                        'age',
                        FILTER_VALIDATE_INT
                    ),
                    ':gender' => $_POST['gender'] ?? '',
                    ':address' => trim($_POST['address'] ?? ''),
                    ':position' => trim($_POST['position'] ?? ''),
                    ':salary' => $_POST['salary'] ?? ''
                ];

                $errors = [];

                if ($data[':first_name'] === '') {
                    $errors[] = "First name is required.";
                }

                if ($data[':last_name'] === '') {
                    $errors[] = "Last name is required.";
                }

                if (
                    $data[':age'] === false ||
                    $data[':age'] < 18 ||
                    $data[':age'] > 100
                ) {
                    $errors[] = "Age must be between 18 and 100.";
                }

                if (!in_array(
                    $data[':gender'],
                    ['Male', 'Female']
                )) {
                    $errors[] = "Please select a valid gender.";
                }

                if ($data[':address'] === '') {
                    $errors[] = "Address is required.";
                }

                if ($data[':position'] === '') {
                    $errors[] = "Position is required.";
                }

                if (
                    !is_numeric($data[':salary']) ||
                    $data[':salary'] < 0
                ) {
                    $errors[] = "Salary must be a valid positive number.";
                }

                if (empty($errors)) {

                    $id = filter_input(
                        INPUT_POST,
                        'faculty_id',
                        FILTER_VALIDATE_INT
                    );

                    if ($id) {

                        $this->faculty->update($id, $data);

                        $message =
                            "Faculty updated successfully.";

                    } else {

                        $this->faculty->create($data);

                        $message =
                            "Faculty added successfully.";
                    }

                } else {

                    $message =
                        implode("<br>", $errors);
                }
            }
        }

        $editFaculty = null;

        if (isset($_GET['edit'])) {

            $id = filter_input(
                INPUT_GET,
                'edit',
                FILTER_VALIDATE_INT
            );

            if ($id) {
                $editFaculty =
                    $this->faculty->getById($id);
            }
        }

        $faculties = $this->faculty->getAll();

        require __DIR__ . '/../views/faculty/index.php';
    }
}