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
    <title>Home Page</title>
    <link rel="shortut icon" href="images/favicon.ico"/>
</head>

<body>

    <!--thanh navabr-->
    <nav class="navbar navbar-expand-lg fixed-top " id="trongsuot">
        <div class="container">
            <a class="navbar-brand" href="index.php">RhythmHouse</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon "><i class="fas fa-bars"></i></span>
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
                        <a class="dropdown-item" href="index.php?logout=yes">Log out</a>
                    </div>
                </div>
              <?php endif; ?>      
            </div>
    </nav>
    <!--hết thanh navbar-->
    <!--section 1, 2, 3-->
    <!--carousel-->
   
    <div id="carouselId" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1"></li>
            <li data-target="#carouselId" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <div class="container-fluid" id="section1">
                    <div id="section-subContainer" class="mx-auto d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <h1>NEW ALBUM OUT NOW</h1>
                            <p class="mx-auto w-7 lead d-none d-md-block">Listen to the full album, out now here and grab your tickets for tonight’s livestream event here.
                                I hope you all enjoy the new album and the music speaks to you in the way you need it to right now.</p>
                            <a class="btn btn-md-lg btn-info btn-lg" href="store.php">Music Store</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container-fluid" id="section3">
                    <div id="section-subContainer" class="mx-auto d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <h1>LIVE SHOW <br> OUT NOW</h1>
                            <p class="mx-auto w-7 lead d-none d-md-block">Lorem ipsum dolor sit amet consectetur
                                adipisicing elit.
                                Similique Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo sint quam
                                saepe
                                aliquid quia
                                possimus. Explicabo cumque eaque ipsam accusantium</p>
                            <a class="btn btn-md-lg btn-warning btn-lg" href="liveshow.php">Live Show</a>
                            <a class="btn btn-md-lg btn-info btn-lg" href="contact.php">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container-fluid" id="section2">
                    <div id="section-subContainer" class="mx-auto d-flex justify-content-center align-items-center">
                        <div class="text-left text--white ">
                            <h4>Debut Album Out Now</h4>
                            <h1>MUSICIAN OF <br> THE YEARS</h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- hết carousel-->

    <!--hết section 1, 2,3-->

    <!--section 4 - display Amazing Artists / Most Popular-->
    <div class="container mt-5">
        <h3>Madison Square Garden</h3>
        <h2>Amazing Artists / Most Popular<h2>
        <div class="row">
            
            <?php 
              $sql = "SELECT * FROM products WHERE id_categories = 3 LIMIT 0,6";
              // $sql = "SELECT * FROM products WHERE id IN()";
              $result = dbSelect($sql);
              foreach($result as $product) {
                $id = $product['id'];
                $name = $product['name'];
                $author = $product['author'];

                $imageLinkString = $product['thumnail_link'];
                $imageLinks = getArrLink($imageLinkString);
                $link = $imageLinks[0];

                echo "
                  <div class='col-12 col-sm-6 col-md-4 mt-3 mx-auto'>
                    <a href='product-detail.php?id=$id'><img class='img-fluid rounded' src='$link'></a>
                    <a style='text-decoration: none;' href='product-detail.php?id=$id'><h5 class='productTite'>$name</h5></a>
                    <h4>$author</h4>
                  </div> 
                ";
              }
            ?>  
        </div>
    </div>

    <!--hết section 4-->
    <!--section 5-->
    <div class="container mt-5 mb-5">
        <h3>Madison Square Garden</h3>
        <h2>Latest Albums / Singles</h2>
        <div class="row">
            <?php
              date_default_timezone_set("Asia/Ho_Chi_Minh");
              $date = date('Y-m-d H:i:s'); 
              $lastMonth = date("Y-m-d H:i:s",strtotime("-1 month"));
            
              $sql = "SELECT * FROM products WHERE updated_at >= '$lastMonth' AND updated_at <= '$date'";
              $result = dbSelect($sql);

              for($i = 0; $i < count($result); $i++) {
                $id = $result[$i]['id'];
                $name = $result[$i]['name'];
                $author = $result[$i]['author'];

                $imageLinkString = $result[$i]['thumnail_link'];
                $imageLinks = getArrLink($imageLinkString);
                $link = $imageLinks[0];
                echo "
                  <div class='col-12 col-sm-6 col-md-4 mt-3 mx-auto'>
                    <a href='product-detail.php?id=$id'><img class='img-fluid rounded' src='$link'></a>
                    <a style='text-decoration: none;' href='product-detail.php?id=$id'><h5 class='productTite'>$name</h5></a>
                    <h4>$author</h4>
                  </div> 
                ";
                if($i >= 5) {
                  break;
                } 
              }
            ?>  
        </div>
    </div>
    <!--hết section 5-->
    
    <!-- section 7: best seller albums-->
    <div class="container mt-3">
        <h2>Best Sellers</h2>
        <div class="row">
            <?php 
              $sql = "SELECT id_Products, SUM(number) as total FROM orders_detail GROUP BY id_Products ORDER BY total DESC";
              $result = dbSelect($sql);
              for($i = 0; $i < count($result); $i++) {
                $id = $result[$i]['id_Products'];
                $sql = "SELECT * FROM products WHERE id='$id';";

                $resultProd = dbSelectSingle($sql);

                $imageLinkString = $resultProd['thumnail_link'];
                $imageLinks = getArrLink($imageLinkString);
                $link = $imageLinks[0];

                $id = $resultProd['id'];
                $name = $resultProd['name'];
                $author = $resultProd['author'];
                $price = $resultProd['price'];

                echo "
                  <div class='col-12 col-sm-6 col-md-3 mt-3 mx-auto'>
                      <img class='img-fluid rounded' src='$link'>
                      <a class='productTite' href='product-detail.php?id=$id'>
                          $name</a>
                      <p>Bluey
                          <br>
                          $$price</p>
                      <button data-toggle='modal' data-target='#alertModal' onclick='addToCart(\"product\" + $id, $id, 10)' class='nut btn btn-outline-info'>Add to Cart</button>
                  </div>
                ";
                if($i == 5) {
                  break;
                }
              }
            ?>
            
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

    <!--hêt section 7-->
    <!--footer-->
    <div class="footer">
        <div class="container-fluid text-center mt-3">
            <div class="row">
                <div class="col-12">
                    <h2>Rhythm house</h2>
                    <p> +123456789</p>
                    <a href="mailto:rhythmhouse@gmail.com"> info: rhythmhouse@gmail.com</a><br>
                </div>
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <script>
      $(document).ready(function() {
        // substring for title
        const productTites = document.querySelectorAll('.productTite');
        for(let i = 0; i < productTites.length; i++) {
          if(productTites[i].innerHTML.length > 50) {
            productTites[i].innerHTML = productTites[i].innerHTML.substring(0, 50) + '...';
          }
        }
      });

      // cookies for products
      window.onload = function() {
        let count = Number($('#numProdOfCart').text());
        if(count <= 0) {
          $('#numProdOfCart').hide();
        } else {
          $('#numProdOfCart').show();
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