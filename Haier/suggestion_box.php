<?php
session_start();
include 'navigationbar.php';
include 'leftSideSlide.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('Class_Library/class_complaints.php');
$object = new Complaint();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getSuggestion($clientid);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$count = count($val);
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
                                <div class="title"><strong>ALL Ideas</strong></div>

                            </div>

                        </div>


                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                <thead>
                                    <tr>
                                       
                                        <th>Suggested By</th>
                                       
                                        <th>Category</th>
                                        <th>Suggestion</th>
                                         <th>Image</th>
                                        <th>Date</th>
                                         <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                       
                                        <th>Suggested By</th>
                                        
                                        <th>Category</th>
                                        <th>Suggestion</th>
                                         <th>Image</th>
                                        <th>Date</th>
                                         <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $count; $i++) {
                                        if($val[$i]['status'] == 1)
                                        {
                                            $status = "Pending";
                                        }
                                        else if($val[$i]['status'] == 2)
                                        {
                                            $status = "Accepted";
                                        }
 else {$status = "Rejected";}

                                        $imgpath = ($val[$i]['suggestionImage'] == "") ? "" : $path . $val[$i]['suggestionImage'];
                                        ?>       	
                                        <tr>
                                           

                                            <td class="padding_right_px"><?php echo $val[$i]['firstName'] . " " . $val[$i]['lastName']; ?></td> 

                                          

                                            <td style="width:15% !important;"> <?php
                                                $cont = $val[$i]['suggestionArea'];
                                                $words = explode(" ", $cont);
                                                $word = implode(" ", array_splice($words, 0, 25));
                                                echo $word;
                                                //echo $val[$i]['post_content']; 
                                                ?></td>

                                            <td>  <?php
                                                $string = strip_tags($val[$i]['content']);

                                                if (strlen($string) > 50) {
                                                    $stringCut = substr($string, 0, 50);

                                                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . "....<a style='color:#00a4fd;margin-left:30px !important' href='full_view_suggestion.php?idpost=" . $val[$i]['sugestionId'] . "'></a>";
                                                }
                                                echo $string;
                                                ?>
                                            </td>
 <td>

                                                <img src="<?php echo $imgpath; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/board.png"'/> </td>

                                            <td class="padding_right_px"><?php echo $val[$i]['date_of_sugestion']; ?></td>
                                             <td class="padding_right_px"><?php echo $status; ?></td>
                                            <td><a target="_blank" href="full_view_suggestion.php?idpost=<?php echo $val[$i]['sugestionId']; ?>" style="color:#00a4fd;margin-left:29px !important;">View</a></td>


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
<?php include 'footer.php'; ?>