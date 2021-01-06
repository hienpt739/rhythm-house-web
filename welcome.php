<?php 
  require_once('../database/config.php');
  require_once('../database/functions.php');
  $email = $password = $name = $errMess = '';
  if(!empty($_GET)) {
    $name = $_GET['name'];
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Sign in</title>
    <link rel="shortut icon" href="images/favicon.ico"/>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="css/styles-bs.css">
  </head>
  <body>
     <!-- main -->
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
      <div>
        <div class="text-center"><a href="index.php"><img src="images/favicon-32x32.png" alt="icon"></a></div>
        <p class="text-center lead">Welcome <?=$name?>, Your account has been successfully registered. Please sign in</p>
        <div class="text-center"><a href="signin.php">sign in</a></div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>