<?php
include('../db_connection.php');

$insert_statement = null; 

if (isset($_POST['insert_cat'])) {
    $category_title = $_POST['cat_title'];

    // Check if the category already exists
    $check_query = "SELECT * FROM categories WHERE category_title = ?";
    $check_statement = mysqli_prepare($connection, $check_query);
    mysqli_stmt_bind_param($check_statement, 's', $category_title);
    mysqli_stmt_execute($check_statement);
    mysqli_stmt_store_result($check_statement);

    if (mysqli_stmt_num_rows($check_statement) > 0) {
        echo "<script>alert('This Category already exists!');</script>";
    } else {
        // Insert the category if it doesn't exist
        $insert_query = "INSERT INTO categories (category_title) VALUES (?)";
        $insert_statement = mysqli_prepare($connection, $insert_query);
        mysqli_stmt_bind_param($insert_statement, 's', $category_title);

        $result = mysqli_stmt_execute($insert_statement);

        // Check if the query was successful
        if ($result) {
            echo "<script>alert('Category is inserted Successfully!');</script>";
        } else {
            throw new Exception(mysqli_error($connection));
        }
    }

    // Close the check statement
    mysqli_stmt_close($check_statement);
}

// Close the insert statement if it's not null
if ($insert_statement !== null) {
    mysqli_stmt_close($insert_statement);
}

mysqli_close($connection);
?>
<!-- php end for database connection -->

<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-bell"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-level="categories" aria-describedby="basic-addon1">
    </div>

   <div class="input-group w-10 mb-2">
        <input type="submit" class=" bg-info" name="insert_cat" value="Insert Categories" aria-level="Username" aria-describedby="basic-addon1">
    </div>
    <!-- <div class="input-group w-10 mb-2">
        <button type="submit" class="btn btn-info" name="insert_cat">Insert Categories</button>
    </div> -->
</form>
