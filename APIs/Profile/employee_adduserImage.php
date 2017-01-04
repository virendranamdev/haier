<?php

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
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
/* * ************************************************************************************* */
include("../../Class_Library/Api_Class/class_family.php");

$postdata = file_get_contents("php://input");

if (!empty($postdata)) {
    $obj = new Family();
    $dname = $obj->randomNumber(6);
    $userdata = json_decode($postdata, true);
//print_r($userdata);
    $clientid = $userdata['clientid'];
    $uploadImage = $userdata['uploadImage'];
    $employeeid = $userdata['employeeid'];

    $result = $obj->userImageUpload($clientid, $uploadImage, $employeeid, $dname);

    echo $result;
} else {
    $response['success'] = 0;
    $response['result'] = "Invalid json";

//        $response = $result;
}

header('Content-type: application/json');
echo json_encode($response);
?>