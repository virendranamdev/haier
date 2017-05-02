<?php
@session_start();
require_once('../Class_Library/class_reading.php');
require_once('../Class_Library/class_event.php');
require_once('../Class_Library/class_push_notification.php');
require_once('../Class_Library/class_welcomeTable.php');
require_once('../Class_Library/class_get_group.php'); // use for custom group
date_default_timezone_set('Asia/Kolkata');
$event_date = date('Y-m-d H:i:s');


$obj = new Event();                                        // object of class post page
$push = new PushNotification();                         // object of class push notification page
//$db = new Connection_Mahle();
$read = new Reading();
$welcome_obj = new WelcomePage();
$customGroup = new Group();                  // object of class get group for custom group
$maxeventid = $obj->getMaxEventId();  //---------get latest post_id

$folder = '../Event/event_img/';   // folder name for storing data
$target = 'Event/event_img/';      //folder name for add with image insert into table

/* * ******************************START HERE************************************************ */
if (!empty($_POST)) {

    $flag_value = $_POST['flag'];
    $dev = $_POST['device'];
    $video_url = (!empty($_POST['video_url'])) ? $_POST['video_url'] : "";

    if ($dev == 'd2') {
        $USERID = $_POST['useruniqueid'];
        $googleapi = $_POST['googleapi'];
//echo "user id - ".$USERID;
        $BY = $_SESSION['user_name'];
        $clientid = $_SESSION['client_id'];
//echo $clientid;
    } else {
        $USERID = $_POST['author'];
        $BY = $_POST['auth'];
        $clientid = $_POST['client'];
    }

    $fullpath = "";
    if ($_FILES['uploadimage']['error'] != 4) {
        $path = $_FILES['uploadimage']['name'];
        $pathtemp = $_FILES['uploadimage']['tmp_name'];
//echo $path;
        $path_name = $maxeventid . "-" . str_replace(' ', '', $path);

        $imagepath = $folder . $path_name;

        $fullpath = SITE_URL . $target . $path_name;

        $push->compress_image($pathtemp, $imagepath, 20);
    }
    /*     * **************************************** check like & comment start ********************** */


    /* $like = (empty($_POST['like'])?"":$_POST['like']);
      // $like ="";
      // if (!isset($like)) {
      if ($like =="") {
      $like = 'LIKE_NO';
      $like_val = 'like_no';
      } else {
      $like_val = 'like_yes';
      $like = 'LIKE_YES';
      }

      $comment = (empty($_POST['comment'])?"":$_POST['comment']);
      //$comment = "";
      //if (!isset($comment)) {
      if ($comment=="") {
      $comment = 'COMMENT_NO';
      $comment_val = 'comment_no';
      } else {
      $comment_val = 'comment_yes';
      $comment = 'COMMENT_YES';
      } */

//$push_noti =  "PUSH_YES";
    /* $push_noti = "";
      if (!isset($push_noti)) {
      $PUSH_NOTIFICATION = 'PUSH_NO';
      } else {
      $PUSH_NOTIFICATION = 'PUSH_YES';
      } */
    $push_noti = (empty($_POST['push']) ? "" : $_POST['push']);
    // if (!isset($push_noti)) {
    if ($push_noti == "") {
        $PUSH_NOTIFICATION = 'PUSH_NO';
    } else {
        $PUSH_NOTIFICATION = 'PUSH_YES';
    }
    //echo $like;
    //echo $comment;
//	echo $PUSH_NOTIFICATION;

    $popup_NOTIFICATION = "";
    if (!isset($_POST['popup'])) {
        $popup_NOTIFICATION = 'POPUP_NO';
    } else {
        $popup_NOTIFICATION = 'POPUP_YES';
    }

    /*     * **************************************** check like & comment end ********************** */

    $EVENT_ID = $maxeventid;
    $EVENT_TITLE = $_POST['title'];
    $flag_name = $_POST['flagvalue'];
    
    $EVENT_IMG = ($_FILES['uploadimage']['error'] != 4) ? $target . $path_name : "";
//echo "image name:-".$EVENT_IMG;
    $EVENT_VENUE = $_POST['venue'];
    $EVENT_CONTENT = $_POST['event_content'];
    $EVENT_DATE = $_POST['event_date'];
    $EVENT_TIME = $_POST['event_time'];
    $EVENT_FULL_TIME = $EVENT_DATE . " " . $EVENT_TIME;
    $REGISTRATION = $_POST['reg'];
    $COST = $_POST['cost'];
    $DATE = $event_date;
    $FLAG = $flag_value;
    $User_Type = $_POST['user3'];

    if ($User_Type == 'Selected') {
        $user1 = $_POST['selected_user'];
        $user2 = rtrim($user1, ',');
        $myArray = explode(',', $user2);
        /*  echo "selected group"."<br/>";
          echo "<pre>";
          print_r($myArray)."<br/>";
          echo "</pre>"; */
    } else {
        // echo "allgroup group"."<br/>";
        $User_Type = "Selected";
        $user1 = $_POST['all_user'];
        $user2 = rtrim($user1, ',');
        $myArray = explode(',', $user2);
        /*   echo "allgroup group"."<br/>";
          echo "<pre>";
          print_r($myArray)."<br/>";
          echo "</pre>"; */
    }


    $userimage = $push->getImage($USERID);
    $image = $userimage[0]['userImage'];

    if ($popup_NOTIFICATION == 'POPUP_YES') {
        $res = $push->createpopup($EVENT_ID, $clientid, $EVENT_IMG, $FLAG, $DATE, $USERID);
        //print_r($res);
    }

    /**     * ******************** insert into database ************************************************ */
//createNewEvent($clientid,$eventid,$title,$imgname,$venue,$eventdate,$desc,$regis);
    $result = $obj->createNewEvent($clientid, $EVENT_ID, $EVENT_TITLE, $EVENT_IMG, $EVENT_VENUE, $EVENT_FULL_TIME, $EVENT_CONTENT, $REGISTRATION, $DATE, $USERID, $FLAG, $COST, $video_url);

    $type = "Event";
    $img = "";
    $result1 = $welcome_obj->createWelcomeData($clientid, $EVENT_ID, $type, $EVENT_TITLE, $EVENT_IMG, $DATE, $USERID, $FLAG);

    $groupcount = count($myArray);
      $general_group = array();
    $custom_group = array();
    for ($k = 0; $k < $groupcount; $k++) {
//echo "group id".$myArray[$k];
        $result1 = $read->eventSentToGroup($clientid, $EVENT_ID, $myArray[$k], $FLAG);
 /***********************  custom group *********************/
         $groupdetails = $read->getGroupDetails($clientid, $myArray[$k]);  //get all groupdetails

        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }
    }

