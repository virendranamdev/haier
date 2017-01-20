<?php
include_once('class_connect_db_Communication.php');
class Survey {

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }
    
function getSurveyQuestion($clientid,$uuid,$date)
{
     try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uuid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows)>0)
            {
            $query = "select * from Tbl_C_HappinessQuestion where startdate <= :dte and expiryDate > :dte and clientId= :cid and status =1"; 
            $nstmt = $this->DB->prepare($query);
                    $nstmt->bindParam(':cid',$clientid, PDO::PARAM_STR);
                    $nstmt->bindParam(':dte', $date, PDO::PARAM_STR);
                    $nstmt->execute();
                    $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    $response['success'] = 1;
                    $response['msg'] = "Successfully Display data";
                    $response['posts'] = $welrows;
             }
             else 
                 {
                 echo "sory ur not authorized user";
                    $response['success'] = 0;
                    $response['msg'] = "Sorry u r not authorized user";  
             }
     }
       catch (PDOException $es)
       {
           $response['success'] = 0;
                    $response['msg'] = "there is some error".$es;
       }
    
    return $response;
}
}
    