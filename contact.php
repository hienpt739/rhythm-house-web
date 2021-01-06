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
  $numCart = 0;
  if(!empty($_COOKIE)) {
    $productsId = array_filter($_COOKIE, function($key) {
      return $key !== 'PHPSESSID';
    }, ARRAY_FILTER_USE_KEY);
    
    $count = count($productsId);
    if($count <= 0) {
      $numCart = 0;
    } else {
      $numCart = $count;
    }
  } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,600;1,700&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/cdb9a8afaf.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css/styles.css">
<title>Contact</title>
<link rel="shortut icon" href="images/favicon.ico"/>
</head>
<body>
  <section class="contactus" >
      <div class="contentcontactus">
          <h2><a href="home.php"><img style="width: 32px" src="images/favicon-32x32.png" alt="icon"></a> Contact Us</h2>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda a, iure similique illo pariatur corrupti earum optio itaque deleniti consequatur.</p>
      </div>
      <div class="containercontact">
          <div class="contactInfo">
              <div class="box">
                  <div class="iconcontactus"><i class="fas fa-map-marker-alt"></i></div>
                  <div class="text">
                      <h3>Address</h3>
                      <p>285 Đoi Can,Ba Dinh, Ha Nọi, Viet Nam.
                      </p>
                  </div>
              </div>
              <div class="box">
                <div class="iconcontactus"><i class="fas fa-phone"></i></div>
                <div class="text">
                    <h3>Phone</h3>
                    <p> 0123-456-789</p>
                </div>
            </div>
            <div class="box">
                <div class="iconcontactus"><i class="fas fa-envelope"></i></div>
                <div class="text">
                    <h3>Email</h3>
                    <p>rhythmhouse@gmail.com
                    </p>
                </div>
            </div>
          </div>
          <div class="contactForm">
              <form action="">
                  <h2>Send Massage</h2>
                  <div class="inputBox">
                    <input type="text" name="" required="required">
                    <span>Full Name</span>
                  </div>
                  <div class="inputBox">
                    <input type="text" name="" required="required">
                    <span>Email</span>
                </div>
                <div class="inputBox">
                    <textarea required= "required"></textarea>
                    <span>Type your Massage...</span>
                </div>
                <div class="inputBox">
                    <input type="submit" value="SUBMIT MASSAGE">
                </div>
              </form>

      </div>
    </div>
  </section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>