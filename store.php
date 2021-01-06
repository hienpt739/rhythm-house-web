<?php 
  require_once('../database/config.php');
  require_once('../database/functions.php');
  session_start();
  if(isset($_SESSION['isSignin'])) {
    $isSignin = $_SESSION['isSignin'];
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
  // search if click search in small screen
  if(isset($_GET['search']) && !empty($_GET['search'])) {
    $searchText = $_GET['search'];
    header("Location: store-search.php?searchText=$searchText");
  }

  // cookies
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
    <title>Music Stores</title>
    <link rel="shortut icon" href="images/favicon.ico"/>
</head>

<body>
    <!--thanh navabr-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark " id="trongsuot">
        <div class="container">
            <a class="navbar-brand" href="home.php">RhythmHouse</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">HOME</a>
                    </li>
                    <li class="nav-item active">
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
                  <a class="mr-3" href="cart.php" id="cartLink"><i class="fas fa-shopping-cart text-primary"></i><span id="numProdOfCart"><?=$numCart?></span></a>
                </div>
                <?php if(!$isSignin) : ?> 
                  <a class="ml-3 btn btn-sm btn-outline-primary mr-10" href="signin.php">sign in</a>
                <?php else : ?>
                  <div class="dropdown d-inline-block mr-10" id="dropdown-signin">
                    <i data-toggle="dropdown" class="fas fa-user dropdown-toggle text-primary"></i>
                    <div class="dropdown-menu" id="dropdown-menu-signin">
                      <a class="dropdown-item" href="#">Orders History</a>
                      <a class="dropdown-item" href="home.php?logout=yes">Log out</a>
                    </div>
                  </div>
                <?php endif; ?>
            </div>
    </nav>
    <!--hết thanh navbar-->
    <!--thanh search-->
    <!-- <div class="container mt-3" id="search">
        <div class="row">
            <div class="col-12">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                </form>
            </div>
        </div>
    </div> -->

    <!-- section 1: search area -->
    <div class="container-fluid mt-5">
      <div class="col-md-6 mx-auto position-relative">
        <form id='formSearch' method="get">
          <input class="form-control" type="text" name="search" id="searchInput" placeholder="search for your albums...">
          <button class="btn btn-primary d-inline d-lg-none mt-2 btn-sm" type="submit">Search</button>
        </form>
        <!-- result -->
        <ul id="searchResult" class="list-group mt-2 d-none d-lg-block" style="position: absolute; z-index: 99999; width: 80%;">    
        </ul>
      </div>
    </div>
    <!--hết thanh search-->

    <!-- display grid album -->
    <div class="container mt-5">
        <div class="row">
            <!-- col-sm: 3 - 9 -->
            <!-- dropdown -->
            <div class="col-sm-3">
                <div class="dropdown mb-3">
                    <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CATEGORIES
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class='dropdown-item' href='store.php'>All</a>
                        <?php
                          // get and display categories
                          $sql = "SELECT id, name FROM categories WHERE isDeleted=0";
                          $result = dbSelect($sql);
                          foreach($result as $category) {
                            $id = $category['id'];
                            $name = $category['name'];
                            echo "
                              <a class='dropdown-item' href='store-category.php?idCate=$id'>$name</a>
                            ";
                          }
                        ?>
                    </div>
                </div>    
            </div>
            
            <!-- grid album -->
            <div class="col-sm-9 row">
              <?php 
              // pagination + display table
                if(isset($_GET['page'])) {
                  $page = $_GET['page'];
                } else {
                  $page = 1;
                }
                $recordPerPage = 9;         
                $offset = ($page-1) * $recordPerPage;
                $sql = "SELECT id FROM products WHERE isDeleted=0";
                $result = dbSelect($sql);
                $totalRecord = count($result);
                $totalPage = ceil($totalRecord / $recordPerPage);
                $sql = "SELECT * FROM products ORDER BY updated_at DESC LIMIT $offset, $recordPerPage;";
                $result = dbSelect($sql);
                $numericOrder = ($page-1) * $recordPerPage;
                foreach($result as $row) {
                  $id = $row['id'];
                  $name = $row['name'];
                  $price = $row['price'];
                  $author = $row['author'];

                  $imageLinkString = $row['thumnail_link'];
                  $imageLinks = getArrLink($imageLinkString);
                  $link = $imageLinks[0];

                  echo "
                    <div class='col-12 col-sm-6 col-md-4 mt-3'>
                        <a href='product-detail.php?id=$id'><img src='$link' alt='' class='layer1'></a>
                        <div class='layer2'>
                            <a href='product-detail.php?id=$id' class='productTite'>$name</a>
                            <p>$author<br>
                                $price</p>
                            <button data-toggle='modal' data-target='#alertModal' onclick='addToCart(\"product\" + $id, $id, 10)' class='nut btn btn-outline-info'>Add to Cart</button>
                        </div>
                    </div>
                  ";
                }
              ?>
            </div>
        </div>
    </div>

    <!--phân trang-->
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3 mt-3 mx-auto"></div>
            <div class="col-12 col-sm-6 col-md-3 mt-3 mx-auto"></div>
            <div class="col-12 col-sm-6 col-md-3 mt-3 mx-auto">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php if($page <= 1) : ?>
                        <?php else :?>  
                        <li class="page-item">
                          <a class="page-link" href="store.php?page=<?=$page - 1?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <?php endif;?>  
                        <?php 
                          for($i = 1; $i <= $totalPage; $i++) {
                            if($i == $page) {
                              $active = ' active';
                            } else {
                              $active = '';
                            }
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="store.php?page='.$i.'">'.$i.'</a></li>';
                          }
                        ?>     
                        
                        <?php if($page >= $totalPage) : ?>
                        <?php else :?> 
                        <li class="page-item">
                          <a class="page-link" href="store.php?page=<?=$page + 1?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                        <?php endif;?> 
                    </ul>
                </nav>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mt-3 mx-auto"></div>
        </div>
    </div>
    <!--hết phân trang-->
           
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        $('#searchInput').keyup(function() {
          if($(this).val() == '') {
            $('#searchResult').empty();
          } else {
            $.post(
              'searchData.php',
              {searchText: $(this).val()},
              function(data) {
                $('#searchResult').empty().append(data);
              }
            );
          }
        });
        // if(window.innerWidth < 992) {
        //   $('#searchInput').off('keyup');
        // }
        // search submit
        
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