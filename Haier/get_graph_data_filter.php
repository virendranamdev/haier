<?php

require_once('Class_Library/class_HappinesQuestion.php');
$poll_obj = new HappinessQuestion();

if (isset($_POST['department']) && (!empty($_POST['department']))) {
    extract($_POST);

    $result = $poll_obj->SurveyquestionDetails($sid, $cid);
    $getcat = json_decode($result, true);

	//print_r($getcat);
	
    $value2 = $getcat['posts'];
    $count2 = count($value2);

    $all_happy_avg = array();
    for ($i = 0; $i < $count2; $i++) {
        $surveyid = $value2[$i]['surveyId'];
        $qid = $value2[$i]['questionId'];

        /*         * ********************************************************************* */
        $sad = -5;
        $happy = 5;
        $normal = 0;
        $ehappy = 10;
        $happy_avg = 0;
        $sadcount = $poll_obj->getSurveyCount($surveyid, $qid, $sad);
        $happycount = $poll_obj->getSurveyCount($surveyid, $qid, $happy);
        $normalcount = $poll_obj->getSurveyCount($surveyid, $qid, $normal);
        $ehappycount = $poll_obj->getSurveyCount($surveyid, $qid, $ehappy);

		//print_r($happycount);
		
        $happy_avg1 = $sadcount['surveycount'] * $sad;
        $happy_avg2 = $normalcount['surveycount'] * $normal;
        $happy_avg3 = $happycount['surveycount'] * $happy;
        $happy_avg4 = $ehappycount['surveycount'] * $ehappy;

        $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

        if (!empty($happy_avg)) {
            $all_happy_avg[] = $happy_avg;
        } else {
            $all_happy_avg[] = '';
        }
    }
    $overAllAvg = $all_happy_avg;

    $deptAvg = array();
    array_unshift($deptAvg, $overAllAvg);

    for ($j = 1; $j < sizeof($department); $j++) {
        $questionAvg = array();
        for ($i = 0; $i < $count2; $i++) {
            $surveyid = $value2[$i]['surveyId'];
            $qid = $value2[$i]['questionId'];

            $sad = -5;
            $happy = 5;
            $normal = 0;
            $ehappy = 10;
            $happy_avg = 0;

            $sadcount = $poll_obj->getSurveyCountDept($surveyid, $qid, $sad, $department[$j]);
            $happycount = $poll_obj->getSurveyCountDept($surveyid, $qid, $happy, $department[$j]);
            $normalcount = $poll_obj->getSurveyCountDept($surveyid, $qid, $normal, $department[$j]);
            $ehappycount = $poll_obj->getSurveyCountDept($surveyid, $qid, $ehappy, $department[$j]);

//print_r($sadcount);
            $happy_avg1 = $sadcount['surveycount'] * $sad;
            $happy_avg2 = $normalcount['surveycount'] * $normal;
            $happy_avg3 = $happycount['surveycount'] * $happy;
            $happy_avg4 = $ehappycount['surveycount'] * $ehappy;


            $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
            $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

            $questionAvg[] = $happy_avg;
        }

        array_push($deptAvg, $questionAvg);
    }
//    $department['OverallAvg'] = 'Over all Average';
    //array_push($deptAvg, $overAllAvg);

    $departmentAvg = array_combine($department, $deptAvg);

//    print_r($departmentAvg);die;
    $finalArr = array();
    $newArr = array();

    foreach ($departmentAvg as $key => $val) {
        $newArr['name'] = $key;
        $newArr['data'] = $val;

        array_push($finalArr, $newArr);
    }
//   print_r($finalArr);die;
    echo json_encode($finalArr);
}

