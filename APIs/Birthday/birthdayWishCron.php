<?php
require_once('../../Class_Library/Api_Class/class_wish.php');
require_once('../../Class_Library/class_push_notification.php');
$obj = new wish();
$push = new PushNotification();            // class_push_notification.php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
$client_id = "CO-25";
$BY      = "Haier Connect";
$fullpath = "";
$flag_name = "Wish : ";
$FLAG = 19;
$sf = "successfully send";
$ptime = "";
$utime = "";
$hrimg = "";
$device = "device";
$DATE   = "";
$POST_ID      = "";
$POST_CONTENT = "Birthday wish from Admin";


$googleapiIOSPem = $push->getKeysPem($client_id);
$response = $obj->getTodaysBirthdays($client_id);
//echo "<pre>";   
//print_r($response);
$ids = array();
$idsIOS = array();

foreach ($response['Data'] as $row) {
    $POST_TITLE   = "Happy Birthday ".$row['username'];
    if ($row['deviceName'] == 3) 
        {
        array_push($idsIOS, $row["registrationToken"]);
    } else {
        array_push($ids, $row["registrationToken"]);
    }
}

$data = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);
//print_r($data);   
//  $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile'], $device);
$revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
$rt = json_decode($revert, true);


header('Content-type: application/json');
echo json_encode($response);
?>
    