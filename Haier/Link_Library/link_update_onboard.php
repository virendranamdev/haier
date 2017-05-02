<?php
session_start();
require_once('../Class_Library/class_post.php');
$obj = new Post();
if (!empty($_POST['client'])) {
	
    $cid = $_POST['client'];
    $pid = $_POST['postid'];
     
     
    $USERID = $_SESSION['user_unique_id'];
    
    $title = $_POST['posttitle'];
	$about = $_POST['about']; 
    $designation = $_POST['designation'];
    $doj = $_POST['doj'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];
    $food = $_POST['food'];
	$holiday = $_POST['holiday'];
	$hobby = $_POST['hobby'];
	
	$POST_CONTENT =!empty($about) ? "#Benepik#about###" . $about . "<br>" : "#Benepik#about###";

    $POST_CONTENT .=!empty($designation) ? "#Benepik#designation###" . $designation . "<br>" : "#Benepik#designation###";

    $POST_CONTENT .=!empty($doj) ? "#Benepik#doj###" . $doj . "<br>" : "#Benepik#doj###";

    $POST_CONTENT .=!empty($location) ? "#Benepik#location###" . $location . "<br>" : "#Benepik#location###";
         
	$POST_CONTENT .=!empty($email) ? "#Benepik#email###" . $email . "<br>" : "#Benepik#email###";
          
	$POST_CONTENT .=!empty($contact) ? "#Benepik#contact###" . $contact . "<br>" : "#Benepik#contact###";


    $POST_CONTENT .=!empty($food) ? "#Benepik#food###" . $food . "<br>" : "#Benepik#food###";

    $POST_CONTENT .=!empty($holiday) ? "#Benepik#holiday###" . $holiday . "<br>" : "#Benepik#holiday###";

    $POST_CONTENT .=!empty($hobby) ? "#Benepik#hobby###" . $hobby . "<br>" : "#Benepik#hobby###";
	
	//echo $POST_CONTENT;
	
	
	$previousimage = $_POST['himage'];
    $path = $_FILES['uploadimage']['name'];
    $pathtemp = $_FILES['uploadimage']['tmp_name'];

    $target = '../images/post_img/';   // folder name for storing data
    $folder = 'images/post_img/';      //folder name for add with image insert into table

    date_default_timezone_set('Asia/Calcutta');
    $post_date = date("Y-m-d h:i:sa", time());

	
    /************************fetch max id ************************************ */
      if(!empty($path))
      {
	   unlink(BASE_PATH . '/' . $previousimage);
      $path_name = $pid . "-" . str_replace(' ', '', $path);

      $imagepath = $target . $path_name;
      
       $POST_IMG = $folder . $path_name;
    $fullpath = SITE_URL . "images/post_img/" . $path_name;
//echo $fullpath;
    $obj->compress_image($pathtemp, $imagepath, 20);
   
      }
 else {
         $POST_IMG = $previousimage;
         }
    $result = $obj->updatePost($cid, $pid, $title, $POST_CONTENT, $POST_IMG, $post_date, $USERID,$about);
   
    if ($result['success'] == 1) 
        {
        
        echo "<script>alert('Post Updated successfully');</script>";
        echo "<script>window.location = '../view_welcome_onboard.php'</script>";
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
