<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->description) && !empty($data->price)) {
    $product->name = $data->name;
    $product->description = $data->description;
    $product->price = $data->price;

    if ($product->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Produto criado com sucesso."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Não foi possível criar o produto."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Dados incompletos."]);
}