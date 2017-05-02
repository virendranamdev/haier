<?php

error_reporting(0);
//ini_set('display_errors','1');
$project = '/Benepik_testing/Haier/';

$_SERVER['SERVER_NAME'] = "52.66.130.250";
define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] . $project);

require_once('/var/www/html'.$project.'Class_Library/class_push_notification.php');
require_once('/var/www/html'.$project.'Class_Library/Api_Class/class_wish.php');

if (!class_exists('EarningPoint'))
    { require_once('/var/www/html'.$project.'Class_Library/Api_Class/class_userEarnPoint.php');}

$obj = new wish();
$push = new PushNotification();            // class_push_notification.php
  $earnobj = new EarningPoint();  // for adding suggestion point

$client_id = "CO-25";
$BY = "Haier Connect";
date_default_timezone_set('Asia/Kolkata');
$flag_name = "";
$FLAG = 19;
$sf = "successfully send";
$ptime = "";
$utime = "";
$hrimg = "";
$device = "device";
$DATE = date('Y-m-d H:i:s', time());
$POST_CONTENT = "Birthday wish from Admin";

$clientAdmin  = $obj->adminDetails($client_id);
$bdayresponse = $obj->getTodaysBirthdays($client_id);
$workAnniversaryResponse = $obj->getTodaysWorkAnniversary($client_id);
//print_r($bdayresponse);die;
//print_r($workAnniversaryResponse);die;
$IDS = array();
$ids = array();
$idsIOS = array();
$googleapiIOSPem = $push->getKeysPem($client_id);
if ($bdayresponse['success'] == 1) {
    foreach ($bdayresponse['Data'] as $row) {
    	if($row['flag'] == 1){ 
        	$POST_TITLE = "Happy Birthday " . $row['username'];
        	$fullpath = SITE_URL . "images/wishimg/birthday.jpg";
        }elseif($row['flag'] == 2){
        	$POST_TITLE = "Happy Work Anniversary " . $row['username'];
        }
        $maxId = $obj->maxId();
        $POST_ID = $maxId;
	/*         * ********************************* save wish ************************************** */
        $wish = $obj->saveWish($POST_TITLE, "birthday.jpg", $client_id, $row['employeeId'], $row['flag'], $clientAdmin['employeeId']);
        
        /*********************** Add Earnpoint **************************/
         $flagType = 2;             // module flagtype
         $post_id = "";                     
     $earnobj->addBirthdayReward($client_id, $row['employeeId'],$flagType,$post_id);
        
        /********************************************/
        
        /*         * ******************************** end save wish *********************************** */
        
        $bdayData = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);

        if ($row['deviceName'] == 3) {
        	$bdayData['device_token'] = $row['registrationToken'];
		$IOSrevert = $push->sendAPNSPushCron($bdayData, $googleapiIOSPem['iosPemfile'], $device);
        } else {
	        $bdayData['device_token'] = $row['registrationToken'];
		$revert = $push->sendGoogleCloudMessageCron($bdayData, $googleapiIOSPem['googleApiKey']);
        }	
    }
   
}
if ($workAnniversaryResponse['success'] == 1) {
foreach ($workAnniversaryResponse['Data'] as $row) {
    	if($row['flag'] == 1){ 
        	$POST_TITLE = "Happy Birthday " . $row['username'];
        }elseif($row['flag'] == 2){
        	$POST_TITLE = "Happy Work Anniversary " . $row['username'];
        	$fullpath = SITE_URL . "images/wishimg/workanniversary.jpg";
        }
        $maxId = $obj->maxId();
        $POST_ID = $maxId;
	/*         * ********************************* save wish ************************************** */
        $wish = $obj->saveWish($POST_TITLE, "workanniversary.jpg", $client_id, $row['employeeId'], $row['flag'], $clientAdmin['employeeId']);
        
        
        /*********************** Add Earnpoint **************************/
         $flagType = 3;             // module flagtype
         $post_id = "";                     
  $earnobj->addAnniversaryReward($client_id, $row['employeeId'],$flagType,$post_id);
        
        /********************************************/
        
        /*         * ******************************** end save wish *********************************** */
        
        $AnniversaryData = array('Id' => $POST_ID, 'Title' => $POST_TITLE, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);
        
        if ($row['deviceName'] == 3) {
        	$AnniversaryData['device_token'] = $row['registrationToken'];
		$IOSrevert = $push->sendAPNSPushCron($AnniversaryData, $googleapiIOSPem['iosPemfile'], $device);
        } else {
	        $AnniversaryData['device_token'] = $row['registrationToken'];
		$revert = $push->sendGoogleCloudMessageCron($AnniversaryData, $googleapiIOSPem['googleApiKey']);
        }	
    }
}
else {
    $data['success'] = 0;
    $data['message'] = "No wishes for today";
}
//header('Content-type: application/json');
//echo json_encode($AnniversaryData);
?>
    
