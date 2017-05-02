<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>	                             
<?php
require_once('Class_Library/class_MyLearning.php');

$object = new MyLearning();
$clientid = $_SESSION['client_id'];

$result = $object->getMyLearning($clientid);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$path = SITE;
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
                                <div class="title"><strong>Learning Details</strong></div>
                            </div>
                            <div style="float:left; margin-top:13px; font-size:20px;"> 
                                <a href="create_mylearning.php">
                                    <button type="button" class="btn btn-primary btn-sm">Create New Learning</button>
                                </a>
                            </div>

                        </div>

                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Learning Images</th>
                                        <th>Learning Name</th>

                                        <th>Created Date</th>
                                        <th>Status</th> <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//echo "<pre>";
//print_r($val);
//echo count($val);
                                    for ($i = 0; $i < count($val); $i++) {
                                        $trainingname = $val[$i]['learningName'];
                                        $learningid = $val[$i]['learningId'];
                                        $trainingdescription = $val[$i]['trainingDescription'];
                                        $createddate = $val[$i]['createdDate'];
                                        $status = $val[$i]['status'];
                                        if ($status == 1) {
                                            $statusres = "Active";
                                        } else {
                                            $statusres = "Inactive";
                                        }
                                        ?>
                                        <tr>
                                            <td>

                                                <img src="<?php echo $path . $val[$i]['learningImg']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/>
                                            </td>
                                            <td style="text-align:justify; padding-left:20px;"><?php echo $trainingname; ?></td>

                                            <td style="text-align:justify; padding-left:20px;"><?php echo $createddate; ?></td>
                                            <td style="text-align:justify; padding-left:20px;"><?php echo $statusres; ?> &nbsp;&nbsp;<a href="xyz.php"></a>
                                            </td>
                                            <td> <a href="viewLearningFile.php?lid=<?php echo $learningid; ?>" style="color:#00a4fd;margin-left:29px !important;" target="_blank">View File</a> </td>
    <?php
}
?>
                                    </tr>
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