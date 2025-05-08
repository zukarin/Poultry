<?php
include('../db_connection.php');

// Fetch user data from the database
$query = "SELECT id, username, email, password FROM users";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    echo "<table border='1'>
            <tr>
                <th>id</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
            </tr>";

    // Fetch and display each row of data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td>{$row['password']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
