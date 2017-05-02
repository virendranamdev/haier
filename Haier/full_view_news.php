<?php
 include 'navigationbar.php'; 
 include 'leftSideSlide.php'; 
require_once('Class_Library/class_post.php');
require_once('Class_Library/class_post_like.php');
require_once('Class_Library/class_comment.php');

//$path = "http://" . $_SERVER['SERVER_NAME'] . "/Zoom_Connect/";
$path = SITE;
$postId = $_GET['idpost'];
$clientid = $_SESSION['client_id'];
$flag = 1;
$obj = new Post();

$result = $obj->onegetpostdetails($postId);
$value = json_decode($result, true);
$videoval = $value['posts'][0]['video_url'];
?>
<script>
     function getId(url) {
     var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
     var match = url.match(regExp);
     if (match && match[2].length == 11) {
     return match[2];
     } else {
     return 'error';
     }
     }
</script>
<script>
    $(document).ready(function () {
		
		var val = "<?php echo $videoval; ?>";
		//alert(val);
		if(val != "")
		{
		var myId = getId($(video_url).val());
		//alert(myId);
		$("#youtube_url").attr('src', 'https://www.youtube.com/embed/' + myId);
		}
    });
</script>

<div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo "<h4>" . $value['posts'][0]['post_title'] . "</h4>" ?>
                <?php echo "<div style='font-size: 11px; font-weight: bold;color: gray; margin-bottom: 1%;'>" . $value['posts'][0]['created_date'] . "</div>"; ?>
                <?php
				if($value['posts'][0]['post_img'] != "")
				{
				?>
                <img src="<?php echo $path . $value['posts'][0]['post_img']; ?>"class="img img-responsive" style="box-shadow: gray 0px -1px 10px 1px;max-height: 250px; width: 100%" onerror='this.src="images/u.png"'/>
				
				<?php 
				}
				else
				{
				?>
				<input type="hidden" name="video_url" id="video_url" value="<?php echo $value['posts'][0]['video_url'];?>">
				
				<iframe allowfullscreen="1" style="width:100%;height:400px;" id="youtube_url" frameborder="0"></iframe>
				
				<!--<iframe width="400px" height="400" frameborder="0" id="player" allowfullscreen title="YouTube video player" src="https://www.youtube.com/v/BpwurdedFbw"></iframe>-->
				
				
				
				<?php
				}
				?>
                <div style="font-size: 16px;font-family: calibri, sans-serif; text-align: justify;"><?php echo "<p >" . $value['posts'][0]['post_content'] . "</p>"; ?></div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-default btn-sm"data-toggle="modal" data-target="#myModalLikepop">
                    <span class="glyphicon glyphicon-thumbs-up"></span> Likes
                </button>
                <?php
/*
				//                require_once('Class_Library/class_post_like.php');
//                $object = new Like();
//                $val = $object->like_display($postId);
//                $val1 = json_decode($val, true);
//                echo $val1;
                
                  $postid = $_GET['idpost'];
                  $string = "post_id=$postid";
                  //$sub_req_url = "http://thomasinternational.benepik.com/webservices/communication_api/like_display.php";
                  $sub_req_url = SITE."Link_Library/android_like_display.php";
                  $ch = curl_init($sub_req_url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
                  curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
                  curl_setopt($ch, CURLOPT_HEADER, 0);
                  curl_setopt($ch, CURLOPT_POST, 1);

                  $resp = curl_exec($ch);
                  curl_close($ch);
                  $getcat = json_decode($resp,true);
//                  echo'<pre>';print_r($getcat);
                  $val = $getcat['total_like'];
                  echo $val;
*/
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
/*                $postid = $_GET['idpost'];
                $string = "post=$postid";

                //$sub_req_url ="http://thomasinternational.benepik.com/webservices/communication_api/c//omment_display.php";
                $sub_req_url = SITE . "Link_Library/android_comment_display.php";
                $ch = curl_init($sub_req_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_POST, 1);

                $resp = curl_exec($ch);
                curl_close($ch);
                $get = json_decode($resp, true);
                //echo"<pre>";
                //print_r($get);
                $resul = count($get['posts']);

                echo $resul;
*/
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
