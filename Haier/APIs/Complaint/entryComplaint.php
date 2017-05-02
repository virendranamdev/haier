<?php

require_once('../../Class_Library/Api_Class/class_ComplaintSuggestion.php');
if (!class_exists('EarningPoint'))
    { include("../../Class_Library/Api_Class/class_userEarnPoint.php");}
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
/*{
 "clientid":"CO-25",
 "employeeid":"pSNx6y5WCp1EuIOsoS3iBesrFSObKF123",
 "content":"Test content 02:07 PM",
 "status":"1",
 "area":"",
 "isAnonymous":"1",
 "device":"ios"
}*/
if (!empty($jsonArr['clientid'])) {
    $obj = new Complaint();
     $earnobj = new EarningPoint();  // for adding suggestion point
     
    extract($jsonArr);
    $response = $obj->entryComplaint($clientid, $employeeid,$area, $content, $status, $isAnonymous, $device);
    
if($response['success'] == 1)
{
    $flagType = 7;              // module flagtype
    $postid = '';
  $earnobj->addGrievanceReward($clientid, $employeeid,$flagType,$postid);
}
else
{
    $response['success'] = 0;
    $response['result'] = "Some Error please write us to info@benepik.com";
}
} else {
    $response['success'] = 0;
    $response['message'] = "Invalid json";
}
header('Content-type: application/json');
echo json_encode($response);
?>