if (isset($_POST['location']) && (!empty($_POST['location']))) {
    extract($_POST);
    
   /* if (empty($company)) {
        $company = '';
    }*/

    $result = $poll_obj->SurveyquestionDetails($sid, $cid);
    $getcat = json_decode($result, true);
	//print_r($getcat);
	
    $value2 = $getcat['posts'];
    $count2 = count($value2);

    $all_happy_avg = array();
    for ($i = 0; $i < $count2; $i++) {
        $surveyid = $value2[$i]['surveyId'];
        $qid = $value2[$i]['questionId'];

        /*         * ********************************************************************* */
        $sad = -5;
        $happy = 5;
        $normal = 0;
        $ehappy = 10;
        $happy_avg = 0;
        $sadcount = $poll_obj->getSurveyCount($surveyid, $qid, $sad);
        $happycount = $poll_obj->getSurveyCount($surveyid, $qid, $happy);
        $normalcount = $poll_obj->getSurveyCount($surveyid, $qid, $normal);
        $ehappycount = $poll_obj->getSurveyCount($surveyid, $qid, $ehappy);

		//print_r($sadcount);
		
        $happy_avg1 = $sadcount['surveycount'] * $sad;
        $happy_avg2 = $normalcount['surveycount'] * $normal;
        $happy_avg3 = $happycount['surveycount'] * $happy;
        $happy_avg4 = $ehappycount['surveycount'] * $ehappy;

        $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

        if (!empty($happy_avg)) {
            $all_happy_avg[] = $happy_avg;
        } else {
            $all_happy_avg[] = '';
        }
    }
    $overAllAvg = $all_happy_avg;

    $deptAvg = array();
    array_unshift($deptAvg, $overAllAvg);

    for ($j = 1; $j < sizeof($location); $j++) {
        $questionAvg = array();
        for ($i = 0; $i < $count2; $i++) {
            $surveyid = $value2[$i]['surveyId'];
            $qid = $value2[$i]['questionId'];

            $sad = -5;
            $happy = 5;
            $normal = 0;
            $ehappy = 10;
            $happy_avg = 0;

            $sadcount = $poll_obj->getSurveyCountLocation($surveyid, $qid, $sad, $location[$j]);
            $happycount = $poll_obj->getSurveyCountLocation($surveyid, $qid, $happy, $location[$j]);
            $normalcount = $poll_obj->getSurveyCountLocation($surveyid, $qid, $normal, $location[$j]);
            $ehappycount = $poll_obj->getSurveyCountLocation($surveyid, $qid, $ehappy, $location[$j]);

			//print_r($sadcount);
            $happy_avg1 = $sadcount['surveycount'] * $sad;
            $happy_avg2 = $normalcount['surveycount'] * $normal;
            $happy_avg3 = $happycount['surveycount'] * $happy;
            $happy_avg4 = $ehappycount['surveycount'] * $ehappy;


            $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
            $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

            $questionAvg[] = $happy_avg;
        }

        array_push($deptAvg, $questionAvg);
    }
    
//    $department['OverallAvg'] = 'Over all Average';
    //array_push($deptAvg, $overAllAvg);

    $locationAvg = array_combine($location, $deptAvg);

	//print_r($locationAvg);
	
    $finalArr = array();
    $newArr = array();
    
    foreach ($locationAvg as $key => $val) {
        $newArr['name'] = $key;
        $newArr['data'] = $val;

        array_push($finalArr, $newArr);
    }
	//print_R($finalArr);
    
    echo json_encode($finalArr);
}

if (isset($_POST['task']) && ($_POST['task'] == 'get company location') && (!empty($_POST['task'])) && isset($_POST['company']) && (!empty($_POST['company']))) {
    extract($_POST);

    $companyLocation = $poll_obj->getCompanyLocation($cid, $company);

    $locationSelector = '<option>Select Location</option>';
    foreach ($companyLocation as $compLoc) {
        $locationSelector .='<option value="' . $compLoc['location'] . '"> ' . $compLoc['location'] . '</option>';
    }

    echo $locationSelector;
}

if (isset($_POST['task']) && ($_POST['task'] == 'company_graph') && (!empty($_POST['task'])) && isset($_POST['company']) && (!empty($_POST['company'])) && isset($_POST['sid']) && (!empty($_POST['sid']))) {
    extract($_POST);

    $result = $poll_obj->SurveyquestionDetails($sid, $cid);
    $getcat = json_decode($result, true);

    $value2 = $getcat['posts'];
    $count2 = count($value2);

    $all_happy_avg = array();
    for ($i = 0; $i < $count2; $i++) {
        $surveyid = $value2[$i]['surveyId'];
        $qid = $value2[$i]['questionId'];

        /*         * ********************************************************************* */
        $sad = -5;
        $happy = 5;
        $normal = 0;
        $ehappy = 10;
        $happy_avg = 0;
        $sadcount = $poll_obj->getSurveyCount($surveyid, $qid, $sad);
        $happycount = $poll_obj->getSurveyCount($surveyid, $qid, $happy);
        $normalcount = $poll_obj->getSurveyCount($surveyid, $qid, $normal);
        $ehappycount = $poll_obj->getSurveyCount($surveyid, $qid, $ehappy);

        $happy_avg1 = $sadcount['surveycount'] * $sad;
        $happy_avg2 = $normalcount['surveycount'] * $normal;
        $happy_avg3 = $happycount['surveycount'] * $happy;
        $happy_avg4 = $ehappycount['surveycount'] * $ehappy;

        $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

        if (!empty($happy_avg)) {
            $all_happy_avg[] = $happy_avg;
        } else {
            $all_happy_avg[] = '';
        }
    }
    $overAllAvg = $all_happy_avg;

    $deptAvg = array();
    array_unshift($deptAvg, $overAllAvg);

    for ($j = 1; $j < sizeof($company); $j++) {
        $questionAvg = array();
        for ($i = 0; $i < $count2; $i++) {
            $surveyid = $value2[$i]['surveyId'];
            $qid = $value2[$i]['questionId'];

            $sad = -5;
            $happy = 5;
            $normal = 0;
            $ehappy = 10;
            $happy_avg = 0;

            $sadcount = $poll_obj->getSurveyCountCompany($surveyid, $qid, $sad, $company[$j]);
            $happycount = $poll_obj->getSurveyCountCompany($surveyid, $qid, $happy, $company[$j]);
            $normalcount = $poll_obj->getSurveyCountCompany($surveyid, $qid, $normal, $company[$j]);
            $ehappycount = $poll_obj->getSurveyCountCompany($surveyid, $qid, $ehappy, $company[$j]);


            $happy_avg1 = $sadcount['surveycount'] * $sad;
            $happy_avg2 = $normalcount['surveycount'] * $normal;
            $happy_avg3 = $happycount['surveycount'] * $happy;
            $happy_avg4 = $ehappycount['surveycount'] * $ehappy;


            $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
            $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

            $questionAvg[] = $happy_avg;
        }

        array_push($deptAvg, $questionAvg);
    }
//    $department['OverallAvg'] = 'Over all Average';
    //array_push($deptAvg, $overAllAvg);

    $locationAvg = array_combine($company, $deptAvg);

    $finalArr = array();
    $newArr = array();

    foreach ($locationAvg as $key => $val) {
        $newArr['name'] = $key;
        $newArr['data'] = $val;

        array_push($finalArr, $newArr);
    }

    echo json_encode($finalArr);
}

