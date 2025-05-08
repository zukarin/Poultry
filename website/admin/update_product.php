<?php
include('../db_connection.php');

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details based on product_id
    $select_product = "SELECT * FROM products WHERE product_id = $product_id";
    $result_product = mysqli_query($connection, $select_product);

    if ($result_product && $row = mysqli_fetch_assoc($result_product)) {
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_keywords = $row['product_keyword'];    
        $product_category = $row['category_id'];
        $product_brands = $row['brand_id'];
        $product_price = $row['product_price'];
        // You may need to adjust the following lines based on your database structure
        $product_image1 = $row['product_image1'];
        $product_image2 = $row['product_image2'];
        $product_image3 = $row['product_image3'];
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

// Check if the form is submitted
if (isset($_POST['update_product'])) {
    // Retrieve form data
    $product_title = $_POST['product_title'];
    $product_description = $_POST['productDescription'];
    $product_keywords = $_POST['productKeywords'];
    $product_category = $_POST['category'];
    $product_brands = $_POST['brand'];
    $product_price = $_POST['productPrice'];

    // Check if new images are provided
    if ($_FILES['new_productImage1']['name']) {
        $new_product_image1 = $_FILES['new_productImage1']['name'];
        $temp_new_image1 = $_FILES['new_productImage1']['tmp_name'];
        move_uploaded_file($temp_new_image1, "./product_images/$new_product_image1");
        // Update the database with the new image path
        // You may need to adjust the database update query based on your structure
        $update_image1_query = "UPDATE products SET product_image1 = '$new_product_image1' WHERE product_id = $product_id";
        mysqli_query($connection, $update_image1_query);
    }

    // Repeat the process for product_image2 and product_image3

    // Perform the update query based on the form data
    $update_product_query = "UPDATE products SET
                            product_title = '$product_title',
                            product_description = '$product_description',
                            product_keyword = '$product_keywords',
                            category_id = '$product_category',
                            brand_id = '$product_brands',
                            product_price = '$product_price'
                            WHERE product_id = $product_id";

    $result_update = mysqli_query($connection, $update_product_query);

    if ($result_update) {
        echo "<script>
                alert('Product updated successfully!');
                window.location.href = './admin.php?view_product=true';
              </script>";
    } else {
        echo "Error updating product: " . mysqli_error($connection);
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
    <h2 class="mb-4">Update Product</h2>
    
    <!-- product title -->
    <form action="update_product.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="productTitle" class="form-label">Product Title:</label>
            <input type="text" class="form-control" id="productTitle" name="product_title" value="<?php echo $product_title; ?>" required>
        </div>

    <!-- product description -->
        <div class="mb-3">
            <label for="productDescription" class="form-label">Product Description:</label>
            <textarea class="form-control" id="productDescription" name="productDescription" rows="3" required><?php echo $product_description; ?></textarea>
        </div>

    <!-- productKeywords -->
        <div class="mb-3">
            <label for="productKeywords" class="form-label">Product Keywords:</label>
            <input type="text" class="form-control" id="productKeywords" name="productKeywords" value="<?php echo $product_keywords; ?>" required>
        </div>

    <!-- select category(with database) -->
        <div class="mb-3">
            <label for="category" class="form-label">Select a Category:</label>
            <select class="form-select" id="category" name="category" required>
                <!-- PHP start -->
                <?php
                    $select_categories = "SELECT * FROM categories";
                    $result_categories = mysqli_query($connection, $select_categories);

                    while ($row_data = mysqli_fetch_assoc($result_categories)) {
                        $category_id = $row_data["category_id"];
                        $category_title = $row_data["category_title"];
                        $selected = ($category_id == $product_category) ? "selected" : "";
                        echo "<option value='$category_id' $selected>$category_title</option>";
                    }
                ?>
                <!-- PHP end -->
            </select>
        </div>

    <!-- select brand(with database) -->
        <div class="mb-3">
            <label for="brand" class="form-label">Select a Brand:</label>
            <select class="form-select" id="brand" name="brand" required>
                <?php
                    $select_brands = "SELECT * FROM brands";
                    $result_brands = mysqli_query($connection, $select_brands);

                    while ($row_data = mysqli_fetch_assoc($result_brands)) {
                        $brand_id = $row_data["brand_id"];
                        $brand_title = $row_data["brand_title"];
                        $selected = ($brand_id == $product_brands) ? "selected" : "";
                        echo "<option value='$brand_id' $selected>$brand_title</option>";
                    }
                ?>
                <!-- PHP end -->
            </select>
        </div>
        
    <!-- productImage1 -->
        <div class="mb-3">
            <label for="productImage1" class="form-label">Product Image 1:</label>
            <input type="file" class="form-control" id="new_productImage1" name="new_productImage1" accept="image/*">
            <!-- Display the existing image -->
            <img src="./product_images/<?php echo $product_image1; ?>" alt="Product Image 1" class="mt-2" width="100">
        </div>

    <!-- productImage2 -->
        <div class="mb-3">
            <label for="productImage2" class="form-label">Product Image 2:</label>
            <input type="file" class="form-control" id="new_productImage2" name="new_productImage2" accept="image/*">
            <!-- Display the existing image -->
            <img src="./product_images/<?php echo $product_image2; ?>" alt="Product Image 2" class="mt-2" width="100">
        </div>

    <!-- productImage3 -->
        <div class="mb-3">
            <label for="productImage3" class="form-label">Product Image 3:</label>
            <input type="file" class="form-control" id="new_productImage3" name="new_productImage3" accept="image/*">
            <!-- Display the existing image -->
            <img src="./product_images/<?php echo $product_image3; ?>" alt="Product Image 3" class="mt-2" width="100">
        </div>
        

    <!-- productPrice -->
        <div class="mb-3">
            <label for="productPrice" class="form-label">Product Price:</label>
            <input type="number" class="form-control" id="productPrice" name="productPrice" value="<?php echo $product_price; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
    </form>
</div>
</body>
</html>
