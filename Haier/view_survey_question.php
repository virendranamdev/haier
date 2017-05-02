<?php 
include 'navigationbar.php';
include 'leftSideSlide.php';
 ?>
<script src="js/analytic/analyticLogingraph.js"></script>
<?php
require_once('Class_Library/class_HappinesQuestion.php');
require_once('Class_Library/class_get_useruniqueid.php');
require_once("Class_Library/Api_Class/class_user_directory.php");
require_once("Class_Library/Api_Class/class_contact_directory.php");
$gt = new UserUniqueId();
$poll_obj = new HappinessQuestion();
$location_obj = new UserDirectory();
$company_obj = new ContactLocation();

//$clientid = $_SESSION['client_id'];
//$user_uniqueid = $_SESSION['user_unique_id'];
//$user_type = $_SESSION['user_type'];

if (isset($_GET['sid']) && isset($_GET['cid'])) {
    $sid = $_GET['sid'];
    $cid = $_GET['cid'];
	
	$location = $location_obj->getLocationDepartment($cid);
	/*echo "<pre>";
	print_r($location);
	echo "</pre>";*/
	
    $result = $poll_obj->SurveyquestionDetails($sid, $cid);
    $getcat = json_decode($result, true);
	/*echo "<pre>";
	print_r($getcat);
	echo "</pre>";*/

    $value2 = $getcat['posts'];
    $count2 = count($value2);
    //$happycount = count($getcat['posts'][0]['happycount']);
	
	$commentResult = $poll_obj->SurveycommentDetails($sid, $cid);
    $getcomment = json_decode($commentResult, true);
	/*echo "<pre>";
	print_r($getcomment);
	echo "</pre>";*/
	
    $commentData = $getcomment['posts'];
    $commentCount = count($commentData);
	
}
if (isset($_GET['ques_id']) && isset($_GET['status'])) {
    $idpoll = $_GET['ques_id'];
    $status = $_GET['status'];

    if ($status == 'Live') {
        $status1 = 0;
    }
    $result = $poll_obj->updateSurveyStatus($idpoll, $status1);
    $output = json_decode($result, true);

    $value = $output['success'];
    $message = $output['message'];

    if ($value == 1) {
        echo "<script>alert('$message')</script>";
        echo "<script>window.location='view_survey_question.php'</script>";
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
                <!--------------------------------------------------------------------->  
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3><b><?php echo $getcat['posts'][0]['surveyTitle']; ?></b></h3><hr>
                </div>
				</div>
				<!---------------------------------------------------------------------> 
				<!----------------------------------------------------------->
				<div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div style="float:right;">
                        <form class="form-inline">
                            <div class="form-group">
							
                                <label for="email">Start Date :</label>
                                <?php echo $getcat['posts'][0]['startDate']; ?>
                            </div>
                            &emsp;
                            <div class="form-group">
                                <label for="pwd"> Expiry Date :</label>
                                <?php echo $getcat['posts'][0]['expiryDate']; ?>
                            </div>
                            &emsp;
                            <div class="form-group">
                                <?php
                                if ($getcat['posts'][0]['status'] == 1) {
                                    $st = "Live";
                                } else {
                                    $st = "Expire";
                                }
                                ?>
                                <label for="pwd"> Status :</label>
                                <?php echo $st; ?>
                            </div>
                            &emsp;
                            <div class="form-group">
                                <label class="respondentCount"></label>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
			<!-------------------------------------------------------------------->
			<!--------------------------------------------------------------------->
			
			<!------------------------- radio button ------------------------------->
			<br/><br/>
			<div class="row">
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="radio" name="graphradio" id="locationradio" checked> location
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="radio" name="graphradio" id="departmentradio" /> Department
			</div>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
			<input type="radio" name="graphradio" id="ageradio" /> Age
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			</div>
			</div>
			<br/>
			
			<!------------------------- / radio button ----------------------------->
			<div class="row">
						
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="locationdiv">
						 	
                            <label class="">Location</label>
                            <select id="locationSelector" multiple="" style="width:100%;">
                                <!--<option>Select Location</option>-->
                                <?php foreach ($location['location'] as $loc) { ?>
                                    <option value="<?php echo $loc['location']; ?>"><?php echo $loc['location']; ?></option>
                                <?php } ?>
                            </select>

                            &emsp;&emsp;&emsp;
                        </div>
						
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="departmentdiv">
						
						    <label class=""> Department</label>
                            <select id="departmentSelector" multiple="" style="width:100%;">
                                <!--                        <option value="">Select Department</option>-->
                                <?php foreach ($location['department'] as $dept) { ?>
                                    <option value="<?php echo $dept['department']; ?>"><?php echo $dept['department']; ?></option>
                                <?php } ?>
                            </select>

                            &emsp;&emsp;&emsp;
                        </div>
						
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" id="agediv">
						
                            <label class="">Age</label>
                            <select id="ageSelector" style="width:100%;">
                                <!--<option value="">Select Age</option>-->
                                <option value="21-30">21-30 years</option>
                                <option value="30-40">30-40 years</option>
                                <option value="40-50">40-50 years</option>
                                <option value="50-60">50-60 years</option>
                                <option value="60+">60 years and Above</option>

                                <?php // foreach ($location['location'] as $loc) {  ?>
        <!--<option value="<?php echo $loc['location']; ?>"><?php echo $loc['location']; ?></option>-->
                                <?php // }    ?>
                            </select>
                        </div>
                    </div>
			<!--------------------------------------------------------------------->
			
			<!--------------------------------------------------------------------->
			<div class="row">
			<div class="col-xs-12">
                    <?php include_once('newGraph.php'); ?>
            </div>
			</div>
			<!--------------------------------------------------------------------->
            <div class="row">
			<div class="col-xs-12">
				
                    <div class=""><h3><b><?php // echo $getcat['posts'][0]['surveyTitle'];   ?></b></h3><hr></div>
				 <label class="respondentCount"></label><BR/>
                            <!--<table class="datatable table table-responsive" cellspacing="0" width="100%">-->
							 <table class=" table table-responsive" cellspacing="0" width="100%" style="border: 2px solid #ccc;margin-top:-28px;">
                                <thead>
                                    <tr>

                                <th style="font-weight:900;">Survey Question</th>

                                <th>  <img src="img/sad_icon.png" style="height:23px;width:23px;"/></th>
                                <th> <img src="img/normal_icon.png" style="height:23px;width:23px;"/></th>
                                <th>   <img src="img/happiness_icon.png" style="height:23px;width:23px;"/></th>
                                <th>   <img src="img/smileyoutline.png" style="height:23px;width:23px;"/></th>

 <!--<th>Expiry Date</th>
 <th>Status</th>
 <th>Respondent</th>-->
                                <th style="font-weight:900;">Average</th>
                                <th style="font-weight:900;">Chart</th>

  <!--<th>Salary</th>-->
                            </tr>
                                </thead>
                                <!--<tfoot>
                                    <tr>

                                        <th>Survey Question</th>
                                       
                                          <th>  <img src="img/sad_icon.png" style="height:23px;width:23px;"/></th>
                                          <th> <img src="img/normal_icon.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                          <th>   <img src="img/happiness_icon.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                          <th>   <img src="img/smileyoutline.png" style="height:23px;width:23px;margin-left:11%;"/></th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Respondent</th>
                                        <th>Average</th>
                                        <th>Chart</th>
                                       
                                        
                                    </tr>
                                </tfoot>-->
                                <tbody>
                                    <?php
                                   $totalRespondentNo = array();
                                    for ($i = 0; $i < $count2; $i++) 
                                    {
                                        $surveyid = $value2[$i]['surveyId'];
                                        $qid = $value2[$i]['questionId'];
                                        
                                     /************************************************************************/
                                        $sad = -5;
                                        $happy = 5;
                                        $normal = 0;
                                        $ehappy = 10;
                                        $happy_avg = 0;
                                         $sadcount = $poll_obj->getSurveyCount($surveyid,$qid,$sad); 
                                         $happycount = $poll_obj->getSurveyCount($surveyid,$qid,$happy); 
                                         $normalcount = $poll_obj->getSurveyCount($surveyid,$qid,$normal); 
                                         $ehappycount = $poll_obj->getSurveyCount($surveyid,$qid,$ehappy); 
                                         
                                       $happy_avg1 =   $sadcount['surveycount'] * $sad;
                                       $happy_avg2 =   $normalcount['surveycount'] * $normal;
                                       $happy_avg3 =   $happycount['surveycount'] * $happy;
                                       $happy_avg4 =   $ehappycount['surveycount'] * $ehappy;
                                       
                                        $totalRespondent = ($sadcount['surveycount'] +$normalcount['surveycount']+ $happycount['surveycount']+$ehappycount['surveycount']);
                                        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4)/$totalRespondent;
                                     //    print_r($ehappycount);
                                    //    echo "<br/>";
                                        /*****************************************************************/
                                        
                                        if ($value2[$i]['status'] == 1) {
                                            $sta = "Unpublish";
                                            $gly = "glyphicon glyphicon-eye-close";
                                            $dis = "";
                                            $status = "Live";
                                        } else {
                                            $sta = "Unpublish";
                                            $gly = "glyphicon glyphicon-eye-open";
                                            $dis = "disabled";
                                            $status = "Expire";
                                        }
                                        $surveyid = $value2[$i]['surveyId'];
                                        ?>       	
                                        <tr>

                                            <td class="padding_right_px"><?php
                                                if (strlen($value2[$i]['question']) > 50) {
                                                    echo substr($value2[$i]['question'], 0, 50) . "<b>...</b>";
                                                } else {
                                                    echo $value2[$i]['question'];
                                                }
                                                ?></td>
                                            <td><span style="font-size:23px;"><?php echo $sadcount['surveycount']; ?></span></td>
                                            <td> <span style="font-size:23px;"><?php echo $normalcount['surveycount']; ?></span></td>
                                            <td>  <span style="font-size:23px;margin-left:22%;"><?php echo $happycount['surveycount']; ?></span></td>
                                           <td> <span style="font-size:23px;margin-left:22%;"><?php echo  $ehappycount['surveycount']; ?></span></td>
                                                           <!--   <td class="padding_right_px"><?php
                                            $uid = $value2[$i]['createdBy'];
                                            //   echo $uid;
                                            $na = $gt->getUserData($clientid, $uid);
                                            //  echo $na;
                                            $name = json_decode($na, true);
                                            echo $name[0]['firstName'] . " " . $name[0]['lastName'];
                                            ?></td>--->
                                                             <!-- <td class="padding_right_px"><?php echo $value2[$i]['startDate']; ?></td> -->
                                           <!-- <td class="padding_right_px"><?php echo $value2[$i]['expiryDate']; ?></td>-->
                                            <!--<td class="padding_right_px"><?php echo $status; ?></td>-->
                                            <!--<td class="padding_right_px"><?php echo  $totalRespondent; ?></td>-->
                                            <td class="padding_right_px"><?php echo $happy_avg;
											if (!empty($happy_avg)) {
                                            $all_happy_avg[] = $happy_avg;
                                        } else {
                                            $all_happy_avg[] = '';
                                        }
											?></td>
                                            <td>

                                      <!--  <a href="view_survey_question.php?ques_id=<?php echo $value2[$i]['questionId']; ?>&status=<?php echo $status; ?>">
                                    <button style="background-color:#fff;color:red" type="button" onclick="return confirm( 'Are you sure you want to unpublish this Survey Question?');" class="btn btn-sm" <?php echo $dis . ">" . $sta; ?></span></button></a> -->

                                                <a href="view_survey_result.php?qid=<?php echo $value2[$i]['questionId']; ?>&clientid=<?php echo $value2[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" target="_blank" style="color:#00a4fd;margin-left:29px !important;">Result</a> 

                                             <!--   <a href="view_survey_respondent.php?qid=<?php echo $value2[$i]['questionId']; ?>&clientid=<?php echo $value2[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Respondent</a> --->

                                    <!--<a href="view_survey_result1.php?qid=<?php echo $value2[$i]['questionId']; ?>&clientid=<?php echo $value2[$i]['clientId']; ?>&sid=<?php echo $surveyid; ?>" style="color:#00a4fd;margin-left:29px !important;">Result</a>   --->

                                            </td>

                                        </tr>

                                        <?php
										 array_push($totalRespondentNo, $totalRespondent);
                                    }
							$overAllAvg = array();
                            $overAllAvg['name'] = "Group Average";
                            $overAllAvg['data'] = $all_happy_avg;

                            $respondCount = array_sum($totalRespondentNo);
							/*echo "<pre>";
							print_r($totalRespondentNo);
							echo $totalRespondentNo['0'];*/
                                    ?>
						<input type="hidden" id="respondentCount" value="<?php echo $totalRespondentNo['0']; ?>" />
						<input type="hidden" id="respondCount" value="<?php echo $respondCount; ?>" />
						<input type="hidden" id="SurveyId" value="<?php echo $_GET['sid']; ?>"/>
                        <input type="hidden" id="SurveyUser" value="<?php echo $_SESSION['user_type']; ?>"/>
						<input class="invisible" type="text" id="SurveyId" value="<?php echo $_GET['sid']; ?>"/>
						 <textarea class="invisible" readonly="" id="questionAvg"><?php echo json_encode(array($overAllAvg)); ?></textarea>
						 <textarea class="invisible" readonly="" id="departmentQuestionAvg">Department</textarea>
                        <textarea class="invisible" readonly="" id="locationQuestionAvg">Location</textarea>
                        <textarea class="invisible" readonly="" id="ageQuestionAvg">Age</textarea>
                                </tbody>
                            </table>
                    </div>
				</div>
				
				<!---------------------- COMMENT -------------------->
				<div class="row">
                    <div class="col-xs-12">
                        <div style="margin-left:20px;"><h3><b>Survey Comments</b></h3><hr></div>

                        <?php if ($commentData[0]['enableComment'] != 0) { ?>
                            <br/>
                            <div style="float:right; margin-right:77px; font-size:20px;"> 
                                <button type="button" id="downloadComments" class="btn btn-primary btn-sm">Download Comments</button>

                            </div>

                            <div class="card-body">
                                <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Survey Comments</th>
                                            <th>Average</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Survey Comments</th>
                                            <th>Average</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        for ($i = 0; $i < $commentCount; $i++) {
                                            ?>       	
                                            <tr>
                                                <td class="padding_right_px">
                                                    <input type="hidden" class="surveyTitle" value="<?php echo $commentData[$i]['surveyTitle']; ?>" />
                                                    <?php
                                                    if (strlen($commentData[$i]['comment']) > 50) {
                                                        echo substr($commentData[$i]['comment'], 0, 50) . "<b>...</b>";
                                                    } else {
                                                        echo $commentData[$i]['comment'];
                                                    }
                                                    ?>
                                                </td>

                                                <td class="padding_right_px">
                                                    <?php echo $commentData[$i]['avgRating']; ?>
                                                </td>
                                            </tr>

                                            <?php
                                            unset($commentData[$i]['surveyTitle']);
                                            unset($commentData[$i]['userUniqueId']);
                                            unset($commentData[$i]['surveyId']);
                                        }
                                        ?>
                                    <textarea id="commentData" style="display:none;" ><?php echo json_encode($commentData); ?></textarea>
                                    </tbody>
                                </table>
                            </div>
                        <?php } else if ($commentCount == 0) { ?>
                            <div style="float:right; margin-right:45%; font-size:12px; color:green;"> 
                                No comments available for this Survey
                            </div>
                        <?php } else if ($commentData[0]['enableComment'] == 0) { ?>
                            <div style="float:right; margin-right:45%; font-size:12px; color:red;"> 
                                Comments Disabled for this Survey
                            </div>
                        <?php } ?>

                    </div>
                </div>
				<!---------------------- / COMMENT ------------------>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function () {
            var surveyTitle = "<b><?php echo $getcat['posts'][0]['surveyTitle']; ?></b>";
            
            $('.respondCount').html("No. of Respondents : " + $("#respondCount").val());
          $('.respondentCount').html("No. of Respondents : " + $("#respondentCount").val());
		  
		  $("#departmentdiv").hide();
		  $("#agediv").hide();
		  
		  $("#locationradio").click(function () {
			if($('#locationradio').is(':checked'))
			{
				 $("#locationdiv").show();
				 $("#departmentdiv").hide();
				 $("#agediv").hide();
			}
		  });
			
			$("#departmentradio").click(function () {
			if($('#departmentradio').is(':checked'))
			{
				 $("#locationdiv").hide();
				 $("#departmentdiv").show();
				 $("#agediv").hide();
			}
			});
			
			$("#ageradio").click(function () {
			if($('#ageradio').is(':checked'))
			{
				 $("#locationdiv").hide();
				 $("#departmentdiv").hide();
				 $("#agediv").show();
			}
			});
				
		  /* $(".companyRadio").hide();

            if ($('#companyRadio1').is(':checked')) {
                $("#companySelectorGraphDiv").show();
                $("#companySelectorDiv").hide();
            }
            //
            $("#companyRadio1").click(function () {
                if ($("#companyRadio1").is(':checked')) {
                    $("#companySelectorGraphDiv").show();
                    $("#companySelectorDiv").hide();
                }
            });

            $('#companyRadio2').click(function () {
                if ($('#companyRadio2').is(':checked')) {
                    $("#companySelectorGraphDiv").hide();
                    $("#companySelectorDiv").show();
                }
            });

            var SurveyUser = $("#SurveyUser").val();
            if (SurveyUser != 'Admin') {
                $("#tab2").trigger('click');
            }
*/

            var surveyQuestions = JSON.parse($("#questionAvg").val());
			//alert(surveyQuestions);
            compareChartGraph(surveyQuestions, surveyTitle);
			//alert(compareChartGraph);
            $("#downloadComments").click(function () {
                var commentData = $("#commentData").val();
                var reportTitle = "Survey-" + $(".surveyTitle").val();
                var showLabel = true;
                if (confirm("Are you want to download Survey comments report?")) {
                    JSONToCSVConvertor(commentData, reportTitle, showLabel);
                }
            });
			/*
            $("#companySelector").change(function () {
                var company = $("#companySelector").val();
                if (company != '') {
                    $.ajax({
                        url: "get_graph_data_filter.php",
                        type: "POST",
                        cache: false,
                        data: {
                            "cid": 'CO-27',
                            "task": 'get company location',
                            "company": company
                        },
                        success: function (response) {
                            $("#locationSelectorCompany").html(response);
                        }
                    });
                }
                else {
                    alert('No company selected');
                }
            });

            $("#companySelectorGraph").change(function () {
                var company = $("#companySelectorGraph").val();
                company.unshift("Group Average");
                var surveyId = $("#SurveyId").val();
                if (company != '') {
                    $.ajax({
                        url: "get_graph_data_filter.php",
                        type: "POST",
                        cache: false,
                        data: {
                            "cid": 'CO-27',
                            "sid": surveyId,
                            "task": "company_graph",
                            "company": company
                        },
                        success: function (response) {
                            $("#companyQuestionAvg").val(response);
                            var companyAvg = JSON.parse($("#companyQuestionAvg").val());
                            compareChartGraph(companyAvg, surveyTitle);
                        }
                    });
                } else {
                    var surveyQuestions = JSON.parse($("#questionAvg").val());
                    compareChartGraph(surveyQuestions, surveyTitle);
                }
            });
*/
            $("#locationSelector").change(function () {
                var location = $("#locationSelector").val();
				//alert(location);
              location.unshift("Group Average");
                var surveyId = $("#SurveyId").val();
				//alert(surveyId);
                if (location != '') {
                    $.ajax({
                        url: "get_graph_data_filter.php",
                        type: "POST",
                        cache: false,
                        data: {
                            "cid": 'CO-25',
                            "sid": surveyId,
                            "location": location
                        },
                        success: function (response) {
                            $("#locationQuestionAvg").val(response);
							//alert(response);
                            var locationAvg = JSON.parse($("#locationQuestionAvg").val());
                            compareChartGraph(locationAvg, surveyTitle);
                        }
                    });
                } else {
                    var surveyQuestions = JSON.parse($("#questionAvg").val());
                    compareChartGraph(surveyQuestions, surveyTitle);
					
                }
            });
/*
            $("#locationSelectorCompany").change(function () {
                var company = $("#companySelector").val();
                var location = $("#locationSelectorCompany").val();
                location.unshift("Group Average");
                var surveyId = $("#SurveyId").val();
                if (location != '' && company != '') {
                    $.ajax({
                        url: "get_graph_data_filter.php",
                        type: "POST",
                        cache: false,
                        data: {
                            "cid": 'CO-27',
                            "sid": surveyId,
                            "company": company,
                            "location": location
                        },
                        success: function (response) {
                            $("#locationQuestionAvg").val(response);
                            var locationAvg = JSON.parse($("#locationQuestionAvg").val());
                            compareChartGraph(locationAvg,surveyTitle);
                        }
                    });
                } else {
                    
                    alert('Please select a Company first');
                }
            });*/

            $("#departmentSelector").change(function () {
                var dept = $("#departmentSelector").val();
				//alert(dept);
                dept.unshift("Group Average");
                var surveyId = $("#SurveyId").val();
				//alert(surveyId);
                if (dept != '') {
                    $.ajax({
                        url: "get_graph_data_filter.php",
                        type: "POST",
                        cache: false,
                        data: {
                            "cid": 'CO-25',
                            "sid": surveyId,
                            "department": dept
                        },
                        success: function (response) {
                            $("#departmentQuestionAvg").val(response);
							//alert(response);
                            var departmentAvg = JSON.parse($("#departmentQuestionAvg").val());
                            compareChartGraph(departmentAvg, surveyTitle);
                        }
                    });
                } else {
                    var surveyQuestions = JSON.parse($("#questionAvg").val());
                    compareChartGraph(surveyQuestions,surveyTitle);
                }
            });

            $("#ageSelector").change(function () {
                var age = $("#ageSelector").val();
				//alert(age);
                var surveyId = $("#SurveyId").val();
				//alert(surveyId);
                if (age != '') {
					//alert("hello");
                    $.ajax({
                        url: "get_graph_data_filter.php",
                        type: "POST",
                        cache: false,
                        data: {
                            "cid": 'CO-25',
                            "sid": surveyId,
                            "age": age
							 },
                        success: function (response) {
							//alert(response);
                            $("#ageQuestionAvg").val(response);
                            var ageQuestionAvg = JSON.parse($("#ageQuestionAvg").val());
                            compareChartGraph(ageQuestionAvg,surveyTitle);
                        }
                    });
                } else {
                    var surveyQuestions = JSON.parse($("#questionAvg").val());
                    compareChartGraph(surveyQuestions,surveyTitle);
                }
            });
			
			
        });
    </script>
	
<?php include 'footer.php'; ?>