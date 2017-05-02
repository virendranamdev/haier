<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>	                             
<?php
require_once('Class_Library/class_MyLearning.php');

$object = new MyLearning();
$clientid = $_SESSION['client_id'];

$learningid = $_GET['lid'];


$result = $object->getMyLearningFile($learningid);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$path = SITE;

if(isset($_GET['fid']))
{
    $fid = $_GET['fid'];
    $lid = $_GET['lid1'];
    $result = $object->deleteMyLearningFile($lid,$fid);
    $result1 = json_decode($result,true);
   // print_r($result1);
    if($result1['success'] == 1)
    {
        echo "<script>alert(".$result['message'].")</script>";
      echo "<script>window.location='viewLearningFile.php?lid=".$lid."'</script"; 
//                
    }
}
?>

<div class="container-fluid">
    <div class="addusertest">

    </div>
    <div class="side-body">
        <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-title">
                                <div class="title"><strong>My Learning File Details</strong></div>
                            </div>
<!--                            <div style="float:left; margin-top:13px; font-size:20px;"> 
                                <a href="#">
                                    <button type="button" class="btn btn-primary btn-sm">Add More files</button>
                                </a>
                            </div>-->
                        </div>

                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>File Name</th>
                                        <th>File Path</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>
                                <?php
                                for ($i = 0; $i < count($val); $i++) {
                                    $fid = $val[$i]['fileId'];
                                    $filename = $val[$i]['fileName'];
                                    $filepath = $val[$i]['filepath'];
                                    $status1 = $val[$i]['status'];
                                    $date = $val[$i]['createdDate'];
                                    $status = ($status1 == 1)?'Active':'InActive';
                                    ?>
                                    <tr>
                                        <td style="text-align:justify; padding-left:20px;"><?php echo $filename; ?></td>
                                        <td style="text-align:justify; padding-left:20px;"> <a href="<?php echo $path.$filepath; ?>">Download File</a></td>
                                        <td style="text-align:justify; padding-left:20px;"><?php echo $status; ?></td>
                                        <td style="text-align:justify; padding-left:20px;"><?php echo $date; ?></td>
                                        <td style="text-align:justify; padding-left:20px;">
                                            <a  href="viewLearningFile.php?lid1=<?php echo $val[$i]['learningId']; ?>&fid=<?php echo $fid; ?>" style="color:#00a4fd;margin-left:29px !important;">
                                       <button onClick="javascript:if(confirm('Are you sure want to Delete this file?')){return true;} else{return false}"style="background-color:#fff;" class="btn btn-sm" >Delete File
                                            </button>
                                            </a>
                                            </</td>

                                    </tr>
                                    <?php
                                }
                                ?>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>