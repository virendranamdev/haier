<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
<script>
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
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
function ValidateLeadership()
{
    var posttitle = document.form1.posttitle;
	 var leadername = document.form1.leadername;
	//alert(posttitle);
    if (posttitle.value == "")
    {
        window.alert("Please Enter Title.");
        posttitle.focus();
        return false;
    }
	if (leadername.value == "")
    {
        window.alert("Please Enter Leader Name.");
        leadername.focus();
        return false;
    }
	return true;
}
</script>

<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
        <div class="bs-example">


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
                    <h4><strong>Update Leadership Talk</strong></h4><hr>
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
            require_once('Class_Library/class_getpost.php');
            $post = $_GET['idpost'];
            $page = $_GET['page'];
            //echo $post;
            $pageobj = new GetPost();
            $result1 = $pageobj->getSinglePost($post);
            $result = json_decode($result1, true);
//		echo "<pre>";print_r($result);die;
		
            $path = $result[0]['fileName'];
            $cid = $result[0]['clientId'];
            ?>
            <!------------------------------------------message portal start from here------------------------------------------------>	
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!----------------------------------------message  start from here---------------------------------------->	
                    <div class="row">
                        <form role="form" name="form1" method="post" enctype="multipart/form-data" action="Link_Library/link_update_leadership.php" onsubmit ="return check();">
                            <input type="hidden" name = "client" value="<?php echo $cid; ?>">
                            <input type="hidden" name="postid" value="<?php echo $_GET['idpost']; ?>" />
                            <input type="hidden" name="page" value="<?php echo $page; ?>" />
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Articlecontent"> Title</label>
                                    <input type="text" name="posttitle" class="form-control" value="<?php echo htmlspecialchars($result[0]['post_title'],ENT_QUOTES); ?>">
                                </div>
                            </div>
			</div>
				
			<div class="form-group" style="margin-left:14px;">
                            <label for="option">Upload Option</label>
                            <input type="radio" <?php if(!empty($result[0]['post_img'])){ ?> checked='checked' <?php } ?> name="uploadRadio" value="image" style="margin-left:14px;" class="user-success" required="required" > Image
                            <input type="radio" <?php if(!empty($result[0]['video_url'])){ ?> checked='checked' <?php } ?> name="uploadRadio" value="video" style="margin-left:14px;" class="user-success" required="required" > Video URL
                        </div>
					
			<div class="row" id="addVideo">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"  style="margin-left:14px;">
                                    <label for="Article image" style="font-weight: 600 ! important;">VIDEO URL</label>
                                    &nbsp;
                                    <input type="text" name="video_url" style="width: 77.5%;" id="video_url" width="500px" value="<?php echo $result[0]['video_url']; ?>" />
                                    <input type="button" name="video_post" id="video_post" class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish"/>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                   
									<input type="hidden" name="hvideo" value ="<?php echo $result[0]['video_url']; ?>" />
								   
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
					
			<div class="row" id="addImage">
                            <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12" >
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
									
									function showimagepreview(input) 
										{
										if (input.files && input.files[0]) {
										var filerdr = new FileReader();
										filerdr.onload = function(e) {
											//alert("hello");
											var image = new Image();
												//Set the Base64 string return from FileReader as source.
													   image.src = e.target.result;
															
													   //Validate the File Height and Width.
													   image.onload = function () {
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
													   alert("Height and Width must not exceed 1000 X 1000 px.");
														$('#imgprvw1').attr('src', "");
														$('.post_img').attr('src', "");
														 $('#filUpload').val("");
													   return false;
												   }
												   else
												   {
													   //alert ("image gud");
														$('#imgprvw1').attr('src', e.target.result);
														$('.post_img').attr('src', e.target.result);
												   }
											}
													
												/*$('#imgprvw').attr('src', e.target.result);
												$('.post_img').attr('src', e.target.result);*/
												}
												filerdr.readAsDataURL(input.files[0]);
												}
}

                                </script>
                                <img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px;height:110px; width:200px;border:1px solid #f1f1f0;" 
                                     src='<?php echo $result[0]['post_img']; ?>' onerror='this.src="images/u.png"'/>
                                <div>
                                      <input type="hidden" name="himage" value ="<?php echo $result[0]['post_img']; ?>" />
                              <input type="file" accept = "image/*" name="uploadimage" id="filUpload" onchange="showimagepreview(this)" />
                                </div>
                            </div>

							
			</div>
			<div class="row" style="margin-top:5px;">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Articlecontent">Leader Name</label>
                                    <input type="text" name="leadername" class="form-control" value="<?php echo htmlspecialchars($result[0]['postTeaser'],ENT_QUOTES); ?>">
                                </div>
                            </div>
							</div>
                            <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="Articlecontent">Content</label>
                                        <div>
                                            <textarea cols="80" id="editor1" name="postcontent" rows="10">	
                                                <?php echo $result[0]['post_content']; ?>
                                            </textarea>
                                        </div>
                                    </div>  
									</div>
						 </div>
                                 </div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							</div>
								 <script>
                                        CKEDITOR.replace('editor1');
                                    </script>   <!--- this is for ckeditor   ----->
								<div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group col-sm-12">
                                        <center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save" id="getData" onclick = "return ValidateLeadership();" /></center>
                                    </div>

                                </div>
                        
                    </div>
                            </form>
                </div>
               
            </div>
            
        </div>
    </div>			

</div>

</div>
<?php include 'footer.php'; ?>
