<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php
require_once('Class_Library/class_post.php');
require_once('Class_Library/class_post_like.php');
require_once('Class_Library/class_comment.php');
?>
<?php
//$path = "http://" . $_SERVER['SERVER_NAME'] . "/Zoom_Connect/";
$path = SITE;
$postId = $_GET['idpost'];
$clientid = $_SESSION['client_id'];
$flag = 2;
$obj = new Post();

$result = $obj->onegetpostdetails($postId);
$value = json_decode($result, true);
?>


<div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
     <!-- <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo $path . $_SESSION['image_name']; ?>" class='img' id='user_image' style='margin-right:5px;' onerror='this.src = "images/usericon.png" ' >

                        </div>

                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                            <p><b><?php echo $_SESSION['user_name']; ?></b></p>
                            <p><small>
                          <?php echo "<div >" . $value['posts'][0]['created_date'] . "</div>"; ?></small></p>

                        </div>
                    </div>
	 -->
                  
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <b>  <?php echo "<h4>" . $value['posts'][0]['post_title'] . "</h4>" ?></b>
          
		   <?php echo "<div style='font-size: 11px; font-weight: bold;color: gray; margin-bottom: 1%;'>" . $value['posts'][0]['created_date'] . "</div>"; ?>
		  
                <div style="font-size: 16px;font-family: calibri, sans-serif; text-align: justify;"><?php echo "<p >" . $value['posts'][0]['post_content'] . "</p>"; ?></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-default btn-sm"data-toggle="modal" data-target="#myModalLikepop">
                    <span class="glyphicon glyphicon-thumbs-up"></span> Likes
                </button>
                <?php

				  $object = new Like();
                  $val = $object->likeView($postId,$clientid,$flag);
                  $getcat = json_decode($val, true);
				  echo $getcat['total_like'];                
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-comment"></span> Comments
                </button>
                <?php

				$objt = new Comment();
                $val = $objt->CommentView($postId,$clientid,$flag);
                $get = json_decode($val, true);
                //echo"<pre>";
                //print_r($get);
                $resul = count($get['posts']);
                echo $resul;
                ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div id="RecentComment">
                    <p class="LatestActivitiesHeading">Total comment</p>
                    <hr>
                    <?php
                    for ($i = 0; $i < $resul; $i++) {
                        echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
                        //echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                        echo "<img src=" . $get['posts'][$i]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important' onerror='this.src = &quot;images/usericon.png&quot;'/>";
                        //echo "</button>";
                        echo "</div>";

                        echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                        echo "<p class='LatestActivitiesSub-Heading'>" . $get['posts'][$i]['firstname'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $get['posts'][$i]['cdate'] . "</p>";

                        echo "<p class='LatestActivitiesDate'>" . $get['posts'][$i]['content'] . "</p></div></div><hr>";
                    }
                    ?>
                </div>
            </div>	
        </div>





    </div>
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
</div>



<!--**********pop up for like (start)***********-->


<div class="modal fade" id="myModalLikepop" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content"style="width:80%;">
            <div class="modal-header"style="background:#808080;color:#ffffff;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><p class="LatestActivitiesHeading">Likes</p></h6>
            </div>
            <div class="modal-body"style="max-height:550px;overflow-y:auto;">


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="latest_activity">


<?php
for ($i = 0; $i < $getcat['total_like']; $i++) {
//echo'<pre>';print_r($getcat);
    echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
    echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
    echo "<img src=" . $getcat['posts'][$i]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important;margin-top: -21px;margin-left: -19px;' onerror='this.src =&quot;images/usericon.png&quot;'/>";
    echo "</button></div>";
    echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
    echo "<p class='LatestActivitiesSub-Heading'>" . $getcat['posts'][$i]['firstname'] . " " . $getcat['posts'][$i]['lastname'] . "</p>";

// echo "<p style='font-size:10px;color:gray;margin:0px;'>".$getcat[$i]['firstname']."</p>";
    echo "<p class='LatestActivitiesDate'>" . $getcat['posts'][$i]['cdate'] . "</p></div></div><hr style='margin-top:0px;'>";
}
?>


                        </div>



                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<!--**********pop up for like (end)***********-->





<?php include 'footer.php'; ?>