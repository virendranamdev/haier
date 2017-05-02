<?php
@session_start();
require_once('../../Class_Library/class_reading.php');
require_once('../../Class_Library/Api_Class/class_app_post.php');
require_once('../../Class_Library/class_push_notification.php');
require_once('../../Class_Library/class_welcomeTable.php');
require_once('../../Class_Library/class_get_group.php'); // use for custom group

date_default_timezone_set('Asia/Calcutta');
$post_date = date('Y-m-d H:i:s A');

$obj = new Post();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
$read = new Reading();
$welcome_obj = new WelcomePage();
$customGroup = new Group(); 

$maxid = $obj->maxId();  //---------get latest post_id
/* * ******************************START HERE************************************************ */

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

/* * ********************************************************************************************** */
$jsonArr = json_decode(file_get_contents("php://input"), true);
//$postdata = file_get_contents("php://input");

//json_decode($postdata, true);

/*{
    "uploadimage":"",
            "content":"",
            "author":"",
            "auth":"veeru",
            "client_id":"CO-25",
            "selected_user":"Group1,"
            
            
}*/

if (!empty($jsonArr['client_id'])) {
    $POST_TITLE = "";
    $POST_TEASER = "";
    $POST_ID = $maxid;
    $DATE = $post_date;
    $User_Type = "Selected";
    $FLAG = 3;
    $push_noti = "PUSH_YES";
    $comment = "COMMENT_YES";
    $like = "LIKE_YES";

    /*     * ******************************************************************** */
    if (!isset($like) && $like != 'LIKE_YES') {
        $like = 'LIKE_NO';
        $like1 = 'No';
    } else {
        $like1 = 'Yes';
    }

    if (!isset($comment) && $comment != 'COMMENT_YES') {
        $comment = 'COMMENT_NO';
        $comment1 = 'No';
    } else {
        $comment1 = 'Yes';
    }
    /*     * ********************************************************************* */

//echo "this is post data ".$postdata;

    $request = $jsonArr;
   // echo "<pre>";      print_r($request); 
    $POST_IMG = $request['uploadimage'];
    $POST_CONTENT = $request['content'];
    $USERID = $request['author'];
    $BY = $request['auth'];
    $clientid = $request['client_id'];
     $device = $request['device'];
    $groupid = $request['selected_user'];
    $flag_name = "Picture : ";
    if ($User_Type == 'Selected') {
        $user1 = $groupid;
        $user2 = rtrim($user1, ',');

        $myArray = explode(',', $user2);
//print_r($myArray)."<br/>";
    }
	
	//print_r($myArray)."<br/>";
    /*     * *********************************** Get User Image ******************************************** */
    //$devname = "dev";
	$userimage = $push->getImage($USERID);
    $image = $userimage[0]['userImage'];
    /* echo "hr image: ".$image."<br/>";
      echo "this is hr image";
      echo "<pre>";
      print_r($userimage);
      echo "</pre>"; */
    /*     * ********************************************************************************* */


    /*     * ******************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */


    /*     * ********************* insert into database ************************************************ */

    $number = $obj->randomNumber(12);
    $imgname = $obj->convertintoimage($POST_IMG, $number,$POST_ID);
	//print_r($imgname);
	
    $target = '../images/post_img/';
    $thumbimgname = explode('/', $imgname);
    $path_name =  $thumbimgname[2];
    $imagepath = $target . $path_name;
    
    $thumb_image = $push->makeThumbnails($target, $path_name, 20);
    $thumb_img = str_replace('../', '', $thumb_image);
    
    $POST_IMG_THUMB = $thumb_img;
    
	
    $result = $obj->create_Post($clientid, $POST_ID, $POST_TITLE, $imgname,$POST_IMG_THUMB, $POST_TEASER, $POST_CONTENT, $DATE, $USERID, $BY, $FLAG, $comment, $like,$device);
//echo "result".$result;
    $type = "Picture";
    $result1 = $welcome_obj->createWelcomeData($clientid, $POST_ID, $type, $POST_CONTENT, $imgname, $DATE, $USERID,$FLAG);


    $groupcount = count($myArray);
	$general_group = array();
    $custom_group = array();
    for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
        $result2 = $read->postSentToGroup($clientid, $POST_ID, $myArray[$k],$FLAG);
//echo $result2;

		$groupdetails = $read->getGroupDetails($clientid, $myArray[$k]);  //get all groupdetails

		//echo "groupdetail";
		//print_r($groupdetails);
        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }
		/*echo "custom group";
		print_r($custom_group);
		echo "general group";
		print_r($general_group);*/
    }

    /*     * ****************  fetch all user employee id from user detail start **************************** */
	 if (count($general_group) > 0) {
    $gcm_value = $push->get_Employee_details($User_Type, $general_group, $clientid);
    $generaluserid = json_decode($gcm_value, true);
	 } 
	 else
	{   
               $generaluserid = array();
    }
	
	if (count($custom_group) > 0) {
        $gcm_value1 = $customGroup->getCustomGroupUser($clientid, $custom_group);
        $customuserid = json_decode($gcm_value1, true);

    }
     else{
              $customuserid = array();
    }
	/*echo "general group id";
	print_r($generaluserid);
	echo "custom group id";
	print_r($customuserid);*/

    /*     * *************************get group admin uuid  form group admin table if user type not= all *************************** */
    if ($User_Type != 'All') {
        //$groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);
        //$adminuuid = json_decode($groupadminuuid, true);
        /* echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>"; */
        /*         * ****** "--------------all employee id---------"** */

        $allempid = array_merge($generaluserid, $customuserid);
         /*echo "mearg both array"."<br>";
          echo "<pre>";
          print_r($allempid);
          echo "<pre>";
         */
        /*         * ** "--------------all unique employee id---------"********** */

        $allempid1 = array_values(array_unique($allempid));
		/*echo "uniqueid";
		print_r($allempid1);*/
    } else {
        $allempid1 = $generaluserid;
    }
     /*echo "<pre>";
      print_r($allempid1);
      echo "<pre>";*/
    /*     * ******* insert into post sent to table for analytic sstart************ */

    $total = count($allempid1);
