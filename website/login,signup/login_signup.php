<?php
// Include sql file(CRUD)
include('register.php');
include('login.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../login,signup/login_signup.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/bad50d652e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>login_signup</title>
</head>
<body>

<!-- sa taas ng website -->
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
      <a class="nav-link active" aria-current="page" href="../homepage/faq/faq.html">FAQ</a>
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


    <div class="container right-panel-active">

        <!-- Sign Up -->
        <div class="container__form container--signup">      
        <form class="form" id="form1"  method="post">
    <h2 class="form__title">Sign Up</h2>
    <input type="text" name="user" placeholder="User" class="input" required />
    <input type="email" name="email" placeholder="Email" class="input" required />
    <input type="password" name="password" id="password" placeholder="Password" class="input" required />
<input type="password" name="confirm_password" id="confirm_password" placeholder="confirm_Password" class="input" required />
    <button class="btn" type="submit" name="form1-submit">Sign Up</button>
        <a href="signup(allinfo).php" class="link">Fill up more necessary info</a>
        </form>
        </div>
    
        <!-- Sign In -->
          <div class="container__form container--signin">
      <form class="form" id="form2" method="post">
          <h2 class="form__title">Sign In</h2>
          <input type="email" name="email" placeholder="Email" class="input" />
          <input type="password" name="password" placeholder="Password" class="input" />
            
          <button class="btn" name="form2-submit">Sign In</button>
      </form>
  </div>

    
        <!-- Overlay -->
        <div class="container__overlay">
            <div class="overlay">
                <div class="overlay__panel overlay--left">
                    <button class="btn" id="signIn">Sign In</button>
                </div>
                <div class="overlay__panel overlay--right">
                    <button class="btn" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>  
<script src="../login,signup/login_signup.js"></script>
</body>
</html>
