<?php
include 'navigationbar.php';
include 'leftSideSlide.php'; 
$clientid = $_SESSION['client_id'];
?>
<script type="text/javascript">
    $(document).ready(function()
    {
		  
		//alert("hello");
        
		$("button").click(function(){
          var device = $("#device").val(); //"Android";
		  var fromdte = $("#formdate").val();//"2016-12-01";
		  var enddte = $("#enddate").val();//"2016-12-30"; 
		  var clientid = $("#clientid").val();
			//alert("hello1");
		  var postData = 
                {
                    "start_date":fromdte,
                    "end_date":enddte,
                    "device":device,
                    "client":clientid
                }
				var dataString = JSON.stringify(postData);
				//alert(dataString);
               $.ajax({
                type: "POST",
				//dataType: "json",
				//contentType: "application/json; charset=utf-8",
                url: "<?php echo SITE; ?>login_analytic_installapp.php",
				data: {"mydata" : dataString},  
                success: function(response) {
				var resdata = response;
				//alert(response);
				if(response.length !== 0)
				{
					
				var jsonData = JSON.parse(resdata);
				$('#myTable tbody').remove();
				for (var i = 0; i < resdata.length; i++) {
					
					var newRow = '<tbody><tr><td>' + jsonData[i].firstName + '</td><td>' + jsonData[i].department + '</td><td>'+ jsonData[i].location +'</td><td>' + jsonData[i].deviceName + '</td><td>' + jsonData[i].date_entry_time +'</td></tr><tbody>';
					$('#myTable').append(newRow);
					
				}
				}						
					
				else
					
				{
				var newRow = '<tbody><tr><td>No Record Found</td></tr><tbody>';
				$('#tBody').html('<tr><td>No Record Found</td></tr>');
				}
								 
					 

            },
            error: function(e){
				alert(e);
                console.log(e.message);
            }
            });
   });
});
</script>
<script>
function check(){
	var fromdate = document.getElementById("formdate");
	var enddate = document.getElementById("enddate");
	if(fromdate.value == 0)
	{
		alert('Please Select Date In Date From Field')
		fromdate.focus();
		return false;
	}
	if(enddate.value == 0)
	{
		alert('Please Select Date In Date To Field')
		enddate.focus();
		return false;
	}
	return true;
}
</script>
 <div class="side-body">
<div class="container-fluid" style="margin-top:15px;border:1px solid #cdcdcd;margin-left:0px;">
<div class="row" >
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <h3 style="margin-left:80px;"><strong>Analytic</strong></h3>
	<hr>
    </div>

  </div>

	<div class="row" style="margin-top:10px;">
	<form action="" method="POST">
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
	<input type="hidden" name="clientid" id="clientid" value="<?php echo $clientid; ?> ">
		<div class="form-group">
			<label for="sel1" style="margin-left:80px;">Device :</label>
				<select style="color:#2d2a3b;" name="device" class="form-control" id="device">
					<option value ="All">All</option>
					<option value ="2">Android</option>
					<option value ="3">iphone</option>
    
				</select>

		</div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="form-group">
			<label for="pwd">Date From :</label>
				<input type="date" name="formdate" id="formdate" class="form-control" style="color:#2d2a3b;">
		</div>
		</div>
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="form-group">
			<label for="pwd">Date To :</label>
				<input type="date" name="enddate" id="enddate" class="form-control" style="color:#2d2a3b;">
		</div>
		</div>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
		<div class="form-group">
			<label for="pwd"></label>
			<button type="button" class="form-control" onclick="return check();">Submit</button>
				<!--<input type="button" name="submit" class="form-control" style="color:#2d2a3b;">-->
		</div>
		</div>
		</form>

		
			<div class="">
			<!---<div class="addusertest">
			
	</div>--->
	              <div class="side-body">
                    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
						  	    <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Department</th>
                                                <th>Location</th>
                                                <th>Device</th>
                                                <th>Login Date</th> 
                                               
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Employee Name</th>
                                                <th>Department</th>
                                                <th>Location</th>
                                                <th>Device</th>
                                                <th>Login Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="tBody">
                       
                                          </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
			
	
</div>
</div>
</div>
				<?php include 'footer.php';?>	
	

