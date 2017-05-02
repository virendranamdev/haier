<?php

include("../../Class_Library/class_push_notification.php");

//$jsonArr = json_decode(file_get_contents("php://input"), true);
//extract($jsonArr);

$data = array("Title" => "Apollo Mario", "Content" => "All Manav Rachna Testing Content for Push Notification for IOS", "flag" => "3", "flagValue" => "Message : ", "Picture" => "", "Date" => "");

//$data = array('Id' => '', 'Title' => "Apollo Mario", 'Content' => "Testing Content for Push Notification", 'SendBy' => '', 'Picture' => '', 'Date' => '', 'flag' => '3', 'flagValue' => "Message", 'success' => '', 'like' => '', 'comment' => '');
//$ids = "e9H7mLK1PgI:APA91bGW908_5OZgAIGQpqVY379htUZcFPPthNXuH7dsYCN87ZeoVbaLp1NqjyOnPaeCCxWF_y91gua_VHqWy2N1T4bjwWkbGu4b-Ufi29idn69r4KGToiQu8-ZxsKSTvemYhRMIy30F";

//$idsIOS = array("068ac3f436079761978367fa92a41390b13901031115ae50e93490d023c9421e"); //prod
$idsIOS = array("b2437cd65b2f319fe9d8cbf54707ad517a6afaab7a9e3d9658b6b87a4175ce8c");//dev

//$gpk = "AIzaSyAJxALJGtfCqI4Sgakixdkc4rv1GEO20zc";
$pem_file = "Pem_files/HaierProduction.pem"; // Testing
//$pem_file = "Pem_files/ZoomConnect.pem"; // Production

$obj = new PushNotification;
$device = 'device';
//$response = $obj->sendGoogleCloudMessage($data, $ids, $gpk);
$response = $obj->sendAPNSPush($data, $idsIOS, $pem_file, $device);

header('Content-type: application/json');
echo $response;
