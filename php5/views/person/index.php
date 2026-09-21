<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP Output #3/#4</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h1>PHP Output #3/#4</h1>

    <?php if (!empty($message)): ?>
        <div class="message">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <h2>Registration Form</h2>

    <form method="POST">

        <div>
            <label>Name:</label>
            <input
                type="text"
                name="name"
                placeholder="Enter your Name"
                required
            >
        </div>

        <div>
            <label>Age:</label>
            <input
                type="number"
                name="age"
                min="1"
                max="120"
                placeholder="Enter your age"
                required
            >
        </div>

        <div>
            <label>Gender:</label>

            <select name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>

        <div>
            <label>Email:</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >
        </div>

        <div>
            <label>Address:</label>

            <input
                type="text"
                name="address"
                placeholder="Enter your Address"
                required
            >
        </div>

        <div>
            <label>Contact Number:</label>

            <input
                type="tel"
                name="contact_num"
                placeholder="Enter your Contact Number"
                pattern="[0-9+\-\s]+"
                required
            >
        </div>

        <button type="submit">
            Register
        </button>

    </form>


    <h2>List of Registered Persons</h2>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Address</th>
                <th>Contact Number</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($persons as $person): ?>

            <tr>
                <td><?= htmlspecialchars($person['id']) ?></td>

                <td>
                    <?= htmlspecialchars($person['name']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($person['age']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($person['gender']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($person['email']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($person['address']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($person['contact_num']) ?>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>

</body>
</html>