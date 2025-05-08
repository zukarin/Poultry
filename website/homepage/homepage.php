<?php
include('../db_connection.php');
include('../functions/common_function.php');

?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="homepage.css">
    <link rel="stylesheet" href="../Shop/shop.css">
    <link rel="icon" href="./website/pictures/android-chrome-512x512.png" type="image/x-icon">



   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>welcome to our poultry farm!</title>
  </head>

  <body>		

<section id="header">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand fw-bold" href="../flower/1.html">
  <i class="fa-solid fa-dove"></i> Fowlfarm
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav m-auto mb-2 mb-lg-0">
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../homepage/homepage.php">Home</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../Shop/shop.php">Shop</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../about/about.html">About</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="./faq/faq.html">FAQ</a>
    </li>
    <li class="nav-item mx-5">  <!-- Changed mx-5 to mx-3 -->
      <a class="nav-link active" aria-current="page" href="../contact/contact.html">Contact</a>
    </li>
    
    <li class="nav-item dropdown custom-account-dropdown nav-item mx-5"> <!-- Changed to mx-7 -->
  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Account
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    <li><a class="dropdown-item" href="../login,signup/login_signup.php" target="_self">Login/Signup</a></li>
  </ul>
</li>
  </ul>
</div>      
</nav>   
</section>
<section id="one">
  <div class="header-content">
    <h2>Your Local Source for Fresh Poultry <br> 
        <span class="highlight-text">Delivered Straight from Our Farm to You</span> <br>
        Farm-Fresh Poultry, Delivered with Care</h2> <br> <br> </div>
    <p>Looking for premium chicken, eggs, and more? <br> <br>
    <button onclick="window.location.href='../Shop/shop.php'">Explore Our Shop</button>
    
</section>



<!-- product na una -->
<section id="two" class="section-p1">
  <h2>Our Poultry Products</h2>
  <div class="pro-container">
          <?php
          getproducts();
          ?>
      </div>
</section>

<section id="banner" class="section-p1">
  
  <h4>Fresh from our farm to your table! Explore premium <br>
    <b>Explore premium, hormone-free poultry, eggs, and more</b> <br>
     Healthy, delicious, and delivered straight to your door—because quality matters</h4> <br>
  <a class="fancy" href="../Shop/shop.php">
    <span class="top-key"></span>
    <span class="text">Shop Now</span>
    <span class="bottom-key-1"></span>
    <span class="bottom-key-2"></span>
  </a>
</section>


<!-- product to sa pangalawa -->
<section id="two" class="section-p1">
  <h2>Your Trusted Poultry supply hub</h2>
  <p>All-in-one solutions for poultry farming needs</p>
  <div class="pro-container">
          <?php
          getproductsss();
          ?>
      </div>
</section>

<script>
    function addToCart(productTitle) {
        // Check if the user is logged in (you can replace this condition with your actual check)
        var isLoggedIn = false;

        if (!isLoggedIn) {
            alert('You must log in first to add products to your cart.');
            // You can redirect to the login page or perform any other action
        } else {
            // User is logged in, perform the desired action (e.g., add to cart)
            alert('Product added to cart: ' + productTitle);
            // Add logic to handle adding the product to the cart
            // You may want to use AJAX to send the product data to the server
        }
    }
</script>

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
        <a href="../about/about.html">About us</a>
        <a href="#">Delivery Information</a>
        <a href="#">Privacy policy</a>
        <a href="#">Terms & condition</a>
        <a href="../contact/contact.html">Contact us</a>
      </div>
      
      <div class="col">
        <h4>My account</h4>
        <a href="../login,signup/login_signup.php">Sign In</a>
        <a href="#">View cart</a>
        
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="../homepage/home.js" ></script>

 </body>
</html>