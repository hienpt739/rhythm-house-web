<?php 
  require_once('../database/config.php');
  require_once('../database/functions.php');
  session_start();
  if(isset($_SESSION['isSignin']) && isset($_SESSION['userName'])) {
    $isSignin = $_SESSION['isSignin'];
    $userName = $_SESSION['userName'];
    if(!empty($_GET)) {
      if(!empty($_GET['logout'])) {
        session_unset();
        session_destroy();
        $isSignin = false;
      }
    }
  } else {
    $isSignin = false;
  }
  
  // display number of product in cart
  if(!empty($_COOKIE)) {
    $productsId = array_filter($_COOKIE, function($key) {
      return $key !== 'PHPSESSID';
    }, ARRAY_FILTER_USE_KEY);
    
    $numCart = 0;
    $count = count($productsId);
    if($count <= 0) {
      $numCart = 0;
    } else {
      $numCart = $count;
    }
  } 
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Castoro&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cdb9a8afaf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/styles.css">
    <title>Live Show</title>
    <link rel="shortut icon" href="images/favicon.ico"/>
</head>

<body>

    <!--thanh navabr-->
    <nav class="navbar navbar-expand-lg fixed-top " id="trongsuot">
        <div class="container">
            <a class="navbar-brand" href="home.php">RhythmHouse</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon "><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="home.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="store.php">MUSIC STORE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="liveshow.php">LIVE SHOWS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">CONTACT US</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">ABOUT US</a>
                    </li>
                </ul>

                <div class="thongbao">
                    <a class="mr-3" href="cart.php" style="text-decoration: none;"><i class="fas fa-shopping-cart text-primary"></i><span id="numProdOfCart"><?=$numCart?></span></a>
                </div>

                <?php if(!$isSignin) : ?> 

                <a class="ml-3 btn btn-sm btn-outline-info" href="signin.php">sign in</a>

                <?php else : ?>

                <div class="dropdown d-inline-block mr-3" id="dropdown-signin">
                    <i data-toggle="dropdown" class="fas fa-user dropdown-toggle text-primary"> <?=$userName?></i>
                    <div class="dropdown-menu" id="dropdown-menu-signin">
                        <a class="dropdown-item" href="user-orders-history.php">Orders History</a>
                        <a class="dropdown-item" href="home.php?logout=yes">Log out</a>
                    </div>
                </div>
              <?php endif; ?>      
            </div>
    </nav>
    <!--hết thanh navbar-->
    <!--section 1-->
    <div class="container-fluid" id="section1liveshow">
        <div id="section-subContainer" class="mx-auto d-flex justify-content-center align-items-center">
            <div class="text-center">
                <h1>LIVE SHOW <br> OUT NOW</h1>
                <p class="mx-auto w-7 lead d-none d-md-block">Live music shows will be held each month with the participation of many famous singers. Don't wait any longer, please contact us immediately to register</p>
                <a class="btn btn-md-lg btn-warning btn-lg" href="liveshow.php">Live Show</a>
                <a class="btn btn-md-lg btn-info btn-lg" href="contact.php">Contact Us</a>
            </div>
        </div>
    </div>
      
        <!--footer-->
        <div class="footer">
            <div class="container-fluid text-center mt-3">
                <div class="row">
                    <div class="col-12">
                        <h2>RhrHouse</h2>
                        <p> +123 45 6789</p>
                        <a href="mailto:duongvanhao117@gmail.com"> info:duongvanhao117@gmail.com</a><br>
                        <a href="mailto:loc.tk.578@aptechlearning.edu.vn">loc.tk.578@aptechlearning.edu.vn</a></div>
                    <div class="col-12">
                        <div class="iconfooter">
                            <li><a href=""><i class="fas fa-shopping-cart"></i></a></li>
                            <li><a href=""><i class="fas fa-search"></i></a></li>
                            <li><a href=""><i class="fab fa-facebook"></i></a></li>
                            <li><a href=""><i class="fab fa-instagram"></i></a></li>
                            <li> <a href=""><i class="fab fa-twitter"></i></a></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--hết footer-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
      <script>
        // cookies for products
      window.onload = function() {
        let count = Number($('#numProdOfCart').text());
        if(count <= 0) {
          $('#numProdOfCart').hide();
        } else {
          $('#numProdOfCart').show();
        }
      }
      </script>
</body>

</html>