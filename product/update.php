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
 
// BELUM TAU KEGUNAANYA
/*------- DISINI KESALAHANNYA -------*/ 
$data = json_decode(file_get_contents("http://localhost/restapi/magangapi/product/read.php"));

$product->id_guru     = $data->id_guru;
$product->firstname   = $data->firstname;
$product->lastname    = $data->lastname;
$product->username    = $data->username;
$product->password    = $data->password;
$product->nip         = $data->nip;
 
// update the product
if($product->update()){
 
    http_response_code(200);
    echo json_encode(array("message" => "Data berhasil di update"));
}
 
else{
 
    http_response_code(503);
    echo json_encode(array("message" => "Data tidak ada"));
}
?>