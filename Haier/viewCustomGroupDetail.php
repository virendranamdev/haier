<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
<script type="text/javascript" src="js/analytic/analyticLogingraph.js"></script>
<?php require_once('Class_Library/class_get_group.php'); 
$cid = $_SESSION['client_id'];
$obj = new Group();

$groupid = $_GET['groupid'];

$result = $obj->getCustomGroupDetails($groupid,$cid);

$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);


$count  = count($val['posts']);

/**************** for export data **************/
$expd = array(); 
for ($i = 0; $i < $count; $i++) {
$expdata['sn'] = $val['posts'][$i]['sn'] = $i+1 ; 
$expdata['name'] = $val['posts'][$i]['empname']; 
$expdata['employeeid'] = $val['posts'][$i]['empcode'];
$expdata['emailId'] = $val['posts'][$i]['emailId'];
$expdata['contact'] = $val['posts'][$i]['contact'];
$expdata['department'] = $val['posts'][$i]['department'];
$expdata['designation'] = $val['posts'][$i]['designation'];
$expdata['branch'] = $val['posts'][$i]['branch'];
array_push($expd ,$expdata );
}
$exprecord = json_encode($expd);
//print_r($expd);
/**************** / for export data ************/
?>

	<!----------------------------------------------------------->
	<!--------------------------------------------------------->
<script>
function tableexport() {
var exdata = document.getElementById('exportdata').value;
var exporttitle = document.getElementById('exporttitle').value;
var jsonData = JSON.parse(exdata);
//alert(jsonData.length);
                    if (jsonData.length > 0)
                    {
						if (confirm('Are You Sure, You want to Export Record?')) {
                        JSONToCSVConvertor(exdata, exporttitle, true);
						return true;
						}
						else
						{
							return false;
						}
                    }
					else
					{
					alert("No Record Available");	
					}
					
}
</script>
	
			<div class="container-fluid">
			
	              <div class="side-body">
                   <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"><strong><?php echo $val['posts'][0]['groupName'];?></strong></div>
									</div>
									
									<textarea name="exportdata" id="exportdata" style="display:none;"><?php echo $exprecord; ?></textarea>
									<textarea name="exporttitle" id="exporttitle" style="display:none;"><?php echo $val['posts'][0]['groupName']; ?></textarea>
									
									<button type="button" class="btn btn-primary " onclick="return tableexport();" style="float:right;">Export</button>
                                </div>
								
								<div class="row" style="margin-top:20px;margin-left:10px;">
								<div class="col-xs-8"><b>About Group :   </b>
								<?php echo $val['posts'][0]['groupDescription']; ?> 
								</div>
								</div>
  
                                <div class="card-body">
								<div style="overflow-x:auto !important; width:100%">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead>
                                            <tr >
                                                <th>Name</th>
                                                <th>Employee Id</th>
                                                <th>Email Id</th>
												<th>Contact</th>
                                                <th>Department</th>
                                                <th>Designation</th>
												<th>Branch</th>
											</tr>
                                        </thead>
                                       <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Employee Code</th>
                                                <th>Email Id </th>
												<th>Contact</th>
                                                <th> Department </th>
                                                <th>Designation</th>
												<th>Branch</th>
											</tr>
                                        </tfoot> 
                                        <tbody>
                                     <?php
                                     
                                     for($i=0; $i<$count; $i++)
                                              {
												  
                                    

                                     ?>       	
					                    <tr>
                                              
                                                <td class="padding_right_px"><?php echo $val['posts'][$i]['empname']; ?></td>
                                                
                                                 <td class="padding_right_px"><?php echo $val['posts'][$i]['empcode']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val['posts'][$i]['emailId']; ?></td>
												 <td class="padding_right_px"><?php echo $val['posts'][$i]['contact']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val['posts'][$i]['department']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val['posts'][$i]['designation']; ?></td>
												  <td class="padding_right_px"><?php echo $val['posts'][$i]['branch']; ?></td>
                                        </tr>
                                      
                                        <?php
                                        }
                                        ?>
                                          </tbody>
                                    </table>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
				<?php include 'footer.php';?>