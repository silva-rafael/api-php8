<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$products = $product->read();

if (count($products) > 0) {
    http_response_code(200);
    echo json_encode($products);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Nenhum produto encontrado."]);
}