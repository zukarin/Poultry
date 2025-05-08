<?php
include('../db_connection.php');

// Retrieve all brands from the database
$selectQuery = "SELECT * FROM test.brands";
$result = mysqli_query($connection, $selectQuery);


if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $brandId = $_GET['delete'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM test.brands WHERE brand_id = ?";
    $stmt = mysqli_prepare($connection, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $brandId);
    mysqli_stmt_execute($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Redirect to view_brands.php with success=true parameter
    header("Location: view_brands.php?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

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

        .delete-btn {
            background-color: #ff6666;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Brands</h1>

<?php
// Check if there are brands in the database
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Brand ID</th><th>Brand Name</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['brand_id']}</td>";
        echo "<td>{$row['brand_title']}</td>";
        echo "<td><button class='delete-btn' onclick='deleteBrand({$row['brand_id']})'>Delete</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No brands found.";
}

// Close the database connection
mysqli_close($connection);
?>
<script>
    function deleteBrand(brandId) {
        // Ask for confirmation before deletion
        if (confirm("Are you sure you want to delete this brand?")) {
            // Redirect to delete action
            window.location.href = "view_brands.php?delete=" + brandId;
        }
    }

    // Check if there is a success message in the URL and redirect to admin.php
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get('success');
    if (successMessage === 'true') {
        setTimeout(() => {
            window.location.href = "admin.php?view_brands=true";
        }, 1000); // Redirect after 1 second (adjust the delay if needed)
    }
</script>



</body>
</html>
