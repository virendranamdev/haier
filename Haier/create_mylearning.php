<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="angularjs/poll_option.js"></script>

<link rel="stylesheet" href="css/thought.css" />
<link rel="stylesheet" href="css/createpoll.css" />
<script src="js/display_group.js"></script>


<script>

    $(document).ready(function () {

        $("#preview_poll").click(function () {

            $("#poll_div").css({"display": "block"});
            var pquestion = $("#content").val();
            $(".pollquestion").html(pquestion);
            fetchvalues();
        });
    });
    function check() {
        if (confirm('Are You Sure, You want to publish this Survey?')) {
            return true;
        } else {
            return false;
        }
    }

    function fetchvalues()
    {

        var val = $("#option").val();
        for (i = 1; i <= val; i++)
        {

            var number = document.getElementById("text" + i).value;
            $(".polloptions").append('<div >' + number + '</div>');
        }
    }

</script>

<script>
    $(document).ready(function () {
        $(".closeThoughtPopoUpBtn").click(function () {
            $("#poll_div").hide();
        });
    });</script>

<div id="poll_div" >

    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

        </div>
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <button type="button" class="btn btn-gray closeThoughtPopoUpBtn closebtn" style="margin-left: 183px;
                    }">X</button><br><br>
            <div class="tab-content mytabContent">
                <div id="AndoidPriviewTab" class="tab-pane fade in active">  
                    <div class="background_Android_Image" style="margin-left:-149px;">
                        <img src="images/mobile.jpg"class="img img-responsive androidImage"/>
                    </div>
                    <div class="androidContentTab">
                        <div class="wholeAndroidContentHolder">

                            <div class="pollquestion"></div><br><br>
                            <div class="polloptions"></div>


                        </div>
                    </div>
                </div>
                <div id="IphonePriviewTab" class="tab-pane fade">
                    <div class="background_iphone_Image">
                        <img src="images/i6.png"class="img img-responsive IphoneImage"/>
                    </div>
                    <div class="iphoneContentTab">
                        <div class="wholeIOSContentHolder">


                            <div class="pollquestion"></div><br><br>
                            <div class="polloptions"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <div id="pollquestion"></div>
    <div id="polloptions"></div>-->
