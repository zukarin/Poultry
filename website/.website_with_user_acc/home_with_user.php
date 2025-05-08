<?php
    
    include('../db_connection.php');
    include('./addtocart.php');


    $cart = $_SESSION['cart'];
    foreach($cart as $key => $value){
        $key .":".  $value['quantity']. '<br>';
    }
// print_r($_SESSION['cart']);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="./home_with_user.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../homepage/homepage.css">
    <link rel="stylesheet" href="./home_with_user.css">
    <link rel="stylesheet" href="./shop_user.css">

    <title>Welcome to our Poultry System</title>
    
</head>


<body>

 <!-- sa taas na nakadepende sa session login.. -->
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
        <a class="navbar-brand fw-bold" href="../flower/1.html"><i class="fa-solid fa-dove"></i>Fowl Farm</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                <li class="nav-item mx-5">
                    <a class="nav-link active" aria-current="page" href="./home_with_user.php">Home</a>
                </li>
                <li class="nav-item mx-5">
                    <a class="nav-link active" aria-current="page" href="./home_shop_user.php">Shop</a>
                </li>
                <li class="nav-item mx-5">
                    <a class="nav-link active" aria-current="page" href="./about_.php">About</a>
                </li>
                <li class="nav-item mx-5">
                    <a class="nav-link active" aria-current="page" href="./faq.php">FAQ</a>
                </li>
                
                <li class="nav-item mx-5">
                    <a class="nav-link active" aria-current="page" href="./contact.php">Contact</a>
                </li>
                
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
                                    <button class="btn btn-primary btn-block" onclick="window.location.href='checkout.php'">Checkout</button>
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


<!-- wlang silbe design lng -->
<section id="one">
  <h4> Your Local Source for Fresh Poultry </h4>
  <h2> Delivered Straight from Our Farm to You</h2>
  <h1> "Farm-Fresh Poultry, Delivered with Care" </h1>
  <p> Looking for premium chicken, eggs, and more?.</p>
  <button onclick="window.location.href='home_shop_user.php'">Explore Our Shop</button>
</section>

<section id="partner-banner" class="section-p1">
  <h2>Our Trusted Partners</h2>
  <div class="partner-logos">
    <img src="path_to_logo_1.png" alt="Partner 1">
    <img src="path_to_logo_2.png" alt="Partner 2">
    <img src="path_to_logo_3.png" alt="Partner 3">
    <img src="path_to_logo_4.png" alt="Partner 4">
    <!-- Add more logos if needed -->
  </div>
</section>
<!--First product list -->
<section id="two" class="section-p1 fixed-section first">
      <h2>Our Poultry Products</h2>
      <div class="pro-container">
          <?php
           $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : 'all';
           $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
       
           // SQL query to retrieve products based on selected category and brand
           $select_query = "SELECT products.*, brands.brand_title
                           FROM products
                           LEFT JOIN brands ON products.brand_id = brands.brand_id
                           WHERE ('$selectedBrand' = 'all' OR products.brand_id = '$selectedBrand') AND
                                 ('$selectedCategory' = 'all' OR products.category_id = '$selectedCategory') 
                            ORDER BY product_id ASC LIMIT 0,8";
       
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
                               </div>
                               <a href='addtocart.php?id={$product_id}'><i class='fa-solid fa-cart-shopping cart'></i></a>
                               </div>";
               }
           } else {
               // Display a message when there are no products
               echo "<p>There are no products in the selected category or brand.</p>";
           }
       
          ?>
      </div>
  </section>
  <script>
      function openProductDetails(productId) {
          // Redirect to the product details page with the product_id
          window.location.href = `./home_with_user.php?product_id=${productId}`;
      }

      // Function to open the lightbox
      function openLightbox() {
          document.getElementById('product-lightbox').style.display = 'flex';
      }

      // Function to close the lightbox
      function closeLightbox() {
        document.getElementById('product-lightbox').style.display = 'none';
      }
      function goBack() {
        // Go back to the previous page in the browser history
        window.history.back();
    }


      // Check if the product_id is present in the URL and open the lightbox accordingly
      window.addEventListener('DOMContentLoaded', function () {
          const queryString = window.location.search;
          const urlParams = new URLSearchParams(queryString);
          const productId = urlParams.get('product_id');
          if (productId) {
              openLightbox();
          }
      });
  </script>
