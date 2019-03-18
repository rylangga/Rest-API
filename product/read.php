<?php
  // BELUM TAU KEGUNAANNYA 
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  include_once "../config/database.php";
  include_once "../objects/product.php";

  // MENGINISIASI DATABASE DAN PRODUK OBJEK
  $database = new database();
  $db       = $database->getConnection();
  // variabel $db diambil dari public function __construct yg ada pada file product.php
  $product  = new product($db);

  // UNTUK MEMBACA DATA DARI DATABASE
  $stmt = $product->read();
  $num  = $stmt->rowCount();
   
  if( $num > 0 ){
    $products_arr = array();
    $products_arr['Data'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      // extract row
      // this will make $row['name'] to
      // just $name only
      extract($row);

      $product_item = array(
          "ID        "  => $id_guru,
          "firstname "  => $firstname,
          "lastname  "  => $lastname,
          "username  "  => $username,
          "password  "  => $password,
          "nip       "  => $nip
      );

        array_push($products_arr["Data"], $product_item);
    }
    http_response_code(200);
    echo json_encode($products_arr);
 
  }else{
    http_response_code(404);
    echo json_encode(
        array("message" => "Produk tidak ada")
    );
}
?>