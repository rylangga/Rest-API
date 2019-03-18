<?php
// BELUM TAU KEGUNAANNYA
// show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// url
$home_url="http://localhost/api/";
 
// operator tenary
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// belum tau kegunaanya
$records_per_page = 5;
 
// belum tau kegunaanya 
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>