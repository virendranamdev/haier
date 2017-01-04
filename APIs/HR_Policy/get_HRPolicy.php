<?php
require_once('../Class_Library/Api_Class/class_hrpolicy.php');

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
    //echo json_encode($response);
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$jsonArr = json_decode(file_get_contents("php://input"), true);
if(!empty($jsonArr)){
    if(!empty($jsonArr['clientid']))
    { 
        $obj = new GetPages();
        extract($jsonArr);

        $response  = $obj->getAllpagesFORandroid($clientid,$value,$module);
    }
}
else{
    $response['success'] = 0;
    $response['result']  = "Invalid json";
}

header('Content-type: application/json');
echo json_encode($response);

?>