<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<!--<script src="js/validation/createPostValidation.js"></script>-->

<script>
    function ValidatePostNews() {
        var title = document.form1.title;
        var uploadimage = document.form1.uploadimage;
        var uploadvideo = document.form1.video_url;
		var gr = document.getElementById('selectedids').value;
        if (title.value == "")
        {
            window.alert("Please enter Title.");
            title.focus();
            return false;
        }
        if (uploadimage.value == "" && $("#uploadimage").is(":visible"))
        {
            window.alert("Please Upload Image");
            uploadimage.focus();
            return false;
        }
        if (uploadvideo.value == "" && $("#video_url").is(":visible"))
        {
            window.alert("Please enter Video URL");
            uploadvideo.focus();
            return false;
        }
		if (gr == "")
		{
        window.alert("Please Select Group");
        return false;
		}
		

        return true;
    }

</script>

<link rel="stylesheet" type="text/css" href="css/post_news.css">
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
    function cominghere()
    {
        $("#IphoneLivePriviewNewsModel").modal('show');
        var iframe = document.getElementById('youriframe');
        iframe.src = iframe.src;

    }

    $(document).ready(function () {
        $("#youtube_url").hide();

        $("#addVideo").hide();
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
                $("#uploadimage").val('');
                $("#imgprvw").attr('src', '');
            }
        });

        $("#preview_post").click(function () {

            var heading = $("#title").val();
            var content = CKEDITOR.instances.editor1.getData();
            var teaser = $("#comment").val();

            $("#testpopup").css({"display": "block"});

            $(".titlePost").html(heading);
            $(".contentPost").html(content);


            $("#Iphone5").click(function () {
                $("#rightoneIphone6").css({"z-index": 0});
                $("#rightoneIphone5").css({"z-index": 1});
            });
            $("#Iphone6").click(function () {
                $("#rightoneIphone5").css({"z-index": 0});
                $("#rightoneIphone6").css({"z-index": 1});
            });

        });
    });
</script>
<!-------------------------------SCRIPT END FROM HERE   --------->

<script>

    $(document).ready(function () {
        $("#close_news_priview").click(function () {

            $("#testpopup").hide();
        });

    });
</script>
<div id="meetop">	</div>
<div id="testpopup" style="height: 558px;margin-top:-400px;">

    <p id="close_news_priview" ><button type="button"class="btn btn-gray">X</button></p><br><br>

    <div id="iphone6">
        <div id="inneriphone6">

            <div class="iphoneSubParentDiv">
                <div class="row mobile_articals"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 "><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;"></i><font class="white_color">Article</font></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 

                            <p class="author previewAuthor"><font style="color:#acacac;">Author:</font> <font style="font-size:10px;"><?php echo $username = $_SESSION['user_name']; ?></font> </p>
                            <p class="titlePost NewsPriviewtitle"></p>
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> <img class="post_img img img-responsive imagePost previewImage" /></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                        <p class="contentPost previewContent"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                        <p class="date">Date: <?php echo date("d/m/Y"); ?></p>
                    </div>
                </div>


                <div class="row"style="margin:0px">
                    <div class="col-xs-12 col-md-12 col-sm-5 col-lg-5 "><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
                    <div class="col-xs-12 col-md-12 col-sm-7 col-lg-7 "><font style="font-size:10px;"> 0 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
                    <hr style="height:1px;background-color:gray;width:92%;">
                </div>


            </div>
        </div>
    </div>



</div>




<!--</div>-->

<!--</div> -->   

