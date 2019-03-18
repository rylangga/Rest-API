<?php
  // BELUM TAU KEGUNAANNYA
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  global $id_guru;

  
  include_once '../config/core.php';
  include_once '../config/database.php';
  include_once '../objects/product.php';
  
  $database = new database();
  $db = $database->getConnection();
  $product = new product($db);
  
  // user MERUPAKAN KUNCI DARI URL ITU SENDIRI
  // CARA PENULISAN ?user=
    $keywords = isset($_GET["user"]) ? $_GET["user"] : "";
  
  // MENCARI KEY DARI URL
  $stmt = $product->search($keywords, $id_guru);
  $num = $stmt->rowCount();
  
  if($num>0){
  
      $products_arr = array();
      $products_arr["records"] = array();
  
      // UNTUK MENGAMBIL ISI TABEL
      // NOTE: PENGGUNAAN FETCH() LEBIH EFESIEN DARI FETCHALL()
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
  
          $product_item = array(
              "id"        => $id_guru,
              "firstname" => $firstname,
              "lastname"  => $lastname,
              "username"  => $username,
              "password"  => $password,
              "nip"       => $nip
          );
  
          array_push($products_arr["records"], $product_item);
      }
  
      http_response_code(200);
      echo json_encode($products_arr);
  }
  
  else{
      http_response_code(404);
      echo json_encode(
          array("message" => "Data tidak ditemukan")
      );
  }
?>