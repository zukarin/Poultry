    <?php
    // Assume you have a database connection established
    include('../db_connection.php');

    // Function to delete a product by ID
    function deleteProduct($connection, $productId) {
        $delete_product_query = "DELETE FROM products WHERE product_id = $productId";
        $result = mysqli_query($connection, $delete_product_query);
        

        if ($result) {
            return true; // Deletion successful
            
        } else {
            return false; // Deletion failed
        }
    }

    // Check if the delete form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
        
        $productIdToDelete = $_POST['product_id_to_delete'];

        // Call the deleteProduct function
        $isDeleted = deleteProduct($connection, $productIdToDelete);

        if ($isDeleted) {
            echo "<script>
                    alert('Product deleted successfully!');
                    window.location.href = './admin.php?view_product=true';
                </script>";
            exit();
        } else {
            echo "Error deleting product: " . mysqli_error($connection);
            exit();
        }
    }

    // Fetch products from the database
    $select_products = "SELECT * FROM products";
    $result = mysqli_query($connection, $select_products);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Products</title>

        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                margin: 20px;
                background-color: #f5f5f5;
            }

            h2 {
                text-align: center;
                color: #333;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                background-color: #fff;
            }

            th, td {
                padding: 15px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th {
                background-color: #3498db;
                color: #fff;
            }

            tr:hover {
                background-color: #ecf0f1;
            }

            a {
                text-decoration: none;
                color: #3498db;
            }

            a:hover {
                color: #2980b9;
                
            }
            button {
                text-decoration: none;
                color: #3498db;
                /* display: inline-block; */
                padding: 8px 16px;
                border: none;
                /* border-radius: 0; */
                /* transition: background-color 0.3s; */
            }
        </style>

    <script>
        // JavaScript function to open the image in a new tab
        function openImageInNewTab(imageSrc) {
            window.open(imageSrc, '_blank');
        }

        // JavaScript function to confirm and submit the form
        function confirmAndSubmit(form, productId, productTitle) {
            var confirmDelete = confirm("Are you sure you want to delete the product '" + productTitle + "'?");
            
            if (confirmDelete) {
                form.submit();
            }
            else{
                return false; // Prevent the default button behavior
        }
    }
    </script>


    </head>

    <body>

    <h2>Admin Products View</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Image</th> 
                <th>Actions</th>
            </tr>
        </thead>
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['product_id']}</td>";
                echo "<td>{$row['product_title']}</td>";
                echo "<td>{$row['product_description']}</td>";
                echo "<td>{$row['product_price']}</td>";
                // Display a smaller version of the image with an onclick event to open in a new tab
                echo "<td><img src='./product_images/{$row['product_image1']}' alt='Product Image' width='50' onclick='openImageInNewTab(\"./product_images/{$row['product_image1']}\")'></td>";
                echo "<td>
                        <a href='update_product.php?id={$row['product_id']}'>Update</a>
                        <form method='post' style='display:inline;' action=''>
                            <input type='hidden' name='product_id_to_delete' value='{$row['product_id']}'>
                            <button type='submit' name='delete_product' onclick='return confirmAndSubmit(this.form, {$row['product_id']}, \"{$row['product_title']}\")'>Delete</button>
                        </form>
                      </td>";

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    </body>
    </html>
