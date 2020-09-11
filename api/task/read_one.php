<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/task.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare task object
$task = new Task($db);
  
// set ID property of record to read
$task->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of task to be edited
$task->readOne();
  
if($task->name!=null){
    // create array
    $task_arr = array(
        "id" =>  $task->id,
        "name" => $task->name,
        "key" => $task->key
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($task_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user task does not exist
    echo json_encode(array("message" => "Task does not exist."));
}
?>