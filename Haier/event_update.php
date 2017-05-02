<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
function ValidateEvent() {
    var posttitle = document.form1.posttitle;
    var venue = document.form1.venue;
    var event_date = document.form1.event_date;
	var todatdate = document.form1.today;
	var event_time = document.form1.event_time;
	var description = document.form1.description;
	
    if (posttitle.value == "")
    {
        window.alert("Please Enter Title.");
        posttitle.focus();
        return false;
    }
    if (venue.value == "")
    {
        window.alert("Please Enter Venue.");
        venue.focus();
        return false;
    }
	if (event_date.value == "")
    {
        window.alert("Please Select Date.");
        event_date.focus();
        return false;
    }
	if (event_date.value < todatdate.value)
    {
        window.alert("You Are Not Allowed To Select Past Date");
        event_date.focus();
        return false;
    }
	if (event_time.value == "")
    {
        window.alert("Please Select Time.");
        event_time.focus();
        return false;
    }
	if (description.value == "")
    {
        window.alert("Please Enter Description.");
        description.focus();
        return false;
    }

    return true;
}

$(document).ready(function () {
//        $("#youtube_url").hide();

//        $("#addVideo").hide();
//        $("#addImage").hide();

        $('input[name="uploadRadio"]').click(function () {
            if ($(this).attr("value") == "image") {
                $("#addVideo").hide();
                $("#addImage").show();
                $(".popup").show();
                $("#video_url").val('');
                $("#youtube_url").attr('src', '');
                $("#youtube_url").hide();
            }
            if ($(this).attr("value") == "video") {
                $("#addImage").hide();
                $(".popup").hide();
                $("#addVideo").show();
                $("#filUpload").val('');
                $("#imgprvw1").attr('src', '');
            }
        });
});
</script>
<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
        <div class="bs-example">


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
                    <h4><strong>Update Event</strong></h4><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                    }
                    ?>

                </div>

            </div>
            <br>

            <?php
            unset($_SESSION['msg']);
            ?>
            <?php
            require_once('Class_Library/class_event.php');
            $eventid = $_GET['eventid'];
            $clientid = $_GET['clientid'];
			$page = $_GET['page'];
            //echo $post;
			$flag = 6 ;
            $pageobj = new Event();
            $result1 = $pageobj->getsingleeventdetails($eventid,$clientid,$flag);
            $result = json_decode($result1, true);
            $registration = $result['posts'][0]['registration'];
            ?>
            <!------------------------------------------message portal start from here------------------------------------------------>	
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!----------------------------------------message  start from here---------------------------------------->	
                    <div class="row">
                        <form role="form" name="form1" method="post" enctype="multipart/form-data" action="Link_Library/link_update_event.php" onsubmit="return check();">
                            <input type="hidden" name = "client" value="<?php echo $clientid; ?>">
                            <input type="hidden" name="postid" value="<?php echo $_GET['eventid']; ?>" />
                            <input type="hidden" name="page" value="<?php echo $page; ?>" />
                            
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							
				<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Articlecontent"> Title</label>
                                    <input type="text" name="posttitle" class="form-control" value="<?php echo htmlspecialchars($result['posts'][0]['post_title'],ENT_QUOTES); ?>">
                                </div>
                            </div>
			</div>
			<div class="form-group" style="margin-left:14px;">
                            <label for="option">Upload Option</label>
                            <input type="radio" <?php if(!empty($result['posts'][0]['post_img'])){ ?> checked='checked' <?php } ?> name="uploadRadio" value="image" style="margin-left:14px;" class="user-success" required="required" > Image
                            <input type="radio" <?php if(!empty($result['posts'][0]['video_url'])){ ?> checked='checked' <?php } ?> name="uploadRadio" value="video" style="margin-left:14px;" class="user-success" required="required" > Video URL
                        </div>
                        
                        <div class="row" id="addVideo">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"  style="margin-left:14px;">
                                    <label for="Article image" style="font-weight: 600 ! important;">VIDEO URL</label>
                                    &nbsp;
                                    <input type="text" name="video_url" style="width: 77.5%;" id="video_url" width="500px" value="<?php echo $result['posts'][0]['video_url']; ?>" />
                                    <input type="button" name="video_post" id="video_post" class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish"/>
									
									<input type="hidden" name="hvideo" value ="<?php echo $result['posts'][0]['video_url']; ?>" />
									
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   
                                        <iframe width="700" height="400" id="youtube_url" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                    <script>
                                    $(document).ready(function () {
                                    	if ($("#video_url").val() != '') {
		                            	var myId = getId($(video_url).val());
		                            	getId(myId);
		                            	$("#youtube_url").attr('src', 'https://www.youtube.com/embed/' + myId);
		                                $("#youtube_url").show();
		                                $("#addImage").hide();
                                	}else{
	                                	$("#addVideo").hide();
                                		$("#youtube_url").hide();
                                	}
                                    });
                                    
                                        function getId(url) {
                                            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                                            var match = url.match(regExp);
                                            if (match && match[2].length == 11) {
                                                return match[2];
                                            } else {
                                                return 'error';
                                            }
                                        }
                                        $("#video_post").click(function () {
                                            var myId = getId($(video_url).val());
                                            if ($("#video_url").val() == '') {
                                                $("#video_url").focus();
                                                $("#youtube_url").hide();
                                            } else {
                                                $("#youtube_url").attr('src', 'https://www.youtube.com/embed/' + myId);
                                                $("#youtube_url").show();
                                            }
                                        });
                                        $('#video_url').keyup(function () {
                                            if ($("#video_url").val() == '') {
                                                $("#youtube_url").attr('src', '');
                                                $("#youtube_url").hide();
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>	
							
			<div class="row">
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" id="addImage">
                                <label for="Articlecontent">Select Image</label><br/>
                                <script type="text/javascript">
                                    /*function showimagepreview(input) {
                                        if (input.files && input.files[0]) {
                                            var filerdr = new FileReader();
                                            filerdr.onload = function (e) {
                                                $('#imgprvw1').attr('src', e.target.result);
                                                $('.post_img').attr('src', e.target.result);
                                            }
                                            filerdr.readAsDataURL(input.files[0]);
                                        }
                                    }*/
					function showimagepreview(input) {
                                        if (input.files && input.files[0]) {
                                            var filerdr = new FileReader();
                                            filerdr.onload = function (e) {
												var image = new Image();
                                            image.src = e.target.result;
                                            image.onload = function () {
                                                //alert($("#uploadimage")[0].files[0].size);
                                                var height = this.height;
                                                var width = this.width;
                                                var size = parseFloat($("#filUpload")[0].files[0].size / 1024).toFixed(2);
                                                if (size > 2000)
                                                {
                                                    alert("Sorry, your Image Size is too large , Max 2MB Size Are Allowed");
                                                    $('#imgprvw1').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#filUpload').val("");
                                                    return false;
                                                }

                                                else if (height > 1000 || width > 1000) {
                                                    alert("Width and Height must not exceed 1000 X 1000 px.");
                                                    $('#imgprvw1').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#filUpload').val("");
                                                    return false;
                                                }
                                                else
                                                {
                                                    $('#imgprvw1').attr('src', e.target.result);
                                                    $('.post_img').attr('src', e.target.result);
                                                }
                                            }
                                               // $('#imgprvw1').attr('src', e.target.result);
                                               // $('.post_img').attr('src', e.target.result);
                                            }
                                            filerdr.readAsDataURL(input.files[0]);
                                        }
                                    }
									
                                </script>
                                <img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px;height:110px; width:200px;border:1px solid #f1f1f0;" 
                                     src='<?php echo $result['posts'][0]['post_img']; ?>' onerror='this.src="images/u.png"'/>
                                <div>
                                        <input type="hidden" name="himage" value ="<?php echo $result['posts'][0]['post_img']; ?>" />
                              		<input type="file" accept ="image/*" name="uploadimage" id="filUpload" onchange="showimagepreview(this)" />
                                </div>
                            </div>
							
			</div>
			
							
					      <div class="row" style="margin-top:5px;">
						  <div class="form-group col-md-6">
							<label for="VENUE">Venue</label>
							<input  style="color:#2d2a3b;" type="text" name="venue" id="venue" class="form-control" value="<?php echo htmlspecialchars($result['posts'][0]['venue'],ENT_QUOTES); ?>" placeholder=" Choose a venue" />
						  </div>
						   <div class="form-group col-md-3">
							<label for="DATE">Date</label>
							<input style="color:#2d2a3b;"  type="date" name="event_date" id="event_date" class="form-control" placeholder="Choose a date" value="<?php echo $result['posts'][0]['edate']; ?>"/>
							<input type="hidden" name="today" value="<?php echo date("Y-m-d"); ?>">
						  </div>
						   <div class="form-group col-md-3">
							<label for="TIME">Time</label>
							<input style="color:#2d2a3b;" type="time" name="event_time" value ="<?php echo $result['posts'][0]['etime']; ?>" id="event_time" class="form-control" placeholder=" Choose a time" />
						  </div>
					     </div>
						
						<div class="row" style="margin-top:5px;">
						  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="Articlecontent">Description</label>
                                    <textarea class="form-control" rows="5" name="description" id="description"><?php echo $result['posts'][0]['post_content']; ?></textarea>
                                </div>
                            </div>
							
							<div class="form-group col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<label for="exampleInputPassword1">Registration</label>
                                      <div class="row">
                                         <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="radio" id="user2" name="reg"  value="Yes" <?php echo ($registration=='Yes')?'checked':'' ?>>
                                        <label for="radio5">
                                          Yes
                                        </label>
                                      </div>
                                      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="radio" id="user2"   name="reg" value="No" <?php echo ($registration=='Yes')?'':'checked' ?>>
                                        <label for="radio6">
                                         No
                                        </label>
                                      </div>
                                    </div>
									
								</div>
							
						</div>
													
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
							
							
							<div class="form-group col-sm-12 col-sm-8 col-md-8 col-lg-8">
                                        <center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save" id="getData" onclick ="return ValidateEvent();"/></center>
                            </div>
							

                           </form>
                </div>
               
            </div>
            
        </div>
    </div>			

</div>

</div>
<?php include 'footer.php'; ?>
