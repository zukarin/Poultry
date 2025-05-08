<?php
session_start();
include('../db_connection.php');

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login,signup/login_signup.php");
    exit();
}

$user_email = $_SESSION['user_email'];
$cart = $_SESSION['cart'];

// Initialize total quantity and total price
$totalQuantity = 0;
$totalPrice = 0;

// Check if the "Pay Now" button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_now'])) {
    // Check if payment_method is set in the POST data
    if (!isset($_POST['payment_method'])) {
        // Handle the case where payment_method is not set (display an error, redirect, etc.)
        echo "Error: Payment method not selected.";
        exit();
    }

    // Initialize total quantity and total price inside the loop
    $totalQuantity = 0;
    $totalPrice = 0;

    // Determine the payment method
    $payment_method = $_POST['payment_method'];

    // Check if the selected payment method is GCASH and handle the file upload for proof image
    if ($payment_method === 'GCASH' && isset($_FILES['proof_image'])) {
        $file = $_FILES['proof_image'];

        // Check if the file is uploaded successfully
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Get file information
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            // Move the uploaded proof image file to a specific directory
            $proofImageName = basename($fileName);
            $proofImageUploadDirectory = "./proof_images/";
            move_uploaded_file($fileTmpName, $proofImageUploadDirectory . $proofImageName);

            // Insert proof image details into the database
            $insert_proof_image_query = "INSERT INTO proof_images (user_email, file_name, file_size, file_type, upload_date) VALUES (?, ?, ?, ?, NOW())";
            $stmt_proof_image = mysqli_prepare($connection, $insert_proof_image_query);
            mysqli_stmt_bind_param($stmt_proof_image, "ssds", $user_email, $proofImageName, $fileSize, $fileType);

            mysqli_stmt_execute($stmt_proof_image);
            mysqli_stmt_close($stmt_proof_image);

            // Continue with your existing code for storing proof image details in the orders table
            // ...

        } else {
            // Handle the file upload error (display an error, redirect, etc.)
            echo "Error uploading file.";
            exit();
        }
    }

    // Iterate through each item in the cart
    foreach ($cart as $key => $cartItem) {
        // Fetch product details from the database
        $select_product_query = "SELECT product_price FROM products WHERE product_id = ?";
        $stmt = mysqli_prepare($connection, $select_product_query);
        mysqli_stmt_bind_param($stmt, "i", $key);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        // Calculate the total price for each item
        $totalItemPrice = $product['product_price'] * $cartItem['quantity'];

        // Insert order into the database with 'Pending' status
        $insert_order_query = "INSERT INTO orders (user_email, product_id, quantity, total_price, payment_method, order_status, order_date, cancelable) VALUES (?, ?, ?, ?, ?, 'Pending', NOW(), 1)";
        $stmt_insert = mysqli_prepare($connection, $insert_order_query);
        mysqli_stmt_bind_param($stmt_insert, "siids", $user_email, $key, $cartItem['quantity'], $totalItemPrice, $payment_method);

        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
    }

    // Clear the cart after the order is inserted
    $_SESSION['cart'] = array();

    // Redirect to the checkout success page
    header("Location: order_history.php");
    exit();
}

// Close the database connection

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./home_with_user.css">
    <link rel="stylesheet" href="./checkout.css">
    <style>
        .image-container img {
            max-width: 70%;
            height: 100%;
            
        }
    </style>

    <title>Checkout</title>
    
</head>
<body>


<section id="header">
<?php

if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
    $username = $_SESSION['username'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: ../login,signup/login_signup.php");
    exit();
}
$cart = $_SESSION['cart']; 
    $totalQuantity = 0;

    foreach ($cart as $item) {
        $totalQuantity += $item['quantity'];
    }


    
?>

