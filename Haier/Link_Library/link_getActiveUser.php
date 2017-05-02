<?php

require_once('../Class_Library/class_login_analytic.php');
$obj = new LoginAnalytic();

if (!empty($_POST["mydata"])) {
    $jsonArr = $_POST["mydata"];
    //  echo $jsonArr;
    $data = explode("-", $jsonArr);


    if (!empty($data)) {
        $client = 'CO-25';

        $fromdt1 = $data[0];
        $fromdt = date("Y-m-d H:i:s", strtotime($fromdt1));
        $enddte1 = $data[1];
        $enddte = date("Y-m-d H:i:s", strtotime($enddte1));

        $result = $obj->graphGetActiveUser($client, $fromdt, $enddte);

        $res = json_decode($result, true);
     
        $postdate = array();
        $totalview = array();
        $uniqueview = array();
        for ($i = 0; $i < count($res); $i++) {
           
            $date = $res[$i]['date_of_entry'];
            $uniqueno = $res[$i]['uniqueview'];
            $totalno = $res[$i]['totalview'];
           
            array_push($postdate, $date);
            array_push($totalview, $totalno);
            array_push($uniqueview, $uniqueno);
        }
      
//        $response['success']=1;
        $response['categories'] = $postdate;
        $response['uniqueview'] = $uniqueview;
        $response['totalview'] = $totalview;
//print_r($response);
       
      echo   $jsonres = json_encode($response);
       // echo  "'".$jsonres."'";
    }
}
?>  