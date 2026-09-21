<?php


$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("MySQL Connection Failed: " . $conn->connect_error);
}
$conn->query("CREATE DATABASE IF NOT EXISTS php_output");

$conn->select_db("php_output");

$conn->set_charset("utf8mb4");


$conn->query("
    CREATE TABLE IF NOT EXISTS persons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        age INT NOT NULL,
        gender VARCHAR(20) NOT NULL,
        address VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");



if (isset($_POST['register'])) {

    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $age        = $_POST['age'];
    $gender     = $_POST['gender'];
    $address    = trim($_POST['address']);

    $stmt = $conn->prepare("
        INSERT INTO persons
        (first_name, last_name, age, gender, address)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssiss",
        $first_name,
        $last_name,
        $age,
        $gender,
        $address
    );

    if ($stmt->execute()) {
        $stmt->close();

        header("Location: index.php");
        exit();
    }

    $stmt->close();
}


if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    $stmt = $conn->prepare(
        "DELETE FROM persons WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}


if (isset($_POST['update'])) {

    $id         = intval($_POST['id']);
    $first_name = trim($_POST['first_name']);
    $last_name  = trim($_POST['last_name']);
    $age        = $_POST['age'];
    $gender     = $_POST['gender'];
    $address    = trim($_POST['address']);

    $stmt = $conn->prepare("
        UPDATE persons
        SET first_name = ?,
            last_name = ?,
            age = ?,
            gender = ?,
            address = ?
        WHERE id = ?
    ");

    $stmt->bind_param(
        "ssissi",
        $first_name,
        $last_name,
        $age,
        $gender,
        $address,
        $id
    );

    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}


$edit_person = null;

if (isset($_GET['edit'])) {

    $id = intval($_GET['edit']);

    $stmt = $conn->prepare(
        "SELECT * FROM persons WHERE id = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result_edit = $stmt->get_result();

    $edit_person = $result_edit->fetch_assoc();

    $stmt->close();
}



$result = $conn->query("
    SELECT * FROM persons
    ORDER BY id DESC
");

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PHP Output #5</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: pink;
        }

        h2 {
            margin-top: 30px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            font-weight: bold;
            margin-top: 5px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        button {
            margin-top: 15px;
            padding: 12px;
            background: pink;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #ff8fab;
        }

        .cancel {
            display: block;
            margin-top: 10px;
            padding: 12px;
            text-align: center;
            background: #777;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background: pink;
            color: white;
        }

        .edit {
            background: #4caf50;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .delete {
            background: #f44336;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>PHP Output #5</h1>


    <?php if ($edit_person): ?>


        <h2>Edit Registered Person</h2>

        <form method="POST">

            <input
                type="hidden"
                name="id"
                value="<?= $edit_person['id'] ?>"
            >

            <label>First Name</label>

            <input
                type="text"
                name="first_name"
                value="<?= htmlspecialchars($edit_person['first_name']) ?>"
                required
            >


            <label>Last Name</label>

            <input
                type="text"
                name="last_name"
                value="<?= htmlspecialchars($edit_person['last_name']) ?>"
                required
            >


            <label>Age</label>

            <input
                type="number"
                name="age"
                value="<?= $edit_person['age'] ?>"
                min="1"
                required
            >


            <label>Gender</label>

            <select name="gender" required>

                <option value="">Select Gender</option>

                <option value="Male"
                    <?= $edit_person['gender'] == 'Male' ? 'selected' : '' ?>>
                    Male
                </option>

                <option value="Female"
                    <?= $edit_person['gender'] == 'Female' ? 'selected' : '' ?>>
                    Female
                </option>

            </select>


            <label>Address</label>

            <textarea
                name="address"
                rows="3"
                required
            ><?= htmlspecialchars($edit_person['address']) ?></textarea>


            <button type="submit" name="update">
                Update
            </button>

            <a href="index.php" class="cancel">
                Cancel
            </a>

        </form>


    <?php else: ?>


        <!-- =========================
             REGISTRATION FORM
        ========================== -->

        <h2>Registration Form</h2>

        <form method="POST">

            <label>First Name</label>

            <input
                type="text"
                name="first_name"
                placeholder="Enter first name"
                required
            >


            <label>Last Name</label>

            <input
                type="text"
                name="last_name"
                placeholder="Enter last name"
                required
            >


            <label>Age</label>

            <input
                type="number"
                name="age"
                placeholder="Enter age"
                min="1"
                required
            >


            <label>Gender</label>

            <select name="gender" required>

                <option value="">
                    Select Gender
                </option>

                <option value="Male">
                    Male
                </option>

                <option value="Female">
                    Female
                </option>

            </select>


            <label>Address</label>

            <textarea
                name="address"
                rows="3"
                placeholder="Enter address"
                required
            ></textarea>


            <button type="submit" name="register">
                Register
            </button>

        </form>

    <?php endif; ?>


    <!-- =========================
         REGISTERED PERSONS
    ========================== -->

    <h2>List of Registered Person</h2>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Action</th>
            </tr>

        </thead>

        <tbody>

        <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <tr>

                    <td>
                        <?= $row['id'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['first_name']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['last_name']) ?>
                    </td>

                    <td>
                        <?= $row['age'] ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['gender']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['address']) ?>
                    </td>

                    <td>

                        <a
                            class="edit"
                            href="index.php?edit=<?= $row['id'] ?>"
                        >
                            Edit
                        </a>

                        <a
                            class="delete"
                            href="index.php?delete=<?= $row['id'] ?>"
                            onclick="return confirm('Are you sure you want to delete this person?')"
                        >
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>

                <td colspan="7" class="empty">
                    No registered person yet.
                </td>

            </tr>

        <?php endif; ?>

        </tbody>

    </table>

</div>

</body>

</html>