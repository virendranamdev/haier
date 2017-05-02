<?php
error_reporting(E_ALL);ini_set('display_errors', 1);

if (!class_exists('EarningPoint') && include("../../Class_Library/Api_Class/class_userEarnPoint.php")) {

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        //echo json_encode($response);
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    $jsonArr = json_decode(file_get_contents("php://input"), true);
 /*
  {
"client_id":"CO-25",
"employeeId":"pSNx6y5WCp1EuIOsoS3iBesrFSObKF123"
}
  */
    if (!empty($jsonArr)) {
        extract($jsonArr);
        $obj = new EarningPoint();

          $flagType = 1;   //flag 1 for Earning by  first login
          $postid1 = "";
          
        $data = $obj->checkUserEntry($flagType, $employeeId,$postid1);
      //  print_r($data);
        if (count($data)== 0) {
            $postid = '';
          $obj->addloginReward($client_id, $employeeId, $flagType,$postid);   
           $amount1 = $obj->getUserbalance($employeeId);
           $account1 = $obj->getUserAccount($employeeId);
         
           $amount = $amount1[0]['balance'];
            $response['success'] = 1;
            $response['total'] = $account1['total'];
            $response['redeemed'] = $account1['redeemed'];
             $response['balance'] = $amount;
            $response['message'] = "Congratulations. You have received ".$amount." points on your first login.";
          } 
 else {
      $account2 = $obj->getUserAccount($employeeId);
      $amount2 = $obj->getUserbalance($employeeId);
      //print_r($amount2);
      if(count($amount2)>0)
      {
           $amount = $amount2[0]['balance']; 
      }
 else {
          $amount = 0; }
                 
            $response['success'] = 1;
             $response['total'] = $account2['total'];
            $response['redeemed'] = $account2['redeemed'];
             $response['balance'] = $amount;
            $response['message'] = "You have ".$amount." MyHaier Rewards.";
 }
    
    } else {
        $response['success'] = 0;
        $response['message'] = "Invalid json";
    }
    header('Content-type: application/json');
    echo json_encode($response);
}
?>
