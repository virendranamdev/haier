<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php require_once('Class_Library/class_get_ceomessage.php'); ?>
<?php
$value = $_GET['idpost'];
$clientid = $_SESSION['client_id'];
$obj = new GetCEOMessage();

$result = $obj->getSinglePost($value, $clientid);
$value = json_decode($result, true);
$videoval = $value[0]['video_url'];
//echo "<pre>";
//print_r($value);
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

<?php
$postid = $_GET['idpost'];
$string = "post_id=$postid";

$sub_req_url = "http://admin.benepik.com/employee/virendra/benepik_admin/lib/android_like_display.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$getcat = json_decode($resp, true);

//$like = count($getcat['posts']);
$total_like = $getcat['total_like'];
//echo $val;
?>
<div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo "<h4>" . $value[0]['post_title'] . "</h4>"; ?>
                <?php echo "<div style='font-size: 11px; font-weight: bold;color: gray; margin-bottom: 1%;'>" . $value[0]['created_date'] . "</div>"; ?>
				
				<?php
				if($value[0]['post_img'] != "")
				{
				?>
                <img src="<?php echo $value[0]['post_img']; ?>"class="img img-responsive" style="box-shadow: gray 0px -1px 10px 1px;max-height: 250px; width: 100%" onerror='this.src="images/u.png"'/>
				<?php 
				}
				else
				{
				?>
				<input type="hidden" name="video_url" id="video_url" value="<?php echo $value[0]['video_url'];?>">
				
				<iframe allowfullscreen="1" style="width:100%;height:400px;" id="youtube_url" frameborder="0"></iframe>
				
				<?php
				}
				?>
                <div style="font-size: 16px;font-family: calibri, sans-serif; text-align: justify;"><?php echo "<p >" . $value[0]['post_content'] . "</p>"; ?></div>
            </div>
        </div>

<!--        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                	<button type="button" class="btn  btn-sm likeBTN" data-toggle="modal" data-target="#myModalLikepop">
                                <span class="glyphicon glyphicon-thumbs-up"></span>  Likes : <?php echo $total_like; ?>
                        </button>

            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-comment"></span> Comments
                </button>
                <?php
                $postid = $_GET['idpost'];
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
                ?>


            </div>
        </div>-->


<!--        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div id="RecentComment">
                    <p class="LatestActivitiesHeading">Total comment </p>
                    <hr>
                    <?php
                    for ($i = 0; $i < $resul; $i++) {
                        echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
                        //echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                        echo "<img src=" . $get['posts'][0]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important'/>";
                        //echo "</button>";
                        echo "</div>";
                        echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                        echo "<p class='LatestActivitiesSub-Heading'>" . $get['posts'][$i]['firstname'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $get['posts'][$i]['cdate'] . "</p>";
                        echo "<p class='LatestActivitiesDate'>" . $get['posts'][$i]['content'] . "</p></div></div><hr>";
                    }
                    ?>
                </div>
            </div>	
        </div>-->





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
for ($k = 0; $k < $total_like; $k++) {
    echo "<div class='row'>
<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4 col-sm-offset-1'>";
    echo "<img src=" . $getcat['posts'][$k]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important;margin-top: -11px;margin-left: -19px;'/>";
    echo "</div>";
    echo "<div class='col-xs-7 col-sm-7 col-md-7 col-lg-7'> ";
    echo "<p class='LatestActivitiesSub-Heading'>" . $getcat['posts'][$k]['firstname'] . " " . $getcat['posts'][$k]['lastname'] . "</p>";
    echo "<p style='font-size:12px;color:gray;margin:0px;'>" . $getcat['posts'][$k]['cdate'] . "</p>";
    echo "</div>";
    echo "</div>";
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