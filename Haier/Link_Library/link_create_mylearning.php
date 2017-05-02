<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
@session_start();
require_once('../Class_Library/class_MyLearning.php');
require_once('../Class_Library/class_push_notification.php');
include_once('../Class_Library/class_get_group.php');  // for getting all group
require_once('../Class_Library/class_reading.php');


$learning_obj = new MyLearning();
$customGroup = new Group();                  // object of class get group for custom group
$read = new Reading();
$push_obj = new PushNotification();
date_default_timezone_set('Asia/Calcutta');
$post_date = date("Y-m-d H:i:s A");

if (!empty($_POST)) 
    {
    /** ***************** check poll image and poll question exist or not ************************* */
    $FLAG = 14;
    $dev = $_POST['device'];
    $flag_name = "MyLearning : ";
    $USERID = $_POST['useruniqueid'];
    //$POST_TITLE = "";
    $username = $_SESSION['user_name'];
    $clientid = $_SESSION['client_id'];
    $createdby = $_SESSION['user_unique_id'];
      $learningtitle = $_POST['learningtitle'];
    $learningimg = $_FILES['mylearningimage']['name'];
    $temppath = $_FILES["mylearningimage"]["tmp_name"];
  // echo $learningtitle;
 //  echo $learningimg;
  
    $createddate = $post_date;
   
    $target_dirlearning = "../images/mylearning/";
    $target_dblearning = "images/mylearning/";
    $uploadOk = 1;
    
     $target_dirlearningfile  = "../images/mylearning/mylearningfile/";
    $target_dblearningfile = "images/mylearning/mylearningfile/";
    $uploadOk = 1;
     /** ****************** find group **************************** */

    $User_Type = $_POST['user3'];
    if ($User_Type == 'Selected') {
        $user1 = $_POST['selected_user'];
        $user2 = rtrim($user1, ',');

        $myArray = explode(',', $user2);

//         echo "<pre>";
//          echo "selected";
//          print_r($myArray);
//          echo "</pre>"; 
    } else {
        // echo "all user"."<br/>";
        $User_Type = "Selected";
        //  echo "user type:-".$User_Type;
        $user1 = $_POST['all_user'];
        $user2 = rtrim($user1, ',');
        $myArray = explode(',', $user2);
//         echo "<pre>";
//          print_r($myArray)."<br/>";
//          echo "</pre>"; 
    }

    /*     * ********************* end find group ********************** */
  
     /*************************** find group **************************** */
   /* $result = $obj_group->getGroup($clientid);
    $value = json_decode($result, true);
    $getcat = $value['posts'];

    $wholegroup = array();
    foreach ($getcat as $groupid) 
        {
        array_push($wholegroup, $groupid['groupId']);
    }
*/
    $PUSH_NOTIFICATION = "";
    $push = "";
    // echo $push_noti;
//    if (!isset($_POST['push'])) 
//        {
//        $PUSH_NOTIFICATION = 'PUSH_NO';
//        $push = "No";
//    } 
//    else 
//        {
//        $PUSH_NOTIFICATION = 'PUSH_YES';
//        $push = "Yes";
//      }

    /************************* option  start ****************** */
   
     $total_option = $_POST['option'];
   //  echo "total option".$total_option;
     $status = 1;
     $dbpath = $target_dblearning.$learningimg;
     $value = $learning_obj->createMyLearning($clientid, $learningtitle, $dbpath, $createdby, $createddate,$status);
     $folderpath = $target_dirlearning.$learningimg;
    move_uploaded_file($_FILES["mylearningimage"]["tmp_name"], $folderpath);
     $learningid = $value['lastid'];
     
    for ($t = 1; $t <= $total_option; $t++) 
    {
        $textname = "filetitle" . $t;
        //echo $textname;
        $filetitle = $_POST[$textname];
        // echo "queq :".$t.$optiontext;
        
        /*****************************/
         $filename = "filename" . $t;
         $learningimg = $_FILES[$filename]['name'];
    $temppath = $_FILES[$filename]["tmp_name"];
  // echo $learningimg."<br>";
  // echo $temppath."<br>";
        $learningimgname  = $target_dblearningfile.$learningid.$learningimg;
     //   echo $learningimgname;
        /****************************/
        
$response = $learning_obj->createMyLearningFile($learningid,$filetitle, $learningimgname, $createdby, $createddate,$status);
$filepath = $target_dirlearningfile.$learningid.$learningimg;

 if (move_uploaded_file($_FILES[$filename]["tmp_name"], $filepath)) {
     //   echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
    }
     
	 /***************** add survey in post sent to group table ********************/
	 $groupcount = count($myArray);
            $general_group = array();
    $custom_group = array();
    for ($k = 0; $k < $groupcount; $k++) 
    {
	//echo "group id-".$wholegroup[$k];
        $result1 = $read->postSentToGroup($clientid, $learningid, $myArray[$k], $FLAG);
/***********************  custom group *********************/
         $groupdetails = $read->getGroupDetails($clientid, $myArray[$k]);  //get all groupdetails

        if ($groupdetails['groupType'] == 2) {
            array_push($custom_group, $myArray[$k]);
        } else {
            array_push($general_group, $myArray[$k]);
        }
    }
    
    
    /************************************* Get GoogleAPIKey and IOSPEM file ********************************* */
    $googleapiIOSPem = $push_obj->getKeysPem($clientid);
   
    /******************  fetch all user employee id from user detail start **************************** */
if (count($general_group) > 0) {
       
        $gcm_value = $push_obj->get_Employee_details($User_Type, $general_group, $clientid);
    
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
    /*************get group admin uuid  form group admin table if user type not= all ************** */
      
    if ($User_Type != 'All') 
        {
       // $groupadminuuid = $push_obj->getGroupAdminUUId($myArray, $clientid);

       // $adminuuid = json_decode($groupadminuuid, true);
      /*  echo "hello groupm admin id";
          echo "<pre>";
          print_r($adminuuid)."<br/>";
          echo "</pre>"; */
        /******** "--------------all employee id---------"***/

        $allempid = array_merge($generaluserid, $customuserid);
       /* echo "admin id";
          echo "<pre>";
          print_r($allempid);
          echo "<pre>";
        */

        /** ** "--------------all unique employee id---------"********** */

        $allempid1 = array_values(array_unique($allempid));
       /* echo "<pre>";
          print_r($allempid1);
          echo "<pre>";*/
    } 
    else 
        {
        $allempid1 = $generaluserid;
    }

   /* echo "<pre>";
          print_r($allempid1);
          echo "<pre>";*/
    /** ******* insert into post sent to table for analytic sstart************ */
 $total = count($allempid1);
   
    for ($i = 0; $i < $total; $i++) {
        $uuid = $allempid1[$i];
  //echo "post sent to empid:--".$uuid."<br/>";
        if (!empty($uuid)) {
            $read->postSentTo($clientid, $learningid, $uuid, $FLAG);
        }
    }
    /** ******* insert into post sent to table for analytic sstart************ */

    /***** get all registration token  for sending push **************** */
    $reg_token = $push_obj->getGCMDetails($allempid1, $clientid);
    $token1 = json_decode($reg_token, true);
   /* echo "----regtoken------";
      echo "<pre>";
      print_r($token1);
      echo "<pre>";
*/
    /*********************check push notificaticon enabale or disable******************** */
    if ($PUSH_NOTIFICATION == 'PUSH_YES') 
        {
        $fullpath = '';
        $hrimg = SITE_URL . $_SESSION['image_name'];
//echo "hr image:-".$hrimg;
        $sf = "successfully send";
        $ids = array();
        $idsIOS = array();
        foreach ($token1 as $row) {

            if ($row['deviceName'] == 3) {
                array_push($idsIOS, $row["registrationToken"]);
            } else {
                array_push($ids, $row["registrationToken"]);
            }
        }

       // $content = str_replace("\r\n", "", strip_tags($ques));
        $data = array('Id' => $surveyid, 'Title' => $POST_TITLE, 'Content' => $content, 'SendBy' => $username, 'image' => $fullpath, 'Picture' => $hrimg, 'Date' => $post_date,
            'Publishing_time' => $ptime, 'Unpublishing_time' => $utime, 'flag' => $FLAG, 'flagValue' => $flag_name, 'success' => $sf);

        $IOSrevert = $push_obj->sendAPNSPush($data, $idsIOS, $googleapiIOSPem['iosPemfile']);
        $revert = $push_obj->sendGoogleCloudMessage($data, $ids, $googleapiIOSPem['googleApiKey']);
        $rt = json_decode($revert, true);
print_r($rt);

        if ($rt) {
          
               echo "<script>alert('My Learning Successfully Created');</script>";
                //echo $rt;
                 echo "<script>window.location='../create_mylearning.php'</script>";
            
        }
    } 
    else {
        echo "<script>alert('My Learning Successfully Created');</script>";
        echo "<script>window.location='../create_mylearning.php'</script>";
       }
    
} 
else {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Untitled Document</title>
        </head>

        <body>
            <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
                <p>Choose  Image : 
                    <label for="fileField"></label>
                    <input type="file" name="poll_img" id="fileField" />
                </p>
                <p>Question : 
                    <label for="textarea"></label>
                    <textarea name="poll_question" id="textarea" cols="45" rows="5"></textarea>
                </p>
                <p>Options..............................................</p>
                <p>1: 
                    <label for="fileField2"></label>
                </p>
                <table width="200" border="0">
                    <tr>
                        <td>Option No.</td>
                        <td>Select Image (If Any)</td>
                        <td>Answer</td>
                    </tr>
                    <tr>
                        <td>1:</td>
                        <td><label for="fileField2"></label>
                            <input type="file" name="ansimg1" id="fileField2" /></td>
                        <td><label for="textarea2"></label>
                            <textarea name="ans1" id="textarea2" cols="25" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td>2:</td>
                        <td><label for="fileField2"></label>
                            <input type="file" name="ansimg2" id="fileField2" /></td>
                        <td><label for="textarea2"></label>
                            <textarea name="ans2" id="textarea2" cols="25" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td>3:</td>
                        <td><label for="fileField2"></label>
                            <input type="file" name="ansimg3" id="fileField2" /></td>
                        <td><label for="textarea2"></label>
                            <textarea name="ans3" id="textarea2" cols="25" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td>4:</td>
                        <td><label for="fileField2"></label>
                            <input type="file" name="ansimg4" id="fileField2" /></td>
                        <td><label for="textarea2"></label>
                            <textarea name="ans4" id="textarea2" cols="25" rows="2"></textarea></td>
                    </tr>
                </table> 
                <p>Send To All  : 
                    <label for="select"></label>
                    <select name="user3" id="select">
                        <option selected> ----------select -----------</option>
                        <option value="All"> All </option>
                        <option value="Selected"> Selected </option>
                    </select>
                </p>
                <p>Write group Id IF(Select Selected):
                    <label for="textfield"></label>
                    <input type="text" name="groupid" id="textfield" />
                </p>
                publishing time:<input type="date" name="publish1" /><br>
                    unpublishing time:<input type="date" name="publish2" />
                    <p>
                        <input type="submit" name="button" id="button" value="Submit" />
                    </p>
                    <p>&nbsp; </p>
            </form>
        </body>
    </html>
    <?php
}
?>