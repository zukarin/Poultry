<?php
include('../db_connection.php');

function get_products() {
    // Assuming $connection is already established elsewhere in your code
    global $connection;

    $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : 'all';
    $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';

    // SQL query to retrieve products based on selected category and brand
    $select_query = "SELECT products.*, brands.brand_title
                    FROM products
                    LEFT JOIN brands ON products.brand_id = brands.brand_id
                    WHERE ('$selectedBrand' = 'all' OR products.brand_id = '$selectedBrand') AND
                          ('$selectedCategory' = 'all' OR products.category_id = '$selectedCategory') 
                    ORDER BY RAND() LIMIT 0,8";

    $result_query = mysqli_query($connection, $select_query);

    // Check if there are any products
    if (mysqli_num_rows($result_query) > 0) {
        while ($row_data = mysqli_fetch_assoc($result_query)) {
            // Your existing code to display product details
            $product_id = $row_data['product_id'];
            $product_title = $row_data['product_title'];
            $product_brands = $row_data['brand_title'];
            $product_price = $row_data['product_price'];
            $product_image1 = $row_data['product_image1'];

            echo "<div class='pro' onclick='openProductDetails(\"$product_id\");'>

                    <img src='../admin/product_images/{$product_image1}' alt='{$product_title}'>
                    <div class='des'>
                        <span>{$product_brands}</span>
                        <h5>{$product_title}</h5>
                        <div class='star'>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                            <i class='fas fa-star'></i>
                        </div>
                        <h4>{$product_price}</h4>
                        </div>
                        <a href='javascript:void(0);' onclick='addToCart(\"{$product_title}\")'><i class='fa-solid fa-cart-shopping cart'></i></a>
                      </div>";
        }
    } else {
        // Display a message when there are no products
        echo "<p>There are no products in the selected category or brand.</p>";
    }
}

//  categories ang lalabas 
function product_directory() {
    global $connection;

    if (isset($_GET['product_id'])) {
        // Sanitize the product_id to prevent SQL injection
        $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);

        // Fetch product details from the database
        $select_query = "SELECT products.*, categories.category_title
                        FROM products
                        LEFT JOIN categories ON products.category_id = categories.category_id
                        WHERE product_id = $product_id";

        $result_query = mysqli_query($connection, $select_query);

        if ($row_data = mysqli_fetch_assoc($result_query)) {
            $product_category = $row_data['category_title']; // Use category_title instead of category_id
            $product_title = $row_data['product_title'];
            $product_price = $row_data['product_price'];
            $product_description = $row_data['product_description'];
            $product_image = $row_data['product_image1']; // Assuming the column name is 'product_image'
            $product_image1 = $row_data['product_image2'];
            $product_image2 = $row_data['product_image3'];
            // Add more fields as needed

            // Use these variables in your HTML
            echo "<div id='product-lightbox' class='product three lightbox'>
                    <div class='header'>
                        <!-- <div class='back' href='./shop.php'></div> -->
                        <a class='back' href='#'></a>
                    </div>
                    <div class='main'>
                        <div class='left'>
                            <h1 class='category_title'>$product_category</h1>
                            <h2 class='product_title'>$product_title</h2>
                            <h3 class='product_price'>$ $product_price</h3>
                            <img src='../admin/product_images/$product_image' alt='$product_title' />
                            <img class='img1' src='../admin/product_images/$product_image1' alt='$product_title' />
                            <img class='img2' src='../admin/product_images/$product_image2' alt='$product_title' />
                            <!-- Add more product details here -->
                        </div>
                        <div class='right'>
                            <p class='product_description'>$product_description</p>
                            <!-- Add more product details here -->
                        </div>
                    </div>
                    <div class='footer'>
    <div class='right footer'>
        <button class='right btn fa-solid fa-cart-shopping fa-lx' onclick='addToCart()'><p>Add to Cart</p></button>
    </div>
</div>  
                </div>";
        }
    }
}

// brands ang lalabas hindi category
// function product_directory() {
//     global $connection;

//     if (isset($_GET['product_id'])) {
//         // Sanitize the product_id to prevent SQL injection
//         $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);

//         // Fetch product details and brand information from the database
//         $select_query = "SELECT products.*, brands.brand_title
//                         FROM products
//                         LEFT JOIN brands ON products.brand_id = brands.brand_id
//                         WHERE product_id = $product_id";

//         $result_query = mysqli_query($connection, $select_query);

//         if ($row_data = mysqli_fetch_assoc($result_query)) {
//             $product_brand = $row_data['brand_title']; // Use brand_title instead of category_brands
//             $product_title = $row_data['product_title'];
//             $product_price = $row_data['product_price'];
//             $product_description = $row_data['product_description'];
//             $product_image = $row_data['product_image1']; // Assuming the column name is 'product_image'
//             $product_image1 = $row_data['product_image2'];
//             $product_image2 = $row_data['product_image3'];
//             // Add more fields as needed

