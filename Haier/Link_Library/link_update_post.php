<?php
session_start();
require_once('../Class_Library/class_post.php');
$obj = new Post();
if (!empty($_POST['client'])) {
    $cid = $_POST['client'];
    $pid = $_POST['postid'];
    $page = $_POST['page'];
		
    $video_url = (!empty($_POST['video_url'])) ? $_POST['video_url'] : "";

    $USERID = $_SESSION['user_unique_id'];
    
    $title = $_POST['posttitle'];
    $content = $_POST['postcontent']; 
    $previousimage = $_POST['himage'];
	$previousvideo = $_POST['hvideo'];
	
    $currentimg = $_FILES['uploadimage']['name'];
	
	
	
    if ($_FILES['uploadimage']['error'] != 4 && $video_url == "") {
	    $path = $_FILES['uploadimage']['name'];
	    $pathtemp = $_FILES['uploadimage']['tmp_name'];

	    $target = '../images/post_img/';   // folder name for storing data
	    $folder = 'images/post_img/';      //folder name for add with image insert into table

	    date_default_timezone_set('Asia/Kolkata');
	    $post_date = date("Y-m-d h:i:s", time());

	    /************************fetch max id ************************************ */
	      if(!empty($path))
	      {
		    if($previousimage != "")
			{
		   unlink(BASE_PATH . '/' . $previousimage);
			}
	      $path_name = $pid . "-" . str_replace(' ', '', $path);

	      $imagepath = $target . $path_name;
	      
	       $POST_IMG = $folder . $path_name;
	    $fullpath = SITE_URL . "images/post_img/" . $path_name;
	//echo $fullpath;
	    $obj->compress_image($pathtemp, $imagepath, 20);
	   
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
	 }
	
    $result = $obj->updatePost($cid, $pid, $title, $content, $POST_IMG, $post_date, $USERID, $video_url);
   
    if ($result['success'] == 1) 
        {
        if($page == "news")
        {
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_news.php'</script>";
        }
        elseif($page == "leadership")
        {
            echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_ceo_message.php'</script>";
        }
    }
}


/* * ********************* insert into databse ************************************************ */ 
else {
    ?>
    <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>

    <form name="form1" method="post" action="" enctype="multipart/form-data">
        <p>Page Id:
            <label for="textfield"></label>
            <input type="text" name="pageid" id="textfield">
        </p> 
        <p>Page Title:
            <label for="textfield"></label>
            <input type="text" name="pagetitle" id="textfield">
        </p>

        <p>Page image:
            <label for="textfield"></label>
            <input type="file" name="pageimage" id="textfield">
        </p>
        <p>Page Content:
            <label for="textfield"></label>
            <textarea cols="80" id="editor1" name="pagecontent" rows="10">	
            </textarea>

        <p>created date:
            <label for="textfield"></label>
            <input type="date" name="date" id="textfield"> 
        </p>

        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <?php

}
?>