// echo $result;

    /**     * ****************************************** Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push->getKeysPem($clientid);
    /*     * ************************************************************************************ */

    /*****************  fetch all user employee id from user detail start **************************** */
    if (count($general_group) > 0) {
       
        $gcm_value = $push->get_Employee_details($User_Type, $general_group, $clientid);
    
        $generaluserid = json_decode($gcm_value, true);

    }
    else{   
               $generaluserid = array();
    }
    if (count($custom_group) > 0) {
        $gcm_value1 = $customGroup->getCustomGroupUser($clientid, $custom_group);
        $customuserid = json_decode($gcm_value1, true);

    }
     else{
              $customuserid = array();
    }
    /**************************get group admin uuid  form group admin table if user type not= all *************************** */
    if ($User_Type != 'All') {
      //  $groupadminuuid = $push->getGroupAdminUUId($myArray, $clientid);


       // $adminuuid = json_decode($groupadminuuid, true);
        /* echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>";
          echo "--------------all employee id---------"; */

        $allempid = array_merge($generaluserid, $customuserid);
        /* echo "<pre>";
          print_r($allempid);
          echo "<pre>";

          echo "--------------all unique employee id---------"; */

        $allempid1 = array_values(array_unique($allempid));
        /* echo "<pre>";
          print_r($allempid1);
          echo "<pre>"; */
    } else {
        $allempid1 = $generaluserid;
    }

    /*     * ******* insert into post sent to table for analytic sstart************ */

    $total = count($allempid1);
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
//echo "count no.:-".$i."->".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->eventSentTo($clientid, $maxeventid, $uuid);
        } else {
            continue;
        }
    }
    /*     * ******* insert into post sent to table for analytic sstart************ */

    /*     * *** get all registration token  for sending push **************** */
    $reg_token = $push->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
    /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>"; */
//echo "Push notification :".$PUSH_NOTIFICATION."<br/>";
    /*     * *******************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') {

        /*         * ******************* send push by  push notification******************** */

        //$hrimg = SITE_URL . $_SESSION['image_name'];
        $hrimg = $image;
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

        $content = str_replace("\r\n", "", strip_tags($EVENT_CONTENT));
        $data = array('Id' => $maxeventid, 'Title' => $EVENT_TITLE, 'Content' => $content, 'SendBy' => $BY, 'Picture' => $hrimg, 'image' => $fullpath, 'Date' => $DATE, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);
        //print_r($data);
        $IOSrevert = $push->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push->sendGoogleCloudMessage($data, $ids, $googleapi);
        $rt = json_decode($revert, true);

        if ($rt) {
            if ($dev == 'd1') {
                echo "<script>alert('Event Successfully Send');</script>";
                //echo $rt;
            } else {
                echo "<script>alert('Event Successfully Send');</script>";
                //print_r($rt);
                echo "<script>window.location='../create_event.php'</script>";
            }
        }
    } else {
        echo "<script>alert('Event Successfully Send');</script>";
        echo "<script>window.location='../create_event.php'</script>";
    }


    /*     * **************************if condition 2 end**************************************************************** */
} else {
    ?>
    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="device" value="d1">
        <br/>

        <p>client id:
            <label for="textfield"></label>
            <input type="text" name="clientid" id="textfield">
        </p>
        <p>title
            <label for="textfield"></label>
            <input type="text" name="title" id="textfield">
        </p>
        <p>Event image:
            <label for="textfield"></label>
            <input type="file" name="eventimage" id="textfield">
        </p>
        <p>venue:
            <label for="textfield"></label>
            <input type="text" name="venue" id="textfield">
        </p>
        <p>event content:
            <label for="textfield"></label>
            <textarea name="content" id="textfield"></textarea>
        </p>
        <p> Author(Valid system generated  UU Id)<p>
            <label for="textfield"></label>
            <input type="text" name="author" id="textfield">
        <p>
        <p>register<p>
            <label for="textfield"></label>
            <select name="register">
                <option selected>--select registration option--</option>
                <option value='yes'>yes</option>
                <option value='no'>no</option>
            </select>
        <p>

            <input type="hidden" name="user3" id="textfield" value="All">

            <input type="submit" name="news_post" id="button" value="Submit">
        </p>
    </form>

    <?php
}
?>
