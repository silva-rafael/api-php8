<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$product->id = isset($_GET['id']) ? $_GET['id'] : die();

$product_arr = $product->readOne();

if ($product_arr) {
    http_response_code(200);
    echo json_encode($product_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Produto não encontrado."]);
}