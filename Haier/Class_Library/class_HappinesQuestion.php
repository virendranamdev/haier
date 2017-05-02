<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');
}

class HappinessQuestion 
{

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function surveyMaxId() {
        try {
            $max = "select max(surveyId) from Tbl_C_SurveyDetails";
            $stmt = $this->DB->prepare($max);
            if ($stmt->execute()) {
                $tr = $stmt->fetch();
                $m_id = $tr[0];
                $m_id1 = $m_id + 1;
                $qid = $m_id1;

                return $qid;
            }
        } catch (PDOException $e)
        {
            echo $e;
            trigger_error('Error occured fetching max autoid : ' . $e->getMessage(), E_USER_ERROR);
        }
    }
    
     function checkSurveyAvailablity($clientid,$startdate)
     {
         try
         {
         $query1 = "select * from Tbl_C_SurveyDetails where expiryDate > '" .$startdate. "' and status = 1 and clientId=:cid";
            $stmt1 = $this->DB->prepare($query1);
            //  $stmt1->bindParam(':dte1', $this->startdate, PDO::PARAM_STR);
            $stmt1->bindParam(':cid',$clientid, PDO::PARAM_STR);

            $stmt1->execute();
            $value = $stmt1->fetchAll(PDO::FETCH_ASSOC);
          
               if (count($value) > 0) 
            {
                $result['success'] = 1;
                $result['message'] = "survey is Available";
               
            } 
            else {
                 $result['success'] = 0;
                $result['message']  = "survey not Available";
              
            }
         }
         catch(PDOException $e)
         {
             $result['success'] = 0;
                $result['message'] = "there is some error please contact info@benepik.com".$e;
            }
         return json_encode($result);
     }

     function createSurvey($clientid, $surveytitle, $noofques, $createdby, $createddate, $expiryDate,$startdate,$status) 
                {
    // echo $status;
        try {
                $query = "insert into Tbl_C_SurveyDetails(clientId,surveyTitle,quesno,createdBy,createdDate,    expiryDate,startDate,status)values(:cid,:stitle,:quesno, :createdby,  :createddate, :expiryDate,:startdate,:status )";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                $stmt->bindParam(':stitle', $surveytitle, PDO::PARAM_STR);
                $stmt->bindParam(':quesno',$noofques, PDO::PARAM_STR);
                 $stmt->bindParam(':createdby',$createdby, PDO::PARAM_STR);
                 $stmt->bindParam(':createddate',$createddate, PDO::PARAM_STR);
                 $stmt->bindParam(':expiryDate',  $expiryDate, PDO::PARAM_STR);
                $stmt->bindParam(':startdate',$startdate, PDO::PARAM_STR);
                 $stmt->bindParam(':status',$status, PDO::PARAM_STR);
                          
                $stmt->execute();
                $last_id = $this->DB->lastInsertId(); 
                
                $result['success'] = 1;
                $result['message'] = "survey is successfully started";
                $result['lastid'] = $last_id;
                return($result);
            
        } catch (PDOException $e) {
            echo $e;
        }
    }
     
     
     
    function createSurvey1($surveyid, $clientid, $questiontext, $enableComment, $startdate, $expiryDate, $createdby, $createddate) {

        $this->idclient = $clientid;
        $this->questiontext = $questiontext;
        $this->enable_comment = $enableComment;
        $this->startdate = $startdate;
      //  echo $this->startdate;
        $this->expiryDate = $expiryDate;    
        $this->createdby = $createdby;
        $this->createddate = $createddate;

        try {

                $query = "insert into Tbl_C_HappinessQuestion(surveyId,clientId,question,enableComment,startDate,expiryDate,createdBy,createdDate) values(:sid,:cid,:ques_text,:enable_comment, :startdate, :expiryDate, :createdby, :createddate)";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':sid', $surveyid, PDO::PARAM_STR);
                $stmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':ques_text', $this->questiontext, PDO::PARAM_STR);
                $stmt->bindParam(':enable_comment', $this->enable_comment, PDO::PARAM_STR);
                $stmt->bindParam(':startdate', $this->startdate, PDO::PARAM_STR);
                $stmt->bindParam(':expiryDate', $this->expiryDate, PDO::PARAM_STR);
                $stmt->bindParam(':createdby', $this->createdby, PDO::PARAM_STR);
                $stmt->bindParam(':createddate', $this->createddate, PDO::PARAM_STR);
                $stmt->execute();