</div>
<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:-5px;">
        <div class="bs-example">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3><strong>My Learning</strong></h3><hr>
                </div>

            </div>
            <form role="form" action="Link_Library/link_create_mylearning.php" method="post" enctype="multipart/form-data" onsubmit="return check();">
            <div class="row">
 
                    <input style="color:#2d2a3b;" type="hidden" name = "flag" value="4">
                    <input style="color:#2d2a3b;" type="hidden" name = "device" value="d2">
                    <input style="color:#2d2a3b;" type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                    <input style="color:#2d2a3b;" type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">

                        <!--------------- form picture post start here ------------------------------------------>		
                        <div class="row">
                         
                              

                                    <div class="form-group col-md-12">
                                        <label for="Articlecontent">Learning Title</label>
                                        <input style="color:#2d2a3b;" required type="text" class="form-control" name="learningtitle" id="learningtitle"/> 
                                    </div>
                                   
                                                <div class="form-group col-md-12">
                                    <label for="Articlecontent">UPLOAD IMAGE (max upload size: 2 MB resolution:640*362)</label><br>



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
													   alert("Height and Width must not exceed 1000px.");
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
                                    <img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px; width:200px"/>
                                    <div>
                                        <input type="file" name="mylearningimage" id="filUpload" accept="image/*" onchange="showimagepreview(this)" multiple="true" />                                    </div>

                                </div>
                                 
                                 
                                    <br>
                                   
                                
                                    <div ng-controller="ctrl" class="form-group col-md-12">
                                        <div class="form-group">
                                            <label for="Articlecontent">Please Enter no. of file (required only numbers)</label>
                                            <input min="0" max="5" style="color:#2d2a3b;" ng-model="totalNumberOfOptions" type="number" ng-change="makeArray()" class="form-control" name="option" id="option" /> 
                                        </div>
                                        <br>  
                                        <br>
                                        <div  ng-show="totalNumberOfOptions > 0" ng-repeat="ithData in allOptions"> 

                                            <div class="form-group col-md-1">  {{$index + 1}}
                                            </div>
                                            <div class="form-group col-md-11">

                                                <input style="color:#2d2a3b;" type="text" name = "filetitle{{$index + 1}}" id = "filetitle{{$index + 1}}"   class="form-control" placeholder="Write File Name">
                                                       <input style="color:#2d2a3b;" type="file" id = "file{{$index + 1}}"  name = "filename{{$index + 1}}" class="form-control" accept="application/pdf" placeholder="Select pdf File">
                                            </div>

                                            <br/>
                                        </div>

                                    </div>   
                              

                                <br>
                                <hr/>

                                <!-------------- select group ---------------------------->

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

                                <!-------------------------------------------------------->

                                <!------------Abobe script for show textbox on select radio button---------------------->

                                <div id ="everything" ng-show=" content == 'Selected'">
                                    <input style="color:#2d2a3b;" type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                    <input style="color:#2d2a3b;" type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                    <div class="col-sm-1"style="width:3.333333%;"></div>	  <div class="form-group col-sm-5" id="alldatadiv" >
                                        <center><p class="groupPicturealldataheading">All Group</p> </center>
                                        <div id="allitems" >
                                        </div>

                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div id="selecteditems1" class="form-group col-sm-5" style="border:1px solid #dddddd; width:44.666667%;" >
                                        <center><p class="groupselecteddataheading">Selected Group</p> </center>  
                                        <p id="selecteditems"></p>


                                    </div>


                                    <textarea id ="allids" name="all_user" ng-show = false height="660"></textarea>
                                    <textarea id ="selectedids" name="selected_user" ng-show = false ></textarea>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!----------------------------------- form picture post end here ------------------------------------------>		


                    <div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv" style="margin-top: 40px;">
                        <!-- <div class="publication">
                             
 
                             <div class="publication">
                                 <p id="publication_heading">PUBLICATION</p><hr>
 
                                 <p class="publication_subheading">PUBLISH DATE </p>
                                 <div class="row">
                                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="rightpublicationdiv6">
                                         <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Publish Date.. Enable/Disable In Case of Enable(On) Add publish Date of respective post if it is off than today's date is Publish Date ">Immediately ?</p>
                                     </div>
                                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
 
                                         <div class="btn-group btn-toggle"> 
                                             <button type = "button" class="btn btn-default btn-xs" id="showshortcontent">ON</button>
                                             <button type = "button" class="btn btn-primary active btn-xs"id="hideshortcontent">OFF</button>
 
                                         </div>
 
                                       </div>
                                 </div>
                                 <script>
                                     $(document).ready(function () {
                                         $("#hideshortcontent").click(function () {
                                             $("#shortpublicationdivcontent").hide();
                                         });
                                         $("#showshortcontent").click(function () {
                                             $("#shortpublicationdivcontent").show();
                                         });
                                     });</script>
                                 <div id="shortpublicationdivcontent">
 
                                     <input  style="color:#2d2a3b;" type="date" class="form-control" placeholder="YYYY-MM-DD"  name="publish_date1"/><br>
 
                                 </div>
 
                                 <br>
 
                                 <p class="publication_subheading">EXPIRY DATE </p>
                                 <div class="row">
                                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                         <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Expeiry Date.. Enable/Disable In Case of Enable(On) Add Expeiry Date of respective post if it is off than expiry date is 1 month later from current date ">Not Scheduled ?</p>
                                     </div>
                                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
 
                                         <div class="btn-group btn-toggle"> 
                                             <button type = "button" class="btn btn-default btn-xs"id="showshortcontent1">ON</button>
                                             <button type = "button" class="btn btn-primary active btn-xs"id="hideshortcontent1">OFF</button>
 
                                         </div>
 
                                     </div>
                                 </div>
                                 <script>
                                     $(document).ready(function () {
                                         $("#hideshortcontent1").click(function () {
                                             $("#shortUnpublicationdivcontent").hide();
                                         });
                                         $("#showshortcontent1").click(function () {
                                             $("#shortUnpublicationdivcontent").show();
                                         });
                                     });</script>
                                 <div id="shortUnpublicationdivcontent" >
                                     <input style="color:#2d2a3b;" type="date" class="form-control" style="width: 100% !important;" name="publish_date2" placeholder= "YYYY-MM-DD" /><br>
 
                                 </div>
                             </div>
 
                         </div>-->

<!--                        <div class="publication"><p id="publication_heading">Notification</p><hr>



                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "id="rightpublicationdiv6 ">
                                    <p class="publication_leftcontent "data-toggle="tooltip" data-placement="left" title="Publish Date.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                    <div class="checkbox"style="margin-top:-10px;">
                                        <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>

                                </div>

                            </div> 


                        </div>-->
                    </div>


                    <!-------------------------------------------------------------------->	


                    <div class="form-group col-sm-12">
                        <center>
                            <!--
        <input type="button" name ="preview_poll" id="preview_poll" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Preview" />
                            -->
                            <input type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish" id="getData"/></center>
                    </div>
                </form>			



            </div>
        </div>
    </div>
    <!--this script is use for tooltip genrate-->     
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <!--tooltip script end here-->
</div>
    <?php include 'footer.php'; ?>