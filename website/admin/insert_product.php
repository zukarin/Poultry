<?php
include('../db_connection.php');
if(isset($_POST['insert_product'])){

    $product_title = $_POST['product_title'];
    $product_description = $_POST['productDescription'];
    $product_keywords = $_POST['productKeywords'];
    $product_category = $_POST['category'];
    $product_brands = $_POST['brand'];
    $product_price = $_POST['productPrice'];
    $product_status = 'true';

    // accessing images
    $product_image1 = $_FILES['productImage1']['name'];
    $product_image2 = $_FILES['productImage2']['name'];
    $product_image3 = $_FILES['productImage3']['name'];
    // accessing images in the file
    $temp_image1 = $_FILES['productImage1']['tmp_name'];
    $temp_image2 = $_FILES['productImage2']['tmp_name'];
    $temp_image3 = $_FILES['productImage3']['tmp_name'];

    if($product_title=='' or $product_description=='' or $product_keywords==''  or $product_category=='' or $product_brands=='' or $product_price=='' or $product_image1=='' or $product_image2=='' or $product_image3==''){
        echo "<script>alert('fill all of it!');</script>";
        exit();
    } else {
        move_uploaded_file($temp_image1,"./product_images/$product_image1");
        move_uploaded_file($temp_image2,"./product_images/$product_image2");
        move_uploaded_file($temp_image3,"./product_images/$product_image3");

        // insert query
        $insert_products = "INSERT INTO `products` (`product_title`, `product_description`, `product_keyword`, `category_id`, `brand_id`, `product_image1`, `product_image2`, `product_image3`, `product_price`, `date`, `status`) 
        VALUES ('$product_title', '$product_description', '$produc_keywords', '$product_category', '$product_brands' , '$product_image1', '$product_image2', '$product_image3','$product_price', CURRENT_TIMESTAMP, '$product_status')";
        $result_query= mysqli_query($connection, $insert_products);
        if($result_query){
            echo "<script>
            alert('Successfully inserted a product');
            window.location.href = './admin.php?insert_product=true';
        </script>";
        }
        }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./insert_product.css"> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.f0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Insert Product</h2>
    
    <!-- product title -->
    <form action="insert_product.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="productTitle" class="form-label">Product Title:</label>
            <input type="text" class="form-control" id="productTitle" name="product_title" required>
        </div>

    <!-- product description -->
        <div class="mb-3">
            <label for="productDescription" class="form-label">Product Description:</label>
            <textarea class="form-control" id="productDescription" name="productDescription" rows="3" required></textarea>
        </div>

    <!-- productKeywords -->
        <div class="mb-3">
            <label for="productKeywords" class="form-label">Product Keywords:</label>
            <input type="text" class="form-control" id="productKeywords" name="productKeywords" required>
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
                $category_title = $row_data["category_title"];
               $category_id = $row_data["category_id"];
            echo "<option value='$category_id'>$category_title</option>";
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
                $brand_title = $row_data["brand_title"];
                $brand_id = $row_data["brand_id"];
                echo "<option value='$brand_id'>$brand_title</option>";
              }
               ?>
            <!-- PHP end -->
            </select>
        </div>
        
    <!-- productImage1 -->
        <div class="mb-3">
            <label for="productImage1" class="form-label">Product Image 1:</label>
            <input type="file" class="form-control" id="productImage1" name="productImage1" accept="image/*" required>
        </div>

    <!-- productImage2 -->
        <div class="mb-3">
            <label for="productImage2" class="form-label">Product Image 2:</label>
            <input type="file" class="form-control" id="productImage2" name="productImage2" accept="image/*" required>
        </div>

    <!-- productImage3 -->
        <div class="mb-3">
            <label for="productImage3" class="form-label">Product Image 3:</label>
            <input type="file" class="form-control" id="productImage3" name="productImage3" accept="image/*" required>
        </div>

    <!-- productPrice -->
        <div class="mb-3">
            <label for="productPrice" class="form-label">Product Price:</label>
            <input type="number" class="form-control" id="productPrice" name="productPrice" required>
        </div>

        <button type="submit" class="btn btn-primary" name="insert_product" >Insert Product</button>
    </form>
</div>
</body>
</html>
