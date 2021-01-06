<?php
require_once('../database/config.php');
require_once('../database/functions.php');
session_start();

date_default_timezone_set("Asia/Ho_Chi_Minh");

// insert order 
$total = substr($_SESSION['orderDetailInfo']['total'], 1);
$userId = $_SESSION['userId'];
$name = $_POST['recip-name'];
$phone= $_POST['recip-phone'];
$address= $_POST['recip-address'];
$payment= $_POST['payment-method'];
$created_at = date("Y-m-d H:i:s");


$sql = "INSERT INTO orders (id_Users, name, phone, address, payment, total_money, created_at) VALUES ('$userId', '$name', '$phone', '$address', '$payment', '$total', '$created_at');";

$idOrder = getLastInsertId($sql);

if($idOrder) {
  // insert orders_detail
  $productIds = preg_grep_keys("/^product/", $_SESSION['orderDetailInfo']);
  foreach($productIds as $key=>$id) {
    $idProduct = $id;
    $price = $_SESSION['orderDetailInfo']["price$key"];
    $number = $_SESSION['orderDetailInfo']["number$key"];
    $total = $price * $number;
    $sql = "INSERT INTO orders_detail (id_Orders, id_Products, price, number, total_money) VALUES('$idOrder', '$idProduct', '$price', '$number', '$total')";
    dbManipulation($sql);
    setcookie($key, "", time() - 3600, '/');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Thanks</title>
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
  <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div>
            <div class="text-center"><a href="home.php"><img src="images/favicon-32x32.png" alt="icon"></a></div>
            <h1 class="display-4 text-center">Rhythm House</h1>
            <p class="lead text-center">Thank for your order, you can view your order here: <a href="user-orders-history.php">Order <?=$idOrder?></a></p>
            </div>
      </div>
</body>
</html>