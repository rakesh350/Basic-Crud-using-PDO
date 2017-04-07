<?php
include "Crud.php";


/* Database connection */
$server = "localhost";
$database = "test";
$username = "root";
$password = "";

try{
  $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /* Creating object of Crud class */
  $crud_obj = new Crud($conn);

  /*--------------------------------- Inserting data -------------------------------- */

  // Prepare data to be inserted in an associative array
  /* Remove this comment to perform insert operation

  $data_to_be_insert = array(
    "name" => "John Doe",
    "email" => "john@mail.com",
    "address" => "House no. 7, F Street, City"
  );

  // Table in which data to be insert
  $table = "employees";

  // Finally Insert data
  $insert_action = $crud_obj->insert($table, $data_to_be_insert);

  if($insert_action !== false){
    echo "Data inserted with id ".$insert_action;
  }else{
    echo "Failed";
  }

  /-----------------------------------------------------------------/

  /*--------------------- Selecting data without condition --------*/
  /*
  // Table from where data to be selected
  $table = "employees";

  // Perform query
  $result = $crud_obj->select($table);

  if($result !== false){
    foreach ($result as $row) {
      echo json_encode($row)."<br/>";
    }
  }
  /*---------------------------------------------------------------*/

  /*--------------------- Selecting data with condition --------*/

  // Table from where data to be selected
  $table = "employees";

  // Condition for selecting data
  /*$select_condition = array(
    "id" => 2,
    "operator" => "or",
    ""
  );*/

  // Perform query
  $result = $crud_obj->select($table);

  if($result !== false){
    foreach ($result as $row) {
      echo json_encode($row)."<br/>";
    }
  }
  /*---------------------------------------------------------------*/



}catch(PDOException $e){
  echo $e->getMessage();
}




?>
