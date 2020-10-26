<?php
// required headers
// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate task object
include_once '../objects/task.php';
  
$database = new Database();
$db = $database->getConnection();
  
$task = new Task($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->key)
){
  
    // set task property values
    $task->name = $data->name;
    $task->key = $data->key;
    //$task->created = date('Y-m-d H:i:s');
  
    // create the task
    if($task->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Task was created."));
    }
  
    // if unable to create the task, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create task."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create task. Data is incomplete."));
}
?>