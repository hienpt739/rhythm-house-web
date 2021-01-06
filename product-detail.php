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
  
  // get id
  if(!empty($_GET['id'])) {
    $id = $_GET['id'];
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Store</title>
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

    <!-- product detail -->
    <div class="container my-5">
      <p>PRODUCT DETAIL:</p>
      <div class="row">
        <div class="col-md-9">
          <div class="row">
            <!-- view image -->
            <div class="col-md-5">
              <div id='img-product-detail' class='text-center mx-auto'>
                <?php 
                  $sql = "SELECT * FROM products WHERE id='$id';";
                  $result = dbSelectSingle($sql);
                  $imageLinkString = $result['thumnail_link'];
                  $imageLinks = getArrLink($imageLinkString);
                  $title = $result['name'];
                  $author = $result['author'];
                  $performance = $result['performance'];
                  $music_type = $result['music_type'];
                  $release_year = $result['release_year'];
                  $price = $result['price'];
                  $desciption = $result['desciption'];

                  $idIncrease = 0;

                  foreach($imageLinks as $link) {
                    $idIncrease++;
                    echo "<img id='image$idIncrease' class='img-fluid rounded img-product' src='$link'>";
                  }
                ?>
              </div>
              <div class="text-muted text-center">View photos by clicking on the image thumbnail</div>
              <div id='thumbnail'>
                <?php
                $idThumbnail = 0;  
                foreach($imageLinks as $link) {
                  $idThumbnail++;
                  echo "<img data-thumbnail='image$idThumbnail' class='mt-2 ml-2 img-fluid rounded thumbnail' src='$link'>";
                }
                ?>
              </div>
            </div>
            <!-- view detail -->
            <div class="col-md-7 mt-3 mt-md-0">
                <div>
                  <p class='font-weight-bold'><?=$title?></p>
                  <p class='font-italic'>By: <?=$author?></p>
                  <p class='font-italic'>Performance: <?=$performance?></p>
                  <p class='font-italic'>Music type: <?=$music_type?></p>
                  <p class='font-italic'>Release year: <?=$release_year?></p>
                  <p class='font-italic'>Price: <span class='text-danger font-weight-bold'>$<?=$price?></span></p>
                  <p class='font-italic'>Desciption: <?=$desciption?></p>
                </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div>
            <p><i class="fas fa-check-circle text-success"></i> In stock</p>
            <p><i class="fas fa-shipping-fast text-success"></i> Free Ship</p>
            <p><i class="fas fa-heart text-success"></i> Money back: 10 days</p>
            <p><i class="fas fa-user-shield text-success"></i> Quality assurance: 1 year</p>
            <p>Total cost: <h5 class='text-danger'>$<?=$price?></h5></p>
            <p><button data-toggle='modal' data-target='#alertModal' onclick="addToCart('product' + <?=$id?>, <?=$id?>, 10)" class="btn btn-lg btn-warning">Add to cart</button></p>
          </div>
        </div>
      </div>
    </div>

    <!--Sucess Add to cart Modal -->
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add to cart</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            This product has been successfully added to <a href="cart.php">your cart</a>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function() {
        // thumbnail image click
        $('.thumbnail').click(function() {
          const dataId = $(this).data('thumbnail');
          $('.img-product').hide();
          $('#'+ dataId).show();
        });
        
      });
      

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
    
      function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
        
      function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }  

      function addToCart(cname, cvalue, exdays) {
        if(getCookie(cname) == '') {
          setCookie(cname, cvalue, exdays);
          let countProd = Number($('#numProdOfCart').text());
          countProd++;
          $('#numProdOfCart').show().css({
            display: 'flex',
            justifyContent: 'center',
            alignItems: 'center'
          });;
          $('#numProdOfCart').text(countProd);
        } else {
          setCookie(cname, cvalue, exdays);
        } 
      }
      console.log(document.cookie);
    </script>
  </body>
</html>