<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: Application/json; charset=UTF-8");


include_once '../config/database.php';
include_once '../objects/product.php';

//get database connection
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$statement = $product->read();
$num = $statement->rowCount();

// for checking record
if($num > 0)
{
  $product_array = array();
  $product_array["records"]  = array();

  while($row = $statement->fetch(PDO::FETCH_ASSOC))
  {
    extract ($row);

    $product_item = array(
      "id" => $id,
      "name" => $name,
      // to decode html entity
      "description" => html_entity_decode($description),
      "category_id" => $category_id,
      "category_name" => $category_name
    );

    //push the array
    array_push($product_array['records'], $product_item);
  }
  //returning http response code success
  http_response_code(200);

  //encoding to json code to be read as json
  echo json_encode($product_array);
}
else
{
    //If no product found
    http_response_code(404);
    //encoding to json no product will be readline_redisplay
      array("message" => "No Product Found.");
}
 ?>
