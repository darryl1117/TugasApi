<?php
  class Product{

    //get database connection and table name
    private $conn;
    private $table_name = "products";

    //object properties
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    //calling db construction
    public function __construct($db)
    {
      $this->conn = $db;
    }

    function read()
    {
        $qry  = "SELECT c.name as category_name, p.id, p.name , p.description, p.price , p.category_id, p.created FROM ".$this->table_name." p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC";
        $statement = $this->conn->prepare($qry);
        $statement->execute();
        return $statement;
    }

    // create product
function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->created=htmlspecialchars(strip_tags($this->created));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":created", $this->created);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}

// used when filling up the update product form
function readOne(){

    // query to read single record
    $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->name = $row['name'];
    $this->price = $row['price'];
    $this->description = $row['description'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
}

//Update Function for update data value to database table
  function update()
  {
    $qry = "UPDATE ".$this->table_name." SET name=:name, price=:price, description=:description, category_id=:category_id WHERE id=:id";

    $stmt = $this->conn->prepare($qry);
    //*note the query parameter must be in the same position
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->price=htmlspecialchars(strip_tags($this->price));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":price", $this->price);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":category_id", $this->category_id);
    $stmt->bindParam(":id", $this->id);

    if($stmt->execute())
    {
      return true;
    }
    return false;
  }

  //delete function to delete product by id
  function delete()
  {
    $qry = "DELETE FROM ".$this->table_name." WHERE id=?";
    $stmt = $this->conn->prepare($qry);
    $this->id=htmlspecialchars(strip_tags($this->id));
    $stmt -> bindParam(1, $this->id);

    if($stmt->execute())
    {
      return true;
    }
    return false;
  }



    // function create()
    // {
    //   $qry = "INSERT INTO ".$this->table_name." SET name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
    //   $statement = $this->conn->prepare($qry);
    //
    //   $this->name=htmlspecialchars(strip_tags($this->name));
    //   $this->price=htmlspecialchars(strip_tags($this->price));
    //   $this->description=htmlspecialchars(strip_tags($this->description));
    //   $this->category_id=htmlspecialchars(strip_tags($this->category_id));
    //   $this->created=htmlspecialchars(strip_tags($this->created));
    //
    //   $statement->bindParam(":name", $this->name);
    //   $statement->bindParam(":price", $this->price);
    //   $statement->bindParam(":description", $this->description);
    //   $statement->bindParam(":category_id", $this->category_id);
    //   $statement->bindParam(":created", $this->created);
    //
    //   if($statement->execute())
    //   {
    //     return true;
    //   }
    //   return false;
    // }



}
 ?>