<!-- sa taas ng web(navigator-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="../flower/1.html">Furniture Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./home_with_user.php">Home</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./home_shop_user.php">Shop</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./about_.php">About</a>
                </li>
                <li class="nav-item mx-4">
                    <a class="nav-link active" aria-current="page" href="./contact.php">Contact</a>
                </li>
                <li class="nav-item mx-4">
                
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fa-solid fa-user" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">  Welcome,  <?php echo $username; ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="profile.php">Account information</a></li>
                        <!-- <li><a class="dropdown-item" href="./viewcart.php"> Cart <i class="fa-solid fa-cart-shopping"><sup><sup><?php echo $totalQuantity ?></sup></sup></i>  </a></li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Logout</a></li>
                    </ul>
                </li>

                <div class='text-right ml-5'>
                    <li class="nav-item dropdown">
                        <div class="dropdowns">
                            <button type="button" class="btn btn-info" data-toggle="dropdown">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger"><?php echo $totalQuantity ?></span>
                            </button>
                            <div class="dropdown-menu">
                                <?php
                                $totalQuantity = 0;
                                $totalCartPrice = 0;

                                foreach ($cart as $key => $cartItem):
                                    $select_products = "SELECT products.*, brands.brand_title 
                                        FROM products 
                                        LEFT JOIN brands ON products.brand_id = brands.brand_id 
                                        WHERE product_id = $key";
                                    $result = mysqli_query($connection, $select_products);
                                    $row = mysqli_fetch_assoc($result);

                                    $totalPrice = $row['product_price'] * $cartItem['quantity'];
                                    $totalQuantity += $cartItem['quantity'];
                                    $totalCartPrice += $totalPrice;
                                ?>

                                <div class="row cart-detail">
                                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                        <img width='50' src="../admin/product_images/<?php echo $row['product_image1']; ?>" alt="Product Image">
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                        <p><?php echo $row['product_title'] . ' (' . $row['brand_title'] . ')' ?></p>
                                        <span class="price text-info">₱ <?php echo number_format($row['product_price']); ?></span> <span class="count"> Quantity: <?php echo $cartItem['quantity']; ?></span>
                                    </div>
                                </div>

                                <?php endforeach;?>
                                
                                <div class="row total-header-section">
                                    <div class="col-lg-6 col-sm-6 col-6">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger"><?php echo $totalQuantity ?></span>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                        <p>Total: <span class="text-info">₱ <?php echo number_format($totalCartPrice, 2); ?></span></p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                        <button class="btn btn-primary btn-block">Checkout</button>
                                        <a href="./viewcart.php" class="btn btn-primary btn-block">Cart</a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </li>
                </div> 
            </ul>
        </div>
    </div>
</nav>


</section>



<section class="top">
    
    <?php
   

    // Check if the user is logged in
    if (!isset($_SESSION['user_email'])) {
        header("Location: ../login,signup/login_signup.php");
        exit();
    }

    // Use the email from the session
    $user_email = $_SESSION['user_email'];

    // Check if email parameter is provided in the URL
    if (isset($_GET['email'])) {
        // Use the email from the URL if provided
        $user_email = $_GET['email'];
    }

    // Retrieve user information from the database based on the provided email
    $query = "SELECT * FROM `users` WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        echo "Error: User not found.";
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Close the database connection
    mysqli_close($connection);
    ?>
    <div class="edit-profile-container">
    <h2>Account information</h2>
    <form id="edit-profile-form" name="editProfileForm" method="post" action="update_profile.php">
        <!-- Display user information in input fields for editing -->
        <p>Name:</p>
        <input type="text" name="username" value="<?php echo $user_data['username']; ?>" required>

        <p>Email:</p>
        <input type="email" name="email" value="<?php echo $user_data['email']; ?>" required>

        <p>Shipping Address:</p>
        <input type="text" name="shipping_address" value="<?php echo $user_data['adress']; ?>" required>

        <p>Phone Number:</p>
        <input type="tel" name="phone_number" value="<?php echo $user_data['phone_number']; ?>" required>

        <p>Birthdate:</p>
        <input type="date" name="birthdate" value="<?php echo $user_data['birthdate']; ?>" required>

        <p>Gender:</p>
        <select name="gender" required>
            <option value="male" <?php echo ($user_data['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($user_data['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo ($user_data['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
        </select>
        <br>
        <button type="submit" name="update_profile">Update Profile</button>
    </form>
</div>
</section>

<section class="bot image-container">
    <div class="payment-method mt-3">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="row ">
                <div class="col-md-4 ">
                    <input name="payment_method" id="radio2" class="mr-2 css-checkbox" type="radio" value="COD"><span>Cash on delivery (COD)</span>
                    <div class="space20"></div>
                    <p>Please prepare the amount on delivery</p>
                </div>
        <div class="col-md-4  ">
            <input name="payment_method" id="radio3" class="mr-2 css-checkbox" type="radio" value="GCASH">
            <span>(Gcash)</span>
            <div class="space20"></div>
            <p>Put or Insert your proof of payment</p>
            <p>Make sure to pay by scanning before you click pay now</p>
            <input type="file" name="proof_image" accept="image/*" >
        </div>

        <div class="col-md-3 d-flex ">
            <img src="../pictures/gcash_pay.jpg" alt="Image Description">
        </div>

            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn" name="pay_now">Pay Now</button>
                </div>
            </div>
        </form>
    </div>
</section>


<script>
    function confirmOrder() {
        // You can add JavaScript logic to handle the order confirmation
        // For example, you can use AJAX to update the database
        alert('Order confirmed! Database updated.');
        // Redirect the user to the checkout success page
        window.location.href = 'checkout_success.php';
    }
</script>

</body>
</html>