//             // Use these variables in your HTML
//             echo "<div id='product-lightbox' class='product three lightbox'>
//                     <div class='header'>
//                         <!-- <div class='back' href='./shop.php'></div> -->
//                         <a class='back' href='#'></a>
//                     </div>
//                     <div class='main'>
//                         <div class='left'>
//                             <h1 class='brand'>$product_brand</h1> <!-- Update class to 'brand' -->
//                             <h2 class='product_title'>$product_title</h2>
//                             <h3 class='product_price'>$ $product_price</h3>
//                             <img src='../admin/product_images/$product_image' alt='$product_title' />
//                             <img class='img1' src='../admin/product_images/$product_image1' alt='$product_title' />
//                             <img class='img2' src='../admin/product_images/$product_image2' alt='$product_title' />
//                             <!-- Add more product details here -->
//                         </div>
//                         <div class='right'>
//                             <p class='product_description'>$product_description</p>
//                             <!-- Add more product details here -->
//                         </div>
//                     </div>
//                     <div class='footer'>
//                         <div class='right footer'>
//                             <button class='right btn fa-solid fa-cart-shopping fa-lx'><p>Add to Cart</p></button>
//                         </div>
//                     </div>
//                 </div>";
//         }
//     }
// }


function getproductss() {
    // Assuming $connection is already established elsewhere in your code
    global $connection;

    $select_query = "SELECT * FROM products";
    $result_query = mysqli_query($connection, $select_query);

    while ($row_data = mysqli_fetch_assoc($result_query)) {
        $product_title = $row_data['product_title'];
        $product_description = $row_data['product_description'];
        $produc_keywords = $row_data['product_keyword'];
        $product_category = $row_data['category_id'];
        $product_brands = $row_data['brand_id'];
        $product_price = $row_data['product_price'];
        $product_image1 = $row_data['product_image1'];

        echo "<div class='pro'>
                <img src='../admin/product_images/{$product_image1}' alt='{$product_title}'>
                <div class='des'>
                    <span>{$product_brands}</span>
                    <h5>{$product_title}</h5>
                    <div class='star'>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                    </div>
                    <h4>{$product_price}</h4>
                </div>
                <a href='{$product_image1}'><i class='fa-solid fa-cart-shopping cart'></i></a>
              </div>";
    }
}






// alert you must log in first
function getproductsss() {
    // Assuming $connection is already established elsewhere in your code
    global $connection;

    $select_query = "SELECT * FROM products";
    $result_query = mysqli_query($connection, $select_query);

    while ($row_data = mysqli_fetch_assoc($result_query)) {
        $product_title = $row_data['product_title'];
        $product_description = $row_data['product_description'];
        $produc_keywords = $row_data['product_keyword'];
        $product_category = $row_data['category_id'];
        $product_brands = $row_data['brand_id'];
        $product_price = $row_data['product_price'];
        $product_image1 = $row_data['product_image1'];

        echo "<div class='pro'>
                <img src='../admin/product_images/{$product_image1}' alt='{$product_title}'>
                <div class='des'>
                    <span>{$product_brands}</span>
                    <h5>{$product_title}</h5>
                    <div class='star'>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                    </div>
                    <h4>{$product_price}</h4>
                </div>
                <a href='javascript:void(0);' onclick='addToCart(\"{$product_title}\")'><i class='fa-solid fa-cart-shopping cart'></i></a>
              </div>";
    }
}

function getproducts() {
    // Assuming $connection is already established elsewhere in your code
    global $connection;

    $select_query = "SELECT * FROM products";
    $result_query = mysqli_query($connection, $select_query);

    while ($row_data = mysqli_fetch_assoc($result_query)) {
        $product_title = $row_data['product_title'];
        $product_description = $row_data['product_description'];
        $produc_keywords = $row_data['product_keyword'];
        $product_category = $row_data['category_id'];
        $product_brands = $row_data['brand_id'];
        $product_price = $row_data['product_price'];
        $product_image1 = $row_data['product_image1'];

        echo "<div class='pro'>
                <img src='../admin/product_images/{$product_image1}' alt='{$product_title}'>
                <div class='des'>
                    <span>{$product_brands}</span>
                    <h5>{$product_title}</h5>
                    <div class='star'>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                    </div>
                    <h4>{$product_price}</h4>
                </div>
                <a href='javascript:void(0);' onclick='addToCart(\"{$product_title}\")'><i class='fa-solid fa-cart-shopping cart'></i></a>
              </div>";
    }
}



?>




