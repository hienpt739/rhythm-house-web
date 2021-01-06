<?php
require_once('../database/config.php');
require_once('../database/functions.php');
if(!empty($_POST)) {
  $searchText = $_POST['searchText'];
  $sql = "SELECT * FROM products WHERE id_categories LIKE '%$searchText%' OR name LIKE '%$searchText%' OR author LIKE '%$searchText%' OR performance LIKE '%$searchText%' OR music_type LIKE '%$searchText%' OR release_year LIKE '%$searchText%';";
  $result = dbSelect($sql);
  // var_dump($result);
  if(count($result) > 0) {
    $dataBack = '';
    for($i = 0; $i < count($result) ;  $i++) {
      $id = $result[$i]['id'];
      $productName = $result[$i]['name'];
      $author = $result[$i]['author'];
      $dataBack .= "<li class='list-group-item'><a class='font-weight-bold' href='product-detail.php?id=$id'>$productName <span class='font-italic font-weight-light text-dark'>by: $author</span></li>";
      if($i >=5) {
        break;
      }
    }
    $dataBack .= "<li class='list-group-item'><a href='store-search.php?searchText=$searchText'>View full result</li>";

    echo $dataBack;

  }
}


