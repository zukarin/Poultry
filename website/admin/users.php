<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>

    <style>
       

        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>User Information</h1>

<?php
include('../db_connection.php');

// Retrieve all user information from the database
$query = "SELECT * FROM `users`";
$result = mysqli_query($connection, $query);

// Check if there are users in the database
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Username</th><th>Email</th><th>Shipping Address</th><th>Phone Number</th><th>Birthdate</th><th>Gender</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['username']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['adress']}</td>";
        echo "<td>{$row['phone_number']}</td>";
        echo "<td>{$row['birthdate']}</td>";
        echo "<td>{$row['gender']}</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No users found.";
}

// Close the database connection
mysqli_close($connection);
?>

</body>
</html>
