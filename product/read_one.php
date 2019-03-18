<?php
// BELUM TAU KEGUNAANYA
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// MANGGIL DATABASE
include_once '../config/database.php';
include_once '../objects/product.php';
 
// MANGGIL DATABASE
$database = new database();
$db       = $database->getConnection();
 
$product = new product($db);
// UNTUK MANGGIL DATA MENGGUNAKAN ID
// CONTOH OPERATOR TENARY
$product->id_guru = isset($_GET['id_guru']) ? $_GET['id_guru'] : false;

$product->readOne();
 
if($product->id_guru != null){
    // MEMBUAT ARRAY
    $product_arr = array(
        "id_guru"   => $product->id_guru,
        "firstname" => $product->firstname,
        "lastname"  => $product->lastname,
        "username"  => $product->username,
        "password"  => $product->password,
        "nip"       => $product->nip
    );
    
    http_response_code(200);
    echo json_encode($product_arr);
}
else{
    
    http_response_code(404);
    echo json_encode(array("message" => "Data tidak ditemukan"));
}
?>