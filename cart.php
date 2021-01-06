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


  $productsId = array_filter($_COOKIE, function($key) {
    return $key !== 'PHPSESSID';
  }, ARRAY_FILTER_USE_KEY);

  // print_r($_POST);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cart</title>
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

      /* hide all referProd of "people also view by default*/
      .referProd {
        display: none;
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

  <!-- products -->
  <div class="container my-5">
    <p class="text-center">MY SHOPPING CART</p>
      <?php if(!empty($productsId)):?>   
      <form id="form-cart" action="checkout.php" method="post" class="mx-auto"> 
      <?php 
        
        foreach($productsId as $key=>$id) {
          $sql = "SELECT * FROM products WHERE id='$id';";
          $result = dbSelect($sql);
          foreach($result as $product) {
            $imageLinkString = $product['thumnail_link'];
            $imageLinks = getArrLink($imageLinkString);
            $link = $imageLinks[0];
            $name = $product['name'];
            $author = $product['author'];
            $price = $product['price'];
            echo "
              <div class='border mt-3 container-product p-2 rounded shadow' style='display: flex'>
                <div><img src='$link' style='max-width: 100px; height: auto;' alt=''></div>
                <div class='pl-2'>
                  <div class='font-weight-bold'>$name</div>
                  <div><span class='font-italic'>By</span>: <span class='font-weight-bold'>$author</span></div>
                  <div>
                    <span class='price font-italic'>Price(unit)</span>: <span class='font-weight-bold'>$</span><input  min='0' name='price$key' class='input inputPrice font-weight-bold' readonly type='number' step='0.01' value='$price'>
                  </div>
                  <div>
                    <span class='font-italic'>quantity</span>: <span class='font-weight-bold'>x</span><input min='1' name='number$key' class='input inputNumber font-weight-bold' readonly type='number' value='1'>
                    <button class='btn btn-sm btn-info btn-increase'><i class='fas fa-arrow-up'></i></button>
                    <button class='btn btn-sm btn-info btn-decrease'><i class='fas fa-arrow-down'></i></button>
                  </div>
                  <div class='d-none'>
                    <input min='0' readonly step='0.01' type='number' name='$key' value='$id'>
                  </div>
                </div>
                <div class='ml-auto'><button class='btn btn-sm btn-danger ml-1 removeItem' data-cookie='$key'>&times;</button></div>
              </div>
            ";
          }
        }
      ?>
        <p class="mt-3"><i class="fas fa-check-circle text-success"></i> In stock</p>
        <p><i class="fas fa-shipping-fast text-success"></i> Free Ship</p>
        <h1 class="mt-3"><input name="total" class="input" readonly id="totalCheckOut"></h1>
        <button class="btn btn-lg btn-warning mt-2" type="submit">Check out</button>
      </form>
      
      <?php else:?>
      <p class="text-center">you don't have any product yet!<p>
      <?php endif;?>
  </div>
        
  <!-- modal require signin -->
  <!-- Modal -->
  <div class="modal fade" id="requireSignin" tabindex="-1">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="title">Sign in required</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Please sign in to place an order <a href="signin.php">sign in now</a>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <a href="signin.php" class="btn btn-primary">Sign in</a>
        </div>
      </div>
    </div>
  </div>

  <!-- References/ People also view -->

  <?php if(!empty($productsId)):?> 
  <div class="container-fluid d-none d-md-block">
    <p class="font-weight-bold">People also view: </p>
    <p class="text-center" id="countPage"></p>
    <div class="row justify-content-center align-items-center">
      <div class="col-1"><button class="btn btn-light" onclick="displayPage(-1)"><i class="fas fa-chevron-left"></i></button></div>
      <!-- main -->
      <div class="col-10">
        <div class="row">
          <?php
            $cateArr = []; 
            foreach($productsId as $key=>$value) {
              $sql = "SELECT id_categories from products WHERE id='$value';";
              $result = dbSelectSingle($sql);
              $cateId = $result['id_categories'];
              array_push($cateArr, $cateId);  
            }
            
            foreach(array_unique($cateArr) as $key=>$val) {
              $sql = "SELECT * from products WHERE id_categories='$val';";
              $result = dbSelect($sql);
              foreach($result as $value) {
                $id = $value['id'];
                $title = $value['name'];
                $imageLinkString = $value['thumnail_link'];
                $imageLinks = getArrLink($imageLinkString);
                $link = $imageLinks[0];
                echo "<div class='col-4 referProd'>
                <a href='product-detail.php?id=$id'><img class='img-fluid rounded' src='$link'></a>
                <a href='product-detail.php?id=$id'><p>$title</p></a>
                </div>";
              } 
            }
            
          ?> 
        </div>
      </div>
      <div class="col-1"><button class="btn btn-light" onclick="displayPage(1)"><i class="fas fa-chevron-right"></i></button></div>
    </div>
  </div>
  <?php else:?>
  <?php endif;?>

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

    function removeCookie(cookieName){
      document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
      console.log(document.cookie);
    }

    function fixFloatNumber(number) {
      if(number < 10) {
        return number.toPrecision(3);
      }
      if(number < 100) {
        return number.toPrecision(4);
      }
      if(number < 1000) {
        return number.toPrecision(5);
      }
      if(number < 10000) {
        return number.toPrecision(6);
      }
      if(number < 100000) {
        return number.toPrecision(7);
      }
      if(number < 1000000) {
        return number.toPrecision(8);
      }
    }

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

    $(document).ready(function() {
      // total checkout
      function countMoney() {
        let totalCheckOut = 0;  
        $.each($('.container-product'), function() {
          const price = Number($(this).find('.inputPrice').val());
          const number = Number($(this).find('.inputNumber').val());
          const total = price * number;
          totalCheckOut += total;
        });
        $('#totalCheckOut').val('$'+fixFloatNumber(totalCheckOut));
      }
      countMoney();

      // btn increase
      const btnIncrease = document.querySelectorAll('.btn-increase');
      for(i = 0; i < btnIncrease.length; i++) {
        btnIncrease[i].addEventListener('click', function(e) {
          e.preventDefault();
          // let inputNumberVal = Number(e.target.parentElement.children[0].value);
          let inputNumberVal = Number($(this).siblings('input').val());
          inputNumberVal++;
          $(this).siblings('input').val(inputNumberVal);
          countMoney();
        });
      }
      // btn decrease
      const btnDecrease = document.querySelectorAll('.btn-decrease');
      for(i = 0; i < btnDecrease.length; i++) {
        btnDecrease[i].addEventListener('click', function(e) {
          e.preventDefault();
          let inputNumberVal = Number($(this).siblings('input').val());
          if(inputNumberVal === 1) {
            inputNumberVal === 1;
          } else {
            inputNumberVal--;
          }
          $(this).siblings('input').val(inputNumberVal);
          countMoney();
        });
      }

      // remove item
      $('.removeItem').click(function(e) {
        e.preventDefault();
        const cf = confirm('are you sure to delete this product?');
        if(cf) {
          removeCookie($(this).data('cookie'));

          let count = Number($('#numProdOfCart').text());
          count--;
          $('#numProdOfCart').text(count);
          if(count <= 0) {
            $('#numProdOfCart').hide();
          } else {
            $('#numProdOfCart').show().css({
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center'
            });
          }

          $(this).parents('.container-product').remove(); 
          countMoney();
          if($('.container-product').length === 0) {
            $('button[type=submit]').remove();
            $('form').html("<p>you don't have any product yet!</p>").addClass('text-center');
          } 
        }
      });
      
    });

    // pagination of people also view
    let page = 0;
    const iniPage = 1;
    const totalProd = $('.referProd').length;
    const prodPerPage = 3;
    const totalPage = Math.ceil(totalProd / prodPerPage);

    const displayPage = (currentPage) => {
      page += currentPage;
      if (page < 1) {
        page = totalPage;
      }
      if (page > totalPage) {
        page = 1;
      }
      let offset = (page - 1) * prodPerPage;
      let limit = page * prodPerPage;

      // console.log(page, offset, limit);

      // for (let i = 0; i < imgs.length; i++) {
      //   imgs[i].style.display = "none";
      // }

      // for (offset; offset < limit && offset < totalImg; offset++) {
      //   imgs[offset].style.display = "block";
      // }
      $(".referProd").hide();

      $.each($(".referProd"), function (index) {
        if (index >= offset && index < limit && index < totalProd) {
          $(this).fadeIn();
        }
      });

      let textCount = "page " + page + " of " + totalPage;
      const countPage = document.getElementById("countPage");
      countPage.innerHTML = textCount;
    };
    displayPage(iniPage);
    
    // check isSignin
    $('form').submit(function() {
      if($('#btn-signin').length) {
        $('#requireSignin').modal('show');
        return false;
      } else {
        return true;
      }
    
    });


    
      
  </script>

  
</body>
</html>