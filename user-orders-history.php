<?php 
  require_once('../database/config.php');
  require_once('../database/functions.php');
  session_start();
  $isSignin = $_SESSION['isSignin'];
  $userId = $_SESSION['userId'];
  $userName = $_SESSION['userName'];
  $hasOrder = false;

  $sql = "SELECT * FROM orders WHERE id_Users='$userId';";
  $result = dbSelect($sql);
  $orders = count($result);
  if($orders > 0) {
    $hasOrder = true;
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

<!doctype html>
<html lang="en">
  <head>
    <title>Orders History</title>
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
      <a class="navbar-brand" href="home.php"><img src="images/favicon-32x32.png" alt="icon"> RhythmHouse</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
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
        
        <a class="mr-3" href="cart.php" id="cartLink"><i class="fas fa-shopping-cart text-white"></i><span id="numProdOfCart"><?=$numCart?></span></a>

        <?php if(!$isSignin) : ?> 
        <a id='btn-signin' class="ml-3 btn btn-sm btn-outline-primary mr-10 " href="signin.php">sign in</a>
        <?php else : ?>
        <div class="dropdown d-inline-block mr-10" id="dropdown-signin">
          <i data-toggle="dropdown" class="fas fa-user dropdown-toggle text-white"></i> <span class="text-white"><?=$userName?></span>
          <div class="dropdown-menu" id="dropdown-menu-signin">
            <a class="dropdown-item" href="user-orders-history.php">Orders History</a>
            <a class="dropdown-item" href="home.php?logout=yes">Log out</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </nav>

    <!-- display orders history  -->
    <div class="container">
        <?php if (!$hasOrder) : ?> 
          <p class="mt-5 text-center">Sorry you don't have any order unti now. View <a href="store.php">store</a> to find an album to place an order.</p>
        <?php else : ?>  
          <div class="col-md-8 mx-auto mt-5">
            <p>User Name: <?=$userName?></p>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Order Id</th>
                  <th scope="col">Total Money</th>
                  <th scope="col">Ordered At</th>
                  <th scope="col">Status</th>
                  <th scope="col">##</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $autoIncrease = 0;
                  foreach($result as $order) {
                    $autoIncrease++;
                    $id = $order['id'];
                    $total = $order['total_money'];
                    $created_at = $order['created_at'];
                    $status = $order['status'];
                    if($status === '-1') {
                      $statusName = 'failed';
                    } else if ($status === '0') {
                      $statusName = 'pending';
                    } else if ($status === '1') {
                      $statusName = 'success'; 
                    } else {
                      $statusName = 'undefined';
                    }
                    echo "
                      <tr>
                        <th>$autoIncrease</th>
                        <td>$id</td>
                        <td>$$total</td>
                        <td>$created_at</td>
                        <td>$statusName</td>
                        <td><a href='user-order-details.php?idOrder=$id'>details</a></td>
                      </tr>
                    ";
                  }
                ?>
              </tbody>
            </table> 
          </div>  
          
        <?php endif; ?>  
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      // cookies for products
      window.onload = function() {
        let count = Number($('#numProdOfCart').text());
        if(count <= 0) {
          $('#numProdOfCart').hide();
        } else {
          $('#numProdOfCart').show().css({
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center'
          });
        }
      }
    </script>
  </body>
</html>