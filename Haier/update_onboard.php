<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	

<script>
    function check() {
        if (confirm('Are You Sure, You want to Update this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script>
function Validateonboard()
{
    var name = document.form1.posttitle;
    var userabout = document.form1.about;
    var designation = document.form1.designation;
    var doj = document.form1.doj;
    var location = document.form1.location;

    if (name.value == "")
    {
        window.alert("Please Enter Joinee's Name");
        name.focus();
        return false;
    }
    if (userabout.value == "")
    {
        window.alert("Please write Short Paragraph In About Fields");
        userabout.focus();
        return false;
    }
    if (designation.value == "")
    {
        window.alert("Please Enter Designation");
        designation.focus();
        return false;
    }
    if (doj.value == "")
    {
        window.alert("Please Enter Date Of joining");
        doj.focus();
        return false;
    }
    if (location.value == "")
    {
        window.alert("Please Enter Location");
        location.focus();
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
                    <h4><strong>Update Welcome Aboard</strong></h4><hr>
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
            require_once('Class_Library/class_get_onboard.php');
            $post = $_GET['idpost'];
            $cid = $_GET['cid'];
			$device = "panel";
            //echo $post;
            $onboard = new GetWelcomeOnboard();
            $result = $onboard->getSingleOnboard($post, $cid, $device);
            $value = json_decode($result, true);
           /* echo "<pre>";   
            print_r($value);
			echo "</pre>";*/
			if (!empty($value)) {

                foreach ($value as $values) {
                    $post_content_keys = explode("#Benepik#", $values['post_content']);

                    //echo '<pre>';print_r($post_content_keys);die;

                    unset($post_content_keys[0]);
                    $post_content_keys = array_values($post_content_keys);
                    //echo'<pre>';print_r($post_content_keys);die;
                    $final_data_keys = array();
                    $final_data_value = array();
                    foreach ($post_content_keys as $keys => $val) {

                        $key_data = explode("###", $val);

                        array_push($final_data_keys, trim($key_data[0], " "));
                        array_push($final_data_value, strip_tags(trim($key_data[1], " \n\t\t "), ""));
                    }

                    array_push($final_data_keys, 'user_image', 'user_name', 'postid','likeSetting','comment', 'flagCheck', 'userImage');
                    array_push($final_data_value, $values['post_img'], $values['post_title'], $values['post_id'],$values['likeSetting'],$values['comment'], "12", $values['userImage']);
                    //$final_data_value[2] = date('d M Y', strtotime($final_data_value[2]));

                    $response_data = array_combine($final_data_keys, $final_data_value);
					
					/*echo "<pre>";
					print_r($response_data);
					echo "</pre>";*/
                }
			}
            
            ?>
            <!------------------------------------------message portal start from here------------------------------------------------>	
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!----------------------------------------message  start from here---------------------------------------->	
                    <div class="row">
                        <form role="form" name="form1" method="post" enctype="multipart/form-data" action="Link_Library/link_update_onboard.php" onsubmit="return check();">
                            <input type="hidden" name = "client" value="<?php echo $cid; ?>">
                            <input type="hidden" name="postid" value="<?php echo $_GET['idpost']; ?>" />
                                                        
                            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							 
							 <div class="row">
                             <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Articlecontent">Joinee's Name</label>
                                    <input type="text" name="posttitle" class="form-control" value="<?php echo htmlspecialchars($value[0]['post_title'],ENT_QUOTES); ?>" placeholder="Enter Joinee's Name">
                                </div>
                            </div>
							</div>
							
							<div class="row">
                             <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="form-group">
                               <label for="Articlecontent">Image</label>
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

                            /*$('#imgprvw').attr('src', e.target.result);
                             $('.post_img').attr('src', e.target.result);*/
                        }
                        filerdr.readAsDataURL(input.files[0]);
                    }
                }
                                </script>
                                <img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px;height:110px; width:200px;border:1px solid #f1f1f0;" 
                                     src='<?php echo $value[0]['post_img']; ?>' onerror='this.src="images/u.png"'/>
                                <div>
                                      <input type="hidden" name="himage" value ="<?php echo $value[0]['onboarimg']; ?>" />
                              <input type="file" name="uploadimage" id="filUpload" onchange="showimagepreview(this)" />
                                </div>   
                                </div>
                            </div>
							
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                <div class="form-group">
                                    <label for="Articlecontent">About</label>
                                   <textarea id="about" name="about" class="form-control" rows="5" placeholder="Enter About"><?php echo $response_data['about']; ?></textarea>
                                </div>
                            </div>
							
							</div>
					<!--------------------------------------------------->
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label for="Articlecontent">Designation</label>
									<div><textarea style="color:#2d2a3b;" class="form-control" rows="1" id="designation" cols="3" name="designation" placeholder="Enter Designation"><?php echo $response_data['designation']; ?></textarea></div>
								</div>
								</div>
							 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                 <div class="form-group">
                                <label for="Articlecontent">Date of joining</label>
                                <div><input style="color:#2d2a3b;" type="date" class="form-control"  id="area5"  name="doj" placeholder="Enter Date Of Joining" value="<?php echo $response_data['doj']; ?>"></div>
                                 </div>
                            </div>
							</div>
						<!--------------------------------------------------->
						<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group">
                                    <label for="Articlecontent">Email ID</label>
                                    <div>
                                    <input style="color:#2d2a3b;" type="text" name="email" id="emailid" class="form-control" placeholder="Enter Email ID" value="<?php echo $response_data['email']; ?>"/>
                                    </div>
									</div>
								</div>
							 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                 <div class="form-group">
                                <label for="Articlecontent">Contact No.</label>
                                <div>
                                    <input style="color:#2d2a3b;" type="text" name="contact" id="contact" class="form-control" placeholder="Enter Contact no." value="<?php echo $response_data['contact']; ?>"/>
                                </div>
								</div>
                            </div>
							</div>
						<!--------------------------------------------------->
						<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group">
                                     <label for="Articlecontent">Location</label>
                                    <div>
                                    <input style="color:#2d2a3b;" type="text" name="location" id="location" class="form-control" placeholder="Enter Location" value="<?php echo $response_data['location']; ?>"/>
                                    </div>
                                    </div>
								</div>
							 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                <label for="Articlecontent">Favourite Food</label>
                                <div><textarea style="color:#2d2a3b;"class="form-control" rows="1" id="food" cols="3" name="food" placeholder="Enter Favourite Food"><?php echo $response_data['food']; ?></textarea></div>
                                </div>
                            </div>
						</div>
					    <!--------------------------------------------------->
						<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group">
                                <label for="Articlecontent">Favourite Holiday/Place</label>
                                <div><textarea style="color:#2d2a3b;"  class="form-control" rows="1" id="hoiday" cols="3" name="holiday" placeholder="Enter Favourite Holiday/Place"><?php echo $response_data['holiday']; ?></textarea></div>
                                </div>
								</div>
							 <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                 <div class="form-group">
                                <label for="Articlecontent">Personal Interest/Hobbies</label>
                                <div><textarea style="color:#2d2a3b;" class="form-control" rows="1" id="hobby" cols="3" name="hobby" placeholder="Enter Personal Interest/Hobbies"><?php echo $response_data['hobby']; ?></textarea></div>
                                </div>
                            </div>
						</div>
						<!--------------------------------------------------->
							</div>  
							
							
							
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
							
							<div class="row">
                              <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                        <center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save" id="getData" onclick="return Validateonboard();"/></center>
                              </div>
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