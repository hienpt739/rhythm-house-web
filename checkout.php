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
  
  // form check out
  $userId = $_SESSION['userId'];  
  $userName = $_SESSION['userName'];
  $productIds = preg_grep_keys("/^product/", $_POST);

  // save post request for set-order page
  $_SESSION['orderDetailInfo'] = $_POST;

?>

<!doctype html>
<html lang="en">
  <head>
    <title>Check out</title>
    <link rel="shortut icon" href="images/favicon.ico"/>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="css/styles-bs.css">

    <!-- font awesome -->
    <script src="https://kit.fontawesome.com/6b29bebedc.js" crossorigin="anonymous"></script>
    <style>
      body {
        display: flex;
        min-height: 100vh;
        flex-flow: column;
      }

      footer {
        margin-top: auto;
      } 
    </style>
  </head>
  <body>
  <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php"><img src="images/favicon-32x32.png" alt="icon"> RhythmHouse</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">HOME</a>
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
        
        <a class="mr-3" href="cart.php" id="cartLink"><i class="fas fa-shopping-cart text-white"></i><span id="numProdOfCart"><?=$numCart?></span></a>

        <?php if(!$isSignin) : ?> 
        <a id='btn-signin' class="ml-3 btn btn-sm btn-outline-primary mr-10 " href="signin.php">sign in</a>
        <?php else : ?>
        <div class="dropdown d-inline-block mr-10" id="dropdown-signin">
          <i data-toggle="dropdown" class="fas fa-user dropdown-toggle text-white"></i> <span class="text-white"><?=$userName?></span>
          <div class="dropdown-menu" id="dropdown-menu-signin">
            <a class="dropdown-item" href="user-orders-history.php">Orders History</a>
            <a class="dropdown-item" href="index.php?logout=yes">Log out</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </nav>

    <!-- main -->
    <div class="container-fluid">
      <p class="text-center mt-5">PLEASE CHECK AND FILL IN THE FORM BELOW</p>
      
      <form action="set-order.php" method="post" class="col-md-9 col-lg-6 border mx-auto my-3 rounded py-3 shadow-lg">
        <!-- user  -->
        <div class="form-row custom-border-bottom">
          <p class="font-weight-bold col-12">User informations:</p>
          <div class="col-12"><p>Name: <?=$userName?></p></div>
        </div>
        
        <!-- recipient -->
        <div class="form-row custom-border-bottom mt-5">
          <p class="font-weight-bold col-12">Recipient infomations:</p> 
          <div class="col-md-6 mt-3">
            <input name="recip-name" id="recip-name" type="text" class="form-control" placeholder="Name">
          </div>
          <div class="col-md-6 mt-3">
            <input name="recip-phone" id="recip-phone" type="text" class="form-control" placeholder="Phone">
          </div>
          <div class="col-12 mt-3">
            <textarea name="recip-address" id="recip-address" class="form-control" placeholder="Address"></textarea>
          </div>
          <div class="form-check my-3 pl-5">
            <input class="form-check-input" type="radio" name="payment-method" id="payment-method" value="COD" checked>
            <label class="form-check-label" for="payment-method">
              Cash on Delivery 
            </label>
          </div>
        </div>
      
        <!-- orders detail -->
        <div class="form-row custom-border-bottom mt-5 pb-3">
          <p class="font-weight-bold col-12">Orders detail: 
          <?php 
            foreach($productIds as $productId) {
              $sql = "SELECT * FROM products WHERE id='$productId';";
              $result = dbSelectSingle($sql);
              $prdName = $result['name'];
              $prdPrice = $result['price'];
              $number = $_POST["numberproduct$productId"];
              // image link
              $imageLinkString = $result['thumnail_link'];
              $imageLinks = getArrLink($imageLinkString);
              $link = $imageLinks[0];
              echo "
                <div class='col-12 border p-2 productDetail'>
                  <div><img class='img-fluid rounded' style='max-width: 100px' src='$link'></div>
                  <div>$prdName</div>
                  <div>$$prdPrice x $number</div>
                </div>
              ";
            }
          ?>
        </div>
        <!-- total cost -->
        <div class="form-row mt-5">
          <p class="font-weight-bold col-12">Total Cost:</p>
          <div class="col-12"><h1><?=$_POST['total']?></h1></div>
        </div>
        <button class="btn btn-lg btn-warning mt-3" type="submit">Proceed</button>
      </form>
    </div>        

    <!-- Modal alert if not enough info -->
    <div class="modal fade" id="needMoreInfo" tabindex="-1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="needMoreInfoTitle">Not enough informations</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Please fill in all fields in the recipient information
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <footer class="border p-3 bg-dark text-center text-white">
      <h3>RHYTHEM HOUSE</h3>
      <p> +123456789</p>
      <a class="text-white" href="mailto:rhythmhouse@gmail.com">info: rhythmhouse@gmail.com</a>
      <ul class="nav justify-content-center">
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fas fa-search text-white"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fab fa-facebook text-white"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fab fa-instagram text-white"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fab fa-twitter text-white"></i></a>
        </li>
      </ul>
    </footer>      

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        $('form').submit(function(){
          if($('#recip-name').val() == '' || $('#recip-phone').val() == '' || $('#recip-address').val() == '') {
            $('#needMoreInfo').modal('show');
            return false;
          }
        });
      });
    </script>
  </body>
</html>