                $result['success'] = 1;
                $result['message'] = "survey is successfully started";
                return($result);
            
        } catch (PDOException $e) {
            echo $e;
        }
    }
    

    /*function SurveyDetails($clientid, $user_uniqueid, $user_type) {
        $this->idclient = $clientid;
        $this->eid = $user_uniqueid;
        $this->utype = $user_type;

        if ($this->utype == "SubAdmin") {
            try {
                $query = "select * from Tbl_C_SurveyDetails where clientId=:cli and createdBy =:cb order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':cb', $this->eid, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                $response = array();

                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            try {
                $query = "select * from Tbl_C_SurveyDetails where clientId=:cli order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response = array();

                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }*/
	/***************************************** survey detail ************************/
	
	function SurveyDetails($clientid, $user_uniqueid, $user_type) {
        $this->idclient = $clientid;
        $this->eid = $user_uniqueid;
        $this->utype = $user_type;

        if ($this->utype == "SubAdmin") {
            try {
                $query = "select *, DATE_FORMAT(startDate,'%d %b %Y %h:%i %p') as startDate,DATE_FORMAT(expiryDate,'%d %b %Y %h:%i %p') as expiryDate from Tbl_C_SurveyDetails where clientId=:cli and createdBy =:cb order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':cb', $this->eid, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                $response = array();

                if ($rows) {
                    $responseCount = array();
                    foreach ($rows as $val) {
                        $query = "select survey.surveyId,count(distinct(happiness.userUniqueId)) as responseCount from Tbl_Analytic_EmployeeHappiness as happiness join Tbl_C_SurveyDetails as survey on happiness.surveyId=survey.surveyId where happiness.clientId=:cli and happiness.surveyId=:surveyId";
                        $stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                        $stmt->bindParam(':surveyId', $val['surveyId'], PDO::PARAM_STR);
                        $stmt->execute();
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);

                        array_push($responseCount, $data);
                    }

                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    $response["responseCount"] = $responseCount;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        } else {
            try {
                $query = "select *,DATE_FORMAT(startDate,'%d %b %Y %h:%i') as startDate,DATE_FORMAT(expiryDate,'%d %b %Y %h:%i') as expiryDate from Tbl_C_SurveyDetails where clientId=:cli order by surveyId desc";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $response = array();

                if ($rows) {
                    $responseCount = array();
                    foreach ($rows as $val) {
                        $query = "select survey.surveyId,count(distinct(happiness.userUniqueId)) as responseCount from Tbl_Analytic_EmployeeHappiness as happiness join Tbl_C_SurveyDetails as survey on happiness.surveyId=survey.surveyId where happiness.clientId=:cli and happiness.surveyId=:surveyId";
                        $stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                        $stmt->bindParam(':surveyId', $val['surveyId'], PDO::PARAM_STR);
                        $stmt->execute();
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);

                        array_push($responseCount, $data);
                    }

                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    $response["responseCount"] = $responseCount;
                    return json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        }
    }
/**************************************** survey detail *******************************/

    
     function SurveyquestionDetails($sid,$cid) {
        $this->idclient = $cid;
        $this->sid = $sid;
      //  $this->utype = $user_type;

            try {
                //$query = "select * from Tbl_C_HappinessQuestion where clientId=:cli and surveyId=:sid";
				$query = "select question.*,survey.surveyTitle from Tbl_C_HappinessQuestion as question join Tbl_C_SurveyDetails as survey on survey.surveyId=question.surveyId where question.clientId=:cli and question.surveyId=:sid";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
              
              /*  $count = count($rows);
                
                for($i=0;$i<$count;$i++)
                {
                  
                     $rows[$i]['happycount'] = array();
                    $qid = $rows[$i]['questionId'];
                     $sid = $rows[$i]['surveyId'];
                     
                     $query2 = "SELECT count(value) AS surveycount, value as surveyvalue FROM Tbl_Analytic_EmployeeHappiness WHERE surveyId =:sid1 AND questionId=:qid GROUP BY value";
                     
                     $stmt2 = $this->DB->prepare($query2);
                $stmt2->bindParam(':sid1', $sid, PDO::PARAM_STR);
                $stmt2->bindParam(':qid', $qid, PDO::PARAM_STR);
                $stmt2->execute();
                $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                
                array_push($rows[$i]['happycount'], $rows2);
               
                }  */
               // echo "<pre>";
              //  print_r($rows);
                $response = array();

                if ($rows) {
                    $response["success"] = 1;
                    $response["message"] = "You successfully fetched";
                    $response["posts"] = $rows;
                    return json_encode($response);
                } else { 
                    $response["success"] = 0;
                    $response["message"] = "data doesn't fetch";
                    return json_encode($response);
                }
            } catch (PDOException $e) {
                echo $e;
            }
        
    }
    function getSurveyCount($sid,$qid,$value)
    {
        try
        {
             $squery = "SELECT count(value) AS surveycount FROM Tbl_Analytic_EmployeeHappiness WHERE surveyId =:sid1 AND questionId=:qid and value=:val";
        
                     $stmt2 = $this->DB->prepare($squery);
                $stmt2->bindParam(':sid1', $sid, PDO::PARAM_STR);
                $stmt2->bindParam(':qid', $qid, PDO::PARAM_STR);
                $stmt2->bindParam(':val', $value, PDO::PARAM_STR);
                $stmt2->execute();
                $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                return $rows2;
        } catch (Exception $ex) {
            echo $ex;

        }
       
    }

    function updateSurveyStatus($sid, $sta) {
        $this->sid = $sid;
        $this->status = $sta;
      
        try {        
             $query1 = "update Tbl_C_SurveyDetails set status=:sta where surveyId =:sid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':sid1', $this->sid, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $this->status, PDO::PARAM_STR);
            $stmt1->execute();
            
            $query = "update Tbl_C_HappinessQuestion set status=:sta where surveyId =:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
            $stmt->bindParam(':sta', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) 
                {
                $response["success"] = 1;
                $response["message"] = "Survey status change now it is expire";
               
            }
        } catch (PDOException $e) {
          //  echo $e;
             $response["success"] = 0;
                $response["message"] = "there is some problem please contact info@benepik.com".$e;
        }
         return json_encode($response);
    }
    /** ******************FOR GETTING ANSWERS FROM DATABASE BASED ON POLLID STARTS*****************************/

    function getresultquestion($qid, $clientid, $sid) 
                {
        try {
            $query = "select value as label,count(value) as value    from Tbl_Analytic_EmployeeHappiness where clientId=:cli and surveyId = :sid and questionId = :qid group by value;
";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            
             $query1 = "select question from Tbl_C_HappinessQuestion where clientId=:cli and surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);    
            $stmt1->execute();
                $value = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                
                $response["data"] = $rows;
               // $response["question"] = $value;
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }
    
    
     function getSurveyquestion($qid, $clientid, $sid) 
                {
   
        try {
           
             $query1 = "select question from Tbl_C_HappinessQuestion where clientId=:cli and surveyId = :sid and questionId = :qid";

            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);    
            $stmt1->execute();
                $value = $stmt1->fetch(PDO::FETCH_ASSOC);
                
               
               // $response["question"] = $value;
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($value);
    }
    
    
    function getSurveyResponse($qid, $clientid, $sid) 
                {
   
        try {
            $query = "select *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate from Tbl_Analytic_EmployeeHappiness where clientId=:cli and surveyId = :sid and questionId = :qid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // print_r($rows);
                 if(count($rows)>0)
                 {
                $response["success"] = 1;
                $response["data"] = $rows;
               // $response["question"] = $value;
                 }
                 else{
                     $response["success"] = 0;
                     $response["msg"] = "No Rresponse Found";
                 }
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }
     /************************************************/
    
     function getSurveyReminderUser($clientid, $sid) 
                {
//    echo $clientid;
//    echo $sid;
        try {
            $query = "select * from Tbl_C_SurveyDetails where clientId=:cli and surveyId = :sid and status = 1";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        
             if(count($rows)>0)
                    {
            
                 $query2 = "select distinct(userUniqueId) from Tbl_Analytic_EmployeeHappiness where surveyId =:sid and clientId = :cli";
                   $stmt1 = $this->DB->prepare($query2);
            $stmt1->bindParam(':cli', $clientid, PDO::PARAM_STR);
            $stmt1->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt1->execute();
            $rows2 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
         //   print_r($rows2);
           $emoveval = "";
           $val = "";
            
            foreach ($rows2 as $type) {
      $val .= "'" . implode("', '", $type) . "',";
    }
    $emoveval = rtrim($val, ',');
   // echo $emoveval;
   
    if ($emoveval == '') {
                    $query3 = "select distinct(postsent.userUniqueId) from Tbl_Analytic_PostSentTo as postsent where postsent.flagType = 20 and postsent.userUniqueId NOT IN ('" . $emoveval . "')";
                } else {
                    $query3 = "select distinct(postsent.userUniqueId) from Tbl_Analytic_PostSentTo as postsent where postsent.flagType = 20 and postsent.userUniqueId NOT IN (" . $emoveval . ")";
                }
	   
    /* $query3 = "select distinct(postsent.userUniqueId) from Tbl_Analytic_PostSentTo as postsent where postsent.flagType = 20 and postsent.userUniqueId NOT IN (".$emoveval.")";
	*/
            $stmt3 = $this->DB->prepare($query3);
            $stmt3->execute();
            $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
//           echo $query3;
//           print_r($rows3);
             $data = array();
            foreach ($rows3 as $row4) {
        array_push($data, $row4["userUniqueId"]);
            }
              
            if(count($rows)>0)
                 {
                
                $response["success"] = 1;
                $response["data"] = $data;
                $response["survey"] = $rows;
               // $response["question"] = $value;
                 }
                 else{
                     $response["success"] = 0;
                     $response["msg"] = "No Rresponse Found";
                      $response["data"] = $data;
                $response["survey"] = $rows;
                 }
                 
    }
         
         }   
        catch (PDOException $e) {
            echo $e;
        }
        return json_encode($response);
    }
	
/******************** get survey coun location ******************************/

function getSurveyCountLocation($sid, $qid, $value, $location, $company = '') {
        try {
            $squery = "SELECT count(happiness.value) AS surveycount FROM Tbl_Analytic_EmployeeHappiness as happiness join Tbl_EmployeeDetails_Master as master on master.employeeId=happiness.userUniqueId WHERE happiness.surveyId =:sid1 AND happiness.questionId=:qid and happiness.value=:val and master.branch=:loc";
            if (!empty($company)) {
                $squery .= " and master.companyUniqueId='$company'";
            }

            $stmt2 = $this->DB->prepare($squery);
            $stmt2->bindParam(':sid1', $sid, PDO::PARAM_STR);
            $stmt2->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt2->bindParam(':val', $value, PDO::PARAM_STR);
            $stmt2->bindParam(':loc', $location, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            return $rows2;
        } catch (Exception $ex) {
            echo $ex;
        }
    }
/**********************************************************************************/

/************************************************************************************/
function getSurveyCountDept($sid, $qid, $value, $dept) {
        try {
            $squery = "SELECT count(happiness.value) AS surveycount FROM Tbl_Analytic_EmployeeHappiness as happiness join Tbl_EmployeeDetails_Master as master on master.employeeId=happiness.userUniqueId WHERE happiness.surveyId =:sid1 AND happiness.questionId=:qid and happiness.value=:val and master.department=:dept";

            $stmt2 = $this->DB->prepare($squery);
            $stmt2->bindParam(':sid1', $sid, PDO::PARAM_STR);
            $stmt2->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt2->bindParam(':val', $value, PDO::PARAM_STR);
            $stmt2->bindParam(':dept', $dept, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            return $rows2;
        } catch (Exception $ex) {
            echo $ex;
        }
    }
/************************************************************************************/
/*************************************************************************************/
 function getSurveyCountAge($sid, $qid, $value, $age) {
        try {
            $squery = "SELECT count(happiness.value) AS surveycount FROM Tbl_Analytic_EmployeeHappiness as happiness join Tbl_EmployeePersonalDetails as personal on personal.employeeId=happiness.userUniqueId WHERE happiness.surveyId =:sid1 AND happiness.questionId=:qid and happiness.value=:val and ";
            if ($age[0] >= '60+') {
                $squery .= "floor(datediff(curdate(),personal.userDOB) / 365) >= 60";
            } else {
                $squery .= "floor(datediff(curdate(),personal.userDOB) / 365) between $age[0] and $age[1]";
            }

            $stmt = $this->DB->prepare($squery);
            $stmt->bindParam(':sid1', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':qid', $qid, PDO::PARAM_STR);
            $stmt->bindParam(':val', $value, PDO::PARAM_STR);
//            $stmt->bindParam(':age1', $age[0], PDO::PARAM_STR);
//            $stmt->bindParam(':age2', $age[1], PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            return $rows;
        } catch (Exception $ex) {
            echo $ex;
        }
    }

	/************************************************************************************/
	
	/************************************** SURVEY COMMENT *****************************/
	function SurveycommentDetails($sid, $cid) {
        $this->idclient = $cid;
        $this->sid = $sid;
        //  $this->utype = $user_type;

        try {
            $query = "select survey.surveyTitle, hapques.enableComment , happiness.userUniqueId, happiness.comment, happiness.surveyId, avg(happiness.value) as avgRating from Tbl_Analytic_EmployeeHappiness as happiness join Tbl_C_SurveyDetails as survey on happiness.surveyId=survey.surveyId JOIN Tbl_C_HappinessQuestion as hapques ON survey.surveyId = hapques.surveyId where happiness.clientId=:cli and happiness.surveyId=:sid group by happiness.userUniqueId";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $this->sid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array();

            if ($rows) {
                $response["success"] = 1;
                $response["message"] = "You successfully fetched";
                $response["posts"] = $rows;
                return json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "data doesn't fetch";
                return json_encode($response);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
	/************************************** / SURVEY COMMENT ******************************/
    }
  
