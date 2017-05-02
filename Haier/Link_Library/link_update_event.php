<?php
session_start();
require_once('../Class_Library/class_event.php');
require_once('../Class_Library/class_post.php');
$obj = new Post();
$obj_event = new Event();
if (!empty($_POST['client'])) {
  $cid = $_POST['client'];
  $pid = $_POST['postid'];
  $page = $_POST['page'];
  $video_url = (!empty($_POST['video_url'])) ? $_POST['video_url'] : "";

  $USERID = $_SESSION['user_unique_id'];
    
  $title = $_POST['posttitle'];
  $venue = $_POST['venue'];
  $eventdate = $_POST['event_date'];
  $eventtime = $_POST['event_time'];
  $registration = $_POST['reg'];
  $description = $_POST['description'];
  $EVENT_FULL_TIME = $eventdate . " " . $eventtime;
  $previousimage = $_POST['himage'];
  $previousvideo = $_POST['hvideo'];
  $currentimg = $_FILES['uploadimage']['name'];
  
  date_default_timezone_set('Asia/Kolkata');
  $post_date = date("Y-m-d h:i:s", time());

  if ($_FILES['uploadimage']['error'] != 4 && $video_url == "") {
  $path = $_FILES['uploadimage']['name'];
  $pathtemp = $_FILES['uploadimage']['tmp_name'];

    $target = '../Event/event_img/';   // folder name for storing data
    $folder = 'Event/event_img/';      //folder name for add with image insert into table

    /************************fetch max id ************************************ */
      if(!empty($path)) {
		if($previousimage != "")
		{
	   unlink(BASE_PATH . '/'. $previousimage);
		  //echo BASE_PATH;
		}
      $path_name = $pid . "-" . str_replace(' ', '', $path);

      $imagepath = $target . $path_name;
      
    $POST_IMG = $folder . $path_name;
    $fullpath = SITE_URL . "Event/event_img/" . $path_name;
//echo $fullpath;
    $obj->compress_image($pathtemp, $imagepath, 20);
	//echo BASE_PATH . '/'. $previousimage;
		
      }	 else {
		$POST_IMG = $previousimage;
	}
 }
 else if($video_url != "" && $currentimg == "")
	 {		 
     	    $POST_IMG = '';
     }
	 else if($previousimage != "" && $video_url == "")
	 {
		 $POST_IMG = $previousimage;
	 }
	 else if($previousimage == "" && empty($_POST['video_url']) && $currentimg=="")
	 {
		 $video_url = $previousvideo;
		 $POST_IMG = "";
	 }
		//echo $POST_IMG;
    $result = $obj_event->updatePost($cid, $pid, $title, $venue,$registration,$description ,$EVENT_FULL_TIME, $POST_IMG, $post_date, $USERID,$video_url);
   
    if ($result['success'] == 1) 
        {
        if($page == "event")
        {
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_event.php'</script>";
        }
    }
	else
	{
		echo "<script>alert('Post Not Updated');</script>";
        echo "<script>window.location = '../view_event.php'</script>";
	}
}



?>
