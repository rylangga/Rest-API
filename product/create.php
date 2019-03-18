<?php
// BELUM TAU KEGUNAANYA
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// MANGGIL DATABASE
include_once '../config/database.php';
 
// MANGGIL PRODUCT
include_once '../objects/product.php';
 
$database = new database();
$db       = $database->getConnection();
 
$product = new product($db);
 
// json_decode berfungsi untuk mengubah json menjadi array pada php
// belum ngerti kegunaan file_get_contents

/*------- KESALAHAN ADA DISINI -------*/
$data = json_decode(file_get_contents("php://input"));
var_dump($data);

 
if(
    /*------- KESALAHAN ADA DISINI -------*/
    !empty($data->firstname) &&
    !empty($data->lastname)  &&
    !empty($data->username)  &&
    !empty($data->password)  &&
    !empty($data->nip) 
){
    $product->firstname = $data->firstname;
    $product->lastname  = $data->lastname;
    $product->username  = $data->username;
    $product->password  = $data->password;
    $product->nip       = $data->nip;
 
    // create() berguna untuk membuat data baru yg telah dideklarasikan pada 
    if($data1->create()){
 
        http_response_code(201);
 
        echo json_encode(array("message" => "Data telah dibuat"));
    }
    else{
 
        http_response_code(503);
 
        echo json_encode(array("message" => "Tidak bisa membuat data"));
    }
}
else{
    http_response_code(400);
 
    echo json_encode(array("message" => "Tolong lengkapi jika membuat data"));
}
?>