<div class="side-body padding-top" >
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">

        <div class="bs-example">

            <div class="row " >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3><strong> News </strong></h3><hr>
                </div>
            </div>

            <div class="row">

                <!---------------------------------long news from start here--------------------------------->	

                <form name="form1" role="form" action="Link_Library/link_post_news.php" method="post" enctype="multipart/form-data" onsubmit="return check();">
                    <input type="hidden" name = "flag" value="1">		
                    <input type="hidden" name = "flagvalue" value="News : ">			
                    <input type="hidden" name = "device" value="d2">			
                    <input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                    <input type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			

                    <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"  style="margin-left:14px;">
                                    <label for="TITLE">TITLE</label>
                                    <input style="width:98%;" type="text" name="title" id="title" class="form-control" placeholder=" Choose a heading for this news..." />
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-left:14px;">
                            <label for="option">Upload Option</label>
                            <input type="radio" name="uploadRadio" value="image" style="margin-left:14px;" class="user-success" required="required" checked="checked"> Image
                            <input type="radio" name="uploadRadio" value="video" style="margin-left:14px;" class="user-success" required="required"> Video URL
                        </div>

                        <div class="row" id="addVideo">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"  style="margin-left:14px;">
                                    <label for="Article image" style="font-weight: 600 ! important;">VIDEO URL</label>
                                    &nbsp;
                                    <input type="text" name="video_url" style="width: 77.5%;" id="video_url" width="500px">
                                    <input type="button" name="video_post" id="video_post" class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish"/>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <!-- <object width="425" height="350" data="http://www.youtube.com/v/GSyGd3Mwkkw" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/GSyGd3Mwkkw" /></object>  -->

                                        <iframe width="700" height="400" id="youtube_url" frameborder="0" allowfullscreen></iframe>
                                    </div>
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
						<!----------------------- image ------------------------->
						<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id="addImage" style="margin-left:14px;">
                            <label for="Article image" style="font-weight: 600 ! important;">UPLOAD IMAGE (max upload size: 2 MB resoulution:640*362)</label>

                            <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

                            <script type="text/javascript">

                            function showimagepreview1(input) {

                                if (input.files && input.files[0]) {




                                    var filtype = input.files[0].name.split('.').pop();
                                    if (filtype == 'jpg' || filtype == 'jpeg' || filtype == 'png' || filtype == 'gif')
                                    {
                                        $("#imgprvw").show();
                                        $("#videoPlayer").hide();
                                        var filerdr = new FileReader();
                                        filerdr.onload = function (e) {

                                            var image = new Image();
                                            image.src = e.target.result;
                                            image.onload = function () {
                                                //alert($("#uploadimage")[0].files[0].size);
                                                var height = this.height;
                                                var width = this.width;
                                                var size = parseFloat($("#uploadimage")[0].files[0].size / 1024).toFixed(2);
                                                if (size > 2000)
                                                {
                                                    alert("Sorry, your Image Size is too large , Max 2MB Size Are Allowed");
                                                    $('#imgprvw').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#uploadimage').val("");
                                                    return false;
                                                }

                                                else if (height > 1050 || width > 1050) {
                                                    alert("Width and Height must not exceed 1050 X 1050 px.");
                                                    $('#imgprvw').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#uploadimage').val("");
                                                    return false;
                                                }
                                                else
                                                {
                                                    $('#imgprvw').attr('src', e.target.result);
                                                    $('.post_img').attr('src', e.target.result);
                                                }
                                            }
                                            //$('#imgprvw').attr('src', e.target.result);
                                            //$('.post_img').attr('src', e.target.result);
                                        }
                                        filerdr.readAsDataURL(input.files[0]);
                                    } else
                                    {

                                        $("#videoPlayer").show();
                                        $("#imgprvw").hide();
                                        var player = document.getElementById("videoPlayer");
                                        var currentVID = document.getElementById('currentVID');
                                        var selectedLocalVID = document.getElementById('uploadimage').files[0];

                                        console.log(selectedLocalVID.files)

                                        currentVID.setAttribute('src', URL.createObjectURL(selectedLocalVID));
                                        player.load();
                                        player.play();

                                    }
                                }
                            }
                            </script>





                            <!--****************video code Start here*******************************-->

                            <!----------------HOW to cahnge VID source Localy--------------------->

                            <video muted controls  id="videoPlayer" width="258px" style=" display: none;">
                                <source id='currentVID' src="" type="video/mp4">
                            </video>

                            <!----------desired result--------------->
                            <br>
                            <!--<div id="desired result" style="background-color:grey;">
                            <div id="selectFile">
                              <input id="newlocalFILE" name="localfile" size="50"
                                   accept="video/*" type="file" onchange="playlocalVID();">
                            </div> </div>-->
                            <script>


                                function playlocalVID() {

                                    var player = document.getElementById("videoPlayer");
                                    var currentVID = document.getElementById('currentVID');
                                    var selectedLocalVID = document.getElementById('newlocalFILE').files[0];

                                    console.log(selectedLocalVID.files)

                                    currentVID.setAttribute('src', URL.createObjectURL(selectedLocalVID));
                                    player.load();
                                    player.play();

                                }
                            </script>

                            <!--****************video code end here*******************************-->


                            <img id="imgprvw" alt="uploaded image preview"/>
                            <div>
                               <!-- <input type="file" id="uploadimage" name="uploadimage" accept="image/video" onchange="showimagepreview1(this)" /> -->
                                <input type="file" id="uploadimage" name="uploadimage" accept="image/*" onchange="showimagepreview1(this)" />
                            </div>

                        </div>
						</div>
						<!------------------- / image --------------------------->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="Articlecontent">NEWS CONTENT</label>
                                        <div><textarea cols="120" id="editor1" name="content"  rows="10" required>	
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="row">

                            <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">
                                <!--
        <div class="form-group">
            <label for="comment">TEASER TEXT</label>
            <textarea class="form-control" rows="8" id="comment"cols="8" name="teasertext" placeholder="Short paragraph to draw attention to the article... "></textarea>
        </div>-->
                            </div>
                        </div>
                        <!--
                                                <div class="row">
                                                    <script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
                                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                        <div class="form-group">
                                                            <label for="Articlecontent">ARTICLE  CONTENT</label>
                                                            <div><textarea cols="120" id="editor1" name="content"  rows="10" required>	
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>-->
                        <script>
                                        CKEDITOR.replace('editor1');
                        </script>   <!--- this is for ckeditor   ----->

                        <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">

                        </script>
                        <div class="form-group col-sm-12">


                            <label for="exampleInputPassword1" style="padding-left:3px;">Select Group</label>
                            <div>
                                
                                <div class="col-md-6">
                                    <input type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                    <label for="radio6">
                                        Select Groups
                                    </label>
                                </div>
								<div class="col-md-6">
                                    <!--<input type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                    <label for="radio5">
                                        Send Post to All Groups
                                    </label>-->
                                </div>
                            </div>

                        </div>
                        <!---------------------this script for show textbox on select radio button---------------------->                        



                        <!------------Abobe script for show textbox on select radio button---------------------->
                        <div id ="everything" ng-show="content == 'Selected'">
                            <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                            <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                            <div class="form-group col-sm-5"id="alldatadiv" >
                                <center><p class="groupalldataheading">All Group</p> </center>
                                <div id="allitems" >
                                </div>

                            </div>
                            <div class="col-sm-1"></div>
                            <div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
                                <center><p class="groupselecteddataheading">Selected Group</p> </center>  
                                <p id="selecteditems"></i></p>

                            </div> 


                            <textarea id ="allids" style="display:none;" name="all_user"  height="660"></textarea>
                            <textarea id ="selectedids" style="display:none;" name="selected_user" ></textarea>
                        </div>

                    </div>


                    <!---------------------------------long news from End here--------------------------------->	

                    <div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">


                        <!--------------------This code is used to browse and display the image  and video start------------------------->
                    
                        <!--------------------This code is used to browse and display the image  and video end------------------------->

                        <div class="publication" style="margin-top:20px;">
                            <!---------------------------------------------------------------------->
                            <div class="publication"><p id="publication_heading">Options</p><hr>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                        <p class="publication_leftcontent" style="font-weight:500;" data-toggle="tooltip" data-placement="left" title="Post Comment (Enable/Disable) in case of Enable(On) User enable to comment on the post ">Comment ?</p>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">


                                        <div class="checkbox"style="margin-top:-10px;">
                                            <label><input type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label>
                                        </div>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                        <p class="publication_leftcontent" style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Post Like(Enable/Disable) in case of Enable(On) User enable to like the post ">Like ?</p>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                        <div class="checkbox"style="margin-top:-10px;">
                                            <label><input type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>

                                    </div>

                                </div>
                            </div>

                            <div class="publication"><p id="publication_heading">Notification</p><hr>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                        <p class="publication_leftcontent"style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                        <div class="checkbox"style="margin-top:-10px;">
                                            <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>

                                    </div>

                                </div>
                            </div>
                                                <!--	<div class="publication"><p id="publication_heading">Popup</p><hr>
 
                                                        <div class="row">
                                                          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                                                <p class="publication_leftcontent"style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Pop up .. Enable/Disable In Case of Enable(On) Pop Up will dispaly when app start">Show Pop Up ?</p>
                                                          </div>
                                                          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                                                <div class="checkbox"style="margin-top:-10px;">
                                                                <label><input style="color:#2d2a3b;" type="checkbox" data-toggle="toggle" name="popup" value="hide"></label></div>
                                                                
                                                          </div>
                                                         
                                                        </div>
                                                        </div>  ----->

                        </div>





                    </div>

                    <br/>
                    <br/>
                    <center><div class="form-group col-md-12">	
                            <input type="submit" name="news_post"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Publish" onclick= "return ValidatePostNews();" required/>
                            <!--&nbsp;&nbsp;&nbsp;<a href="#meetop"><input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none; font-weight: normal; position: absolute; left: 53.5%" value="Preview" />
                            </a>-->

<!--                            <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" style="margin-bottom:8px;"><center>
                                    <a href="#meetop"><input type="button" name="preview_post"  id="preview_post" class="btn btn-md btn-info preview_postBtn" style="    text-shadow: none; font-weight: normal; position: absolute; left: 280%;" value="Preview" />
                                    </a>
                                </center>
                            </div>-->
                        </div>
                    </center>

                </form> 
            </div>

        </div>
        <!--this script is use for tooltip genrate-->     
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </div>

    <!--tooltip script end here-->  
</div>
<?php include 'footer.php'; ?>
	