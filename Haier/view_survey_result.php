<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
require_once('Class_Library/class_HappinesQuestion.php');
$obj = new HappinessQuestion();

$qid = $_GET['qid'];
$clientid = $_GET['clientid'];
$sid = $_GET['sid'];
$result = $obj->SurveyquestionDetails($sid, $clientid);
$getcat = json_decode($result, true);
//echo'<pre>';print_r($getcat);die;

$ques1 = $obj->getSurveyquestion($qid, $clientid, $sid);
//echo $ques1;
$ques = json_decode($ques1, true);

$sad = -5;
$happy = 5;
$normal = 0;
$ehappy = 10;
$happy_avg = 0;
$sadcount = $obj->getSurveyCount($sid, $qid, $sad);
$happycount = $obj->getSurveyCount($sid, $qid, $happy);
$normalcount = $obj->getSurveyCount($sid, $qid, $normal);
$ehappycount = $obj->getSurveyCount($sid, $qid, $ehappy);

$happy_avg1 = $sadcount['surveycount'] * $sad;
$happy_avg2 = $normalcount['surveycount'] * $normal;
$happy_avg3 = $happycount['surveycount'] * $happy;
$happy_avg4 = $ehappycount['surveycount'] * $ehappy;

$totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
?>
<!--------------------------------------------------------- start from here-------------------------------->

<div class="container-fluid">
    <div class="side-body">
        <input type="hidden" name="qid" id ="qid" value = "<?php echo $qid; ?>">
        <input type="hidden" name="qid" id ="clientid" value = "<?php echo $clientid; ?>">
        <input type="hidden" name="qid" id ="sid" value = "<?php echo $sid; ?>">
        <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
            <div class="row">
                <div class="col-xs-10 col-md-offset-1">
                    <div class="card">
                        <div class="card-header">

                            <div class="card-title">
                                <div class="title"> <span style="font-size:17px;font-weight:bold;"><?php echo $getcat['posts'][0]['surveyTitle']; ?></span></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <div class='col-md-12 col-xs-12 col-sm-12 col-lg-12' style="font-size:16px;">
                                            <p><?php echo $ques['question']; ?></p>
                                            <p class="respondents"><?php echo "No. of Respondents : " . $totalRespondent; ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div >
                                <!--<p style="font-size:16px;font-weight:500;font-weight:bold;">Survey Answer</p>-->

                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="col-md-10" id="anlyticgraph">

                                        <div id="chart-container"></div>


                                    </div>

                                </div>

                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/analytic/questionresult.js"></script>
<script src="js/analytic/fusioncharts.charts.js"></script>
<script src="js/analytic/fusioncharts.js"></script>
<script type="text/javascript">
    var quid = $("#qid").val(); //"Android";
    var sid = $("#sid").val();//"2016-12-30"; 
    var clientid = $("#clientid").val();
    var respondentsCount = <?php echo $totalRespondent; ?>;
    showGraphFunction1(quid, sid, clientid, respondentsCount);

</script>
<?php include 'footer.php'; ?><?php
