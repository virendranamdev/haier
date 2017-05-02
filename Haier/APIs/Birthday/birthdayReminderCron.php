<?php

error_reporting(0);
//ini_set('display_errors','1');
$project = '/Benepik_testing/Haier/';

$_SERVER['SERVER_NAME'] = "52.66.130.250";
define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME'] . $project);

require_once('/var/www/html'.$project.'Class_Library/class_push_notification.php');
require_once('/var/www/html'.$project.'Class_Library/Api_Class/class_wish.php');

$obj = new wish();
$push = new PushNotification();            // class_push_notification.php

$client_id = "CO-25";
$BY = "Haier Connect";
$fullpath = "";
$flag_name = "";
$FLAG = 21;
$sf = "successfully send";
$ptime = "";
$utime = "";
$hrimg = "";
$device = "device";
$DATE = "";

$POST_CONTENT = "Wish Happy Birthday";
$reminder = 1;

$googleapiIOSPem = $push->getKeysPem($client_id);
$bdayResponse = $obj->getTodaysBirthdays($client_id,$reminder);
$workAnniversaryResponse = $obj->getTodaysWorkAnniversary($client_id,$reminder);
//print_r($workAnniversaryResponse);die;
//print_r($bdayResponse);die;

if($bdayResponse['success'] == 1) {
   foreach ($bdayResponse['Data'] as $user_data) {  
   	$POST_TITLE = "Today is ".$user_data['username']."'s birthday";
	$birthday_reminder = $obj->getTodaysBatchBirthdays($user_data['employeeId']);

	foreach ($birthday_reminder['Data'] as $row) {
	    $row['reminder_msg'] = $POST_TITLE;
	    $POST_ID = 'birth-'.rand();
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

}

if($workAnniversaryResponse['success'] == 1) {
   foreach ($workAnniversaryResponse['Data'] as $user_data) {  
   	$POST_TITLE = "Today is ".$user_data['username']."'s work anniversary";
	$anniversary_reminder = $obj->getTodaysBatchWorkAnniversary($user_data['employeeId']);
	
	foreach ($anniversary_reminder['Data'] as $row) {
	    $row['reminder_msg'] = $POST_TITLE;
	    $POST_ID = 'work-'.rand();
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

}

//header('Content-type: application/json');
//echo json_encode($birthday_reminder);
?>