<div>
<?php
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
                    <a class='back' href='javascript:void(0);' onclick='goBack();'></a>

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
                    <form action='addtocart.php' method='get'>
                        <div class='right footer'>
                            <button class='right btn fa-solid fa-cart-shopping fa-lx' type='submit'>
                                <p>Add to Cart</p>
                            </button>
                        </div>
                        <!-- You can include hidden input fields to send additional data if needed -->
                        <input type='hidden' name='id' value='$product_id'>
                    </form>
                </div>
                
            </div>";

    }
}
?>
</div>

<section id="banner" class="section-p1">
  
  <h4>Fresh from our farm to your table! Explore premium <br>
    <b>Explore premium, hormone-free poultry, eggs, and more</b> <br>
     Healthy, delicious, and delivered straight to your door—because quality matters</h4>
  <a class="fancy" href="../Shop/shop.php">
    <span class="top-key"></span>
    <span class="text">Shop Now</span>
    <span class="bottom-key-1"></span>
    <span class="bottom-key-2"></span>
  </a>
</section>


<!-- Second product list -->
<section id="two" class="section-p1 fixed-section second">
<h2>Your Trusted Poultry supply hub</h2>
<p>All-in-one solutions for poultry farming needs</p>
      <div class="pro-container">
          <?php
           $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : 'all';
           $selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
       
           // SQL query to retrieve products based on selected category and brand
           $select_query = "SELECT products.*, brands.brand_title
                           FROM products
                           LEFT JOIN brands ON products.brand_id = brands.brand_id
                           WHERE ('$selectedBrand' = 'all' OR products.brand_id = '$selectedBrand') AND
                                 ('$selectedCategory' = 'all' OR products.category_id = '$selectedCategory') 
                            ORDER BY product_id DESC";
       
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
                               </div>
                               <a href='addtocart.php?id={$product_id}'><i class='fa-solid fa-cart-shopping cart'></i></a>
                               </div>";
               }
           } else {
               // Display a message when there are no products
               echo "<p>There are no products in the selected category or brand.</p>";
           }
       
          ?>
      </div>
  </section>
  


<!-- email news update -->
  <section id="newsletter" class="section-p1">
  <div class="newstext">
    <h4>Sign up For newsletter</h4>
    <P>Get E-mail updates about our latest shop and <span>special offer</span></P>
  </div>
  <div class="form">
    <input type=" text" placeholder="your E-mail adress">
    <button>
      <span class="box">
        Sign up
      </span>
  </button>
  </div>
 
</section>

<!-- footer -->
<footer id="footer" class="section-p1">
      <div class="col">
        <h4>Contact</h4>
        <p><strong>Adress:</strong> Monteverde corner Bruno Gempesaw Street, Quezon City, Metro Manila</p>
        <p><strong>Phone:</strong> +93 977 446 464 646  </p>
        <p><strong>Hours:</strong> 9:00 - 18:00, MON - Sat </p>
        <div class="Follow">
          <div class="icon"><strong>Follow us</strong></div>
          <i class="fab fa-facebook"></i>
          <i class="fab fa-twitter"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-pinterest-p"></i>
          <i class="fab fa-youtube"></i>
        </div>
      </div>
      
      <div class="col">
        <h4>About</h4>
        <a href="#">About us</a>
        <a href="#">Delivery Information</a>
        <a href="#">Privacy policy</a>
        <a href="#">Terms & condition</a>
        <a href="#">Contact us</a>
      </div>
      
      <div class="col">
        <h4>My account</h4>
        <a href="../login,signup/login_signup.php">Sign In</a>
        <a href="#">View cart</a>
        <a href="#">My Whistlist</a>
        <a href="#">Track My Order</a>
        <a href="#">Help</a>
      </div>
      
      <div class="col install">
        <h4>Install App</h4>	
        <p>Download from Appstore</p>
          <img src="../pictures/play.jpg"> 
         <p> Secured Payment Gateway</p>
         <img class="qw" src="../pictures/pay.png">  
      </div>
      
      <div class="copyright">
      <p> ©2024, Website Project(4h) - HTML CSS PHP JS Ecommerce</p>
      </div>
</footer>


</body>
</html>
