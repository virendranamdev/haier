<?php 
error_reporting(E_ALL);
ini_set("display_errors",1);
include 'navigationbar.php';
include 'leftSideSlide.php'; 
include('Class_Library/class_welcome_analytic.php');

@session_start();
$cid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
?>

<div class="container-fluid">

    <div class="side-body padding-top">
		<form class="form ">
 <div class="TopManagmentForm">
 <div class="row ">
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><input type="file"class="form-control"></div>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><input type="text"class="form-control"placeholder="Enter Name"></div>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><input type="text"class="form-control"placeholder="Enter Designation"></div>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><button type="button"class="btn btn-primary">Submit</button> &nbsp;&nbsp;
	</div>
</div>
</div>
 <div class="row ">
 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
 <button type="button"class="btn btn-primary" id="AddTopManagementData"> + Add New</button>
 </div>
 </div>
 
 
				
				
 </form>
    </div>
</div>

<script>
$(document).ready(function(){
    $("#AddTopManagementData").click(function(){
	
        $(".TopManagmentForm").append('<div class="row"><div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><input type="file"class="form-control"></div>'
		+'<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><input type="text"class="form-control"placeholder="Enter Name"></div>'
	+'<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><input type="text"class="form-control"placeholder="Enter Designation"></div>'
	+'<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3"><button type="button"class="btn btn-primary">Submit</button> '	
	+'</div></div>'
	);
    });
  
});
</script>
<?php include 'footer.php'; ?>