    <?php
    include('../db_connection.php');

    // Check if the product ID is provided
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];

        // Fetch product details based on product_id
        $select_product = "SELECT * FROM products WHERE product_id = $product_id";
        $result_product = mysqli_query($connection, $select_product);

        if ($result_product && $row = mysqli_fetch_assoc($result_product)) {
            // ... (unchanged part)
        } else {
            // Handle the case where the product ID is not valid
            echo "Invalid product ID.";
            exit();
        }
    } else {
        // Handle the case where no product ID is provided
        echo "Product ID not provided.";
        exit();
    }

    // Check if the form is submitted for updating the product
    if (isset($_POST['update_product'])) {
        // ... (unchanged part)
    }

    // Check if the form is submitted for deleting the product
    if (isset($_POST['delete_product'])) {
        // Perform the delete query based on the product_id
        $delete_product_query = "DELETE FROM products WHERE product_id = $product_id";
        $result_delete = mysqli_query($connection, $delete_product_query);

        if ($result_delete) {
            echo "<script>
                    alert('Product deleted successfully!');
                    window.location.href = './admin.php?view_product=true';
                </script>";
            exit(); // Terminate script after deletion
        } else {
            echo "Error deleting product: " . mysqli_error($connection);
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="./insert_product.css"> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Product</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.f0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>

    <div class="container mt-5">
        <h2 class="mb-4">Delete product</h2>
        
        <!-- product title -->
        <form action="update_product.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
            <!-- ... (unchanged part) -->

            <!-- Add a button to delete the product -->

        </form>
    </div>
    </body>
    </html>
