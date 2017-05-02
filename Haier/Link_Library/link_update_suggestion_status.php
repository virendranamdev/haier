<?php
require_once('../Class_Library/class_complaints.php');
 { include("../Class_Library/Api_Class/class_userEarnPoint.php");}
 session_start();
if(!empty($_REQUEST))
{ 
$empid = $_GET['empid'];
$sid = $_GET['sid'];
$status = $_GET['status'];

$obj = new Complaint();
 $earnobj = new EarningPoint();  // for adding suggestion point
$result =  $obj->updateSuggestionStatus($sid,$status);
if($result['success'] == 1 && $status = 3)
{
     $flagType = 6;
    $postid = $sid;
    $clientid = $_SESSION['client_id'];
  $earnobj->addSuggestionReward($clientid, $empid,$flagType,$postid);
}
echo "<script>alert('Status has been changed')</script>";
echo '<script>window.location="../suggestion_box.php"</script>';
}

?>