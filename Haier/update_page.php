	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
	<!-------------------------------SCRIPT END FROM HERE   --------->	
	<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this HR Policy?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
function ValidateHRPolicy()
{
    var pagetitle = document.form1.pagetitle;
    	
    if (pagetitle.value == "")
    {
        window.alert("Please Enter Title.");
        pagetitle.focus();
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
				<h4><strong>Update HR Policy<strong></h4><hr>
				<?php 
				if(isset($_SESSION['msg']))
				{
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
	require_once('Class_Library/class_getPages.php');
	$page = $_GET['pageid'];
	$pageobj = new GetPages();
	$result1 = $pageobj->getSinglePage($page);
	$result = json_decode($result1, true);
	//echo "<pre>";
	//print_r($result);
	
        $path =  $result[0]['fileName'];
        $cid =  $result[0]['clientId'];
	?>
<!------------------------------------------message portal start from here------------------------------------------------>	
 <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" name="form1" method="post" enctype="multipart/form-data" action="Link_Library/link_update_page.php" onsubmit="return check();">
			<input type="hidden" name = "client" value="<?php echo $cid; ?>">
                           <input type="hidden" name="pageid" value="<?php echo $_GET['pageid'];?>" />
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<div class="form-group">
						<label for="Articlecontent"> Title</label>
						<input type="text" name="pagetitle" class="form-control" value="<?php echo htmlspecialchars($result[0]['pageTitle'],ENT_QUOTES); ?>">
					</div>
					</div>
<!----
					<div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6 myImageRight">
						<label for="Articlecontent">Select Image</label>
						<script type="text/javascript">
function showimagepreview(input) {
if (input.files && input.files[0]) {
var filerdr = new FileReader();
filerdr.onload = function(e) {
$('#imgprvw1').attr('src', e.target.result);
$('.post_img').attr('src', e.target.result);
}
filerdr.readAsDataURL(input.files[0]);
}
}
</script>
<img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px; float:right; height:110px; width:200px;border:1px solid #f1f1f0;" 
src='<?php echo $result[0]['imageName']; ?>' onerror='this.src="images/u.png"'/>
<div>
<input type="file" name="pageimage" id="filUpload" onchange="showimagepreview(this)" />
</div>
					</div>
---->					
					
					
					</div>
					
					<script src="http://cdn.ckeditor.com/4.5.7/standard-all/ckeditor.js"></script>
					 <div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					   <div class="form-group">
						<label for="Articlecontent">Content</label>
						<div>
						<textarea cols="80" id="editor1" name="pagecontent" rows="10">	
						<?php echo file_get_contents($path); ?>
	                                         </textarea>
						</div>
					</div>
					<script>
		CKEDITOR.replace( 'editor1' );  
	</script>   <!--- this is for ckeditor   ----->
			   
					   
                                  <!--       <div class="form-group col-sm-12">
                                         
                                         <label for="exampleInputPassword1">Select User</label>
                                          <div>
                                             <div class="radio3 radio-check radio-success radio-inline">
                                            <input type="radio" id="radio5" name="selecteduser" value="Male">
                                            <label for="radio5">
                                              Send Post to All Users
                                            </label>
                                          </div>
                                          <div class="radio3 radio-check radio-warning radio-inline">
                                            <input type="radio" id="radio6" name="selecteduser" value="Female">
                                            <label for="radio6">
                                             Send Post to Selected users
                                            </label>
                                          </div>
                                        </div>
                                         
                                        </div>
      <!---------------------this script for show textbox on select radio button----------------------                       
	<script type="text/javascript">
    $(function () {
     $("#show_textbox").hide();
        $("input[name='selecteduser']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#show_textbox").show();
            } else {
                $("#show_textbox").hide();
            }
        });
    });
</script>				
	  <!------------Abobe script for show textbox on select radio button----------------------
	                               <div id ="show_textbox">
	    				<div class="form-group col-sm-6" >
					<input type="text" name ="selecteduser" id="selecteduser" class="form-control" placeholder=" Choose group" />					</div>
					
					<div id="selecteditems" class="form-group col-sm-6" >
					data is here.............
					
					</div>
					
					<div id="allitems" class="form-group col-sm-12" >
					show all data here.......
					</div>
					<textarea id ="allids" style="display:none;" height="660"></textarea>
                                         <textarea id ="selectedids" name="selected_user" style="display:none;" ></textarea>
					</div> -->
					<div class="form-group col-sm-12">
						<center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save" id="getData" onclick="return ValidateHRPolicy();"/></center>
					</div>
					
				</div>
				</form>
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
	<!---	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		
		<div class="publication">
		<p id="publication_heading">PUBLICATION</p><hr>
		
		<p class="publication_subheading">PUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Immediately </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs" id="showshortcontent">ON</button>
					<button class="btn btn-primary active btn-xs"id="hideshortcontent">OFF</button>
					
				</div>
			
			</div>
		</div>
			<script>
$(document).ready(function(){
    $("#hideshortcontent").click(function(){
        $("#shortpublicationdivcontent").hide();
    });
    $("#showshortcontent").click(function(){
        $("#shortpublicationdivcontent").show();
    });
});
</script>
				<div id="shortpublicationdivcontent">
				<input type="date"/>
				<input type="time"/>
				
		</div>
		
		<br>
		
		<p class="publication_subheading">UNPUBLICATION TIME </p>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Not Scheduled </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs"id="showshortcontent1">ON</button>
					<button class="btn btn-primary active btn-xs"id="hideshortcontent1">OFF</button>
					
				</div>
				
			</div>
		</div>
		<script>
$(document).ready(function(){
    $("#hideshortcontent1").click(function(){
        $("#shortUnpublicationdivcontent").hide();
    });
    $("#showshortcontent1").click(function(){
        $("#shortUnpublicationdivcontent").show();
    });
});
</script>
				<div id="shortUnpublicationdivcontent" >
				<input type="date"/>
				<input type="time"/>
				
		</div>
		</div>
		
		<br>
		
<div class="publication"><p id="publication_heading">Options</p><hr>
		
			

		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				<p class="publication_leftcontent">Acknowledging </p>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
				
				<div class="btn-group btn-toggle"> 
					<button class="btn btn-default btn-xs">ON</button>
					<button class="btn btn-primary active btn-xs">OFF</button>
				</div>
			</div>
		</div>
		
		
		</div>
		

		</div>--->
		</div>
		</div>			
		
</div>
                   
            </div>
				<?php include 'footer.php';?>