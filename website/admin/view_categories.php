<?php
include('../db_connection.php');


// Handle category deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $categoryId = $_GET['delete'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM test.categories WHERE category_id = ?";
    $stmt = mysqli_prepare($connection, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Redirect to view_categories.php with success=true parameter
    header("Location: view_categories.php?success=true");
    exit();
}


// Retrieve all categories from the database
$selectQuery = "SELECT * FROM test.categories";
$result = mysqli_query($connection, $selectQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
 
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

<h1>Categories</h1>

<?php
// Check if there are categories in the database
if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Category ID</th><th>Category Name</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['category_id']}</td>";
        echo "<td>{$row['category_title']}</td>";
        echo "<td><button class='delete-btn' onclick='deleteCategory({$row['category_id']})'>Delete</button></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No categories found.";
}

// Close the database connection
mysqli_close($connection);
?>

<script>
    function deleteCategory(categoryId) {
        // Ask for confirmation before deletion
        if (confirm("Are you sure you want to delete this category?")) {
            // Redirect to delete action
            window.location.href = "view_categories.php?delete=" + categoryId;
        }
    }

    // Check if there is a success message in the URL and redirect to admin.php
    const urlParams = new URLSearchParams(window.location.search);
    const successMessage = urlParams.get('success');
    if (successMessage === 'true') {
        setTimeout(() => {
            window.location.href = "admin.php?view_categories=true";
        }, 1000); // Redirect after 1 second (adjust the delay if needed)
    }
</script>


</body>
</html>