if (isset($_POST['age']) && (!empty($_POST['age'])) && isset($_POST['sid']) && (!empty($_POST['sid']))) {
	
    extract($_POST);
	//echo "age";
    $age = explode('-', $age);
	
    $result = $poll_obj->SurveyquestionDetails($sid, $cid);
    $getcat = json_decode($result, true);

    $value2 = $getcat['posts'];
    $count2 = count($value2);

    $all_happy_avg = array();
    for ($i = 0; $i < $count2; $i++) {
        $surveyid = $value2[$i]['surveyId'];
        $qid = $value2[$i]['questionId'];

        /*         * ********************************************************************* */
        $sad = -5;
        $happy = 5;
        $normal = 0;
        $ehappy = 10;
        $happy_avg = 0;
        $sadcount = $poll_obj->getSurveyCount($surveyid, $qid, $sad);
        $happycount = $poll_obj->getSurveyCount($surveyid, $qid, $happy);
        $normalcount = $poll_obj->getSurveyCount($surveyid, $qid, $normal);
        $ehappycount = $poll_obj->getSurveyCount($surveyid, $qid, $ehappy);

        $happy_avg1 = $sadcount['surveycount'] * $sad;
        $happy_avg2 = $normalcount['surveycount'] * $normal;
        $happy_avg3 = $happycount['surveycount'] * $happy;
        $happy_avg4 = $ehappycount['surveycount'] * $ehappy;

        $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

        if (!empty($happy_avg)) {
            $all_happy_avg[] = $happy_avg;
        } else {
            $all_happy_avg[] = '';
        }
    }
    $overAllAvg = $all_happy_avg;

    $deptAvg = array();
    array_unshift($deptAvg, $overAllAvg);

//    for ($j = 1; $j < sizeof($age); $j++) {

    $questionAvg = array();
    for ($i = 0; $i < $count2; $i++) {
        $surveyid = $value2[$i]['surveyId'];
        $qid = $value2[$i]['questionId'];

        $sad = -5;
        $happy = 5;
        $normal = 0;
        $ehappy = 10;
        $happy_avg = 0;

        $sadcount = $poll_obj->getSurveyCountAge($surveyid, $qid, $sad, $age);
        $happycount = $poll_obj->getSurveyCountAge($surveyid, $qid, $happy, $age);
        $normalcount = $poll_obj->getSurveyCountAge($surveyid, $qid, $normal, $age);
        $ehappycount = $poll_obj->getSurveyCountAge($surveyid, $qid, $ehappy, $age);


        $happy_avg1 = $sadcount['surveycount'] * $sad;
        $happy_avg2 = $normalcount['surveycount'] * $normal;
        $happy_avg3 = $happycount['surveycount'] * $happy;
        $happy_avg4 = $ehappycount['surveycount'] * $ehappy;


        $totalRespondent = ($sadcount['surveycount'] + $normalcount['surveycount'] + $happycount['surveycount'] + $ehappycount['surveycount']);
        $happy_avg = ($happy_avg1 + $happy_avg2 + $happy_avg3 + $happy_avg4) / $totalRespondent;

        $questionAvg[] = $happy_avg;
    }

    array_push($deptAvg, $questionAvg);
//    }
//    $department['OverallAvg'] = 'Over all Average';
    //array_push($deptAvg, $overAllAvg);

    $Age = array();
    $Age[0] = 'Over all Average';
    $Age[1] = implode('-', $age);

    $deptAvg = array_combine($Age, $deptAvg);

    $finalArr = array();
    $newArr = array();

    foreach ($deptAvg as $key => $val) {
        $newArr['name'] = $key;
        $newArr['data'] = $val;

        array_push($finalArr, $newArr);
    }

    echo json_encode($finalArr);
}
?>