//echo   "total user:-".$total."<br>";
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
//echo "post sent to :--".$uuid."<br>";
		if (!empty($uuid)) {
        $read->postSentTo($clientid, $maxid, $uuid,$FLAG);
		}
    }
	
	
	
	
    /*     * ******* insert into post sent to table for analytic sstart************ */

    /*     * *** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
    /*echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>";*/


    /*     * *******************Create file of user which this post send  start******************** */
    $val[] = array();
    foreach ($token1 as $row) {
        array_push($val, $row["email"] . "," . $row["registrationToken"]);
    }

    $file = fopen("../send_push_datafile/" . $maxid . ".csv", "w");

    foreach ($val as $line) {
        fputcsv($file, explode(',', $line));
    }
    fclose($file);
    /*     * *******************Create file of user which this post send End******************** */
    $hrimg = dirname(SITE_URL)."/".$image;
//echo "this si hr img:=".$hrimg;
    $sf = "successfully send";
    $ids = array();
    $idsIOS = array();

    foreach ($token1 as $row) {
        if ($row['deviceName'] == 3) {
            array_push($idsIOS, $row["registrationToken"]);
        } else {
            array_push($ids, $row["registrationToken"]);
        }
//array_push($ids,$row["registrationToken"]);
    }

    $path = dirname(SITE_URL)."/". $imgname;
//echo $path; die;
    $data = array('Id' => $maxid, 'Content' => $POST_CONTENT, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $path, 'Date' => $post_date, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf, 'comment' => $comment1, 'like' => $like1);

	//print_r($data);
	
   $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile'],$device);
    $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);

	//print_r($revert);
    $rt = json_decode($revert, true);

   /* if ($revert) {

//echo "<script>alert('Post Successfully Send');</script>";
// echo $path;
        $response = $revert;
        /* echo "<pre>";
          print_r($rt);
          echo "</pre>"; */
    
	
	if ($rt['success'] == 1) 
	{
               $response['success'] = 1;
			   $response['msg'] = "Post send";
			   $response = json_encode($response);
            }
         else {
            $response['success'] = 0;
			$response['msg'] = "There is some Error , please contact info@benepik.com";
			$response = json_encode($response);
        }
	
	
} else {
    $response['success'] = 0;
    $response['msg'] = "Invalid json";
	$response = json_encode($response);
}
header('Content-type: application/json');
echo $response;
?>