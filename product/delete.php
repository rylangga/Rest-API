<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/product.php';
 
$database = new database();
$db = $database->getConnection();
 
$product = new product($db);
 
// ngambil produk id
$data = json_decode(file_get_contents("php://input"));
 
// ngambil produk id untuk di delete
$product->id = $data->id;
 
if($product->delete()){
 
    http_response_code(200);
    echo json_encode(array("message" => "Product was deleted."));
}
 
else{
 
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete product."));
}
?>