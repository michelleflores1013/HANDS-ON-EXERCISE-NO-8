<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>PHP Output #5 - Faculty CRUD</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h1>PHP Output #5</h1>

    <h2>
        <?= $editFaculty
            ? 'Edit Faculty'
            : 'Add Faculty'
        ?>
    </h2>

    <?php if (!empty($message)): ?>

        <div class="message">
            <?= $message ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <?php if ($editFaculty): ?>

            <input
                type="hidden"
                name="faculty_id"
                value="<?= htmlspecialchars(
                    $editFaculty['faculty_id']
                ) ?>"
            >

        <?php endif; ?>


        <input
            type="hidden"
            name="action"
            value="save"
        >


        <div>
            <label>First Name:</label>

            <input
                type="text"
                name="first_name"
                value="<?= htmlspecialchars(
                    $editFaculty['first_name'] ?? ''
                ) ?>"
                required
            >
        </div>


        <div>
            <label>Middle Name:</label>

            <input
                type="text"
                name="middle_name"
                value="<?= htmlspecialchars(
                    $editFaculty['middle_name'] ?? ''
                ) ?>"
            >
        </div>


        <div>
            <label>Last Name:</label>

            <input
                type="text"
                name="last_name"
                value="<?= htmlspecialchars(
                    $editFaculty['last_name'] ?? ''
                ) ?>"
                required
            >
        </div>


        <div>
            <label>Age:</label>

            <input
                type="number"
                name="age"
                min="18"
                max="100"
                value="<?= htmlspecialchars(
                    $editFaculty['age'] ?? ''
                ) ?>"
                required
            >
        </div>


        <div>
            <label>Gender:</label>

            <select name="gender" required>

                <option value="">
                    -- Select Gender --
                </option>

                <option
                    value="Male"
                    <?= (
                        ($editFaculty['gender'] ?? '') === 'Male'
                    ) ? 'selected' : '' ?>
                >
                    Male
                </option>

                <option
                    value="Female"
                    <?= (
                        ($editFaculty['gender'] ?? '') === 'Female'
                    ) ? 'selected' : '' ?>
                >
                    Female
                </option>

            </select>

        </div>


        <div>

            <label>Address:</label>

            <input
                type="text"
                name="address"
                value="<?= htmlspecialchars(
                    $editFaculty['address'] ?? ''
                ) ?>"
                required
            >

        </div>


        <div>

            <label>Position:</label>

            <input
                type="text"
                name="position"
                value="<?= htmlspecialchars(
                    $editFaculty['position'] ?? ''
                ) ?>"
                required
            >

        </div>


        <div>

            <label>Salary:</label>

            <input
                type="number"
                name="salary"
                min="0"
                step="0.01"
                value="<?= htmlspecialchars(
                    $editFaculty['salary'] ?? ''
                ) ?>"
                required
            >

        </div>


        <button type="submit">

            <?= $editFaculty
                ? 'Update Faculty'
                : 'Add Faculty'
            ?>

        </button>


        <?php if ($editFaculty): ?>

            <a href="index.php?page=faculty">
                Cancel
            </a>

        <?php endif; ?>

    </form>


    <h2>Faculty List</h2>


    <table>

        <thead>

            <tr>

                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Position</th>
                <th>Salary</th>
                <th>Actions</th>

            </tr>

        </thead>


        <tbody>

        <?php foreach ($faculties as $faculty): ?>

            <tr>

                <td>
                    <?= htmlspecialchars(
                        $faculty['faculty_id']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['first_name']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['middle_name']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['last_name']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['age']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['gender']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['address']
                    ) ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $faculty['position']
                    ) ?>
                </td>

                <td>
                    ₱<?= number_format(
                        $faculty['salary'],
                        2
                    ) ?>
                </td>

                <td>

                    <a
                        href="index.php?page=faculty&edit=<?= $faculty['faculty_id'] ?>"
                    >
                        Edit
                    </a>


                    <form
                        method="POST"
                        style="display:inline;"
                    >

                        <input
                            type="hidden"
                            name="action"
                            value="delete"
                        >

                        <input
                            type="hidden"
                            name="faculty_id"
                            value="<?= $faculty['faculty_id'] ?>"
                        >

                        <button type="submit">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>
</html>