<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/task.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare task object
$task = new Task($db);
  
// get id of task to be edited
$data = json_decode(file_get_contents("php://input"));
  
if($data){
    // set ID property of task to be edited
    $task->id = $data->id;
    
    // set task property values
    $task->name = $data->name;
    $task->key = $data->key;
}
  
// update the task
if($task->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Task was updated."));
}
  
// if unable to update the task, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update task."));
}
?>