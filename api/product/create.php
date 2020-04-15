<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Autorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database  = new Database();
$db = $database->getConnection();
$product = new Product($db);

$data = json_decode(file_get_contents('php://input'));
// validating data not empty
  if(!empty($data->name) && !empty($data->price) && !empty($data->description)&&!empty($data->category_id))
  {

    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    if($product->create())
    {
      //return http code inserted
      http_response_code(201);

      echo json_encode(array("message" => "Product Was Created."));
    }
    else
    {
      // return failed to create product
      http_response_code(503);
      // returning error message
      echo json_encode(array("message" => "Product Failed To Be Created."));
    }

  }
  else
  {
    // return failed to create product
    http_response_code(400);
    // returning error message
    echo json_encode(array("message" => "Product Can Not Be Create, Data Incomplete"));
  }
 ?>
