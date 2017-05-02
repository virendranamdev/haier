<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!class_exists('Connection_Communication')) {
require_once('class_connect_db_Communication.php');
}
if (!class_exists('FindGroup')) {
require_once('class_find_groupid.php');
}
/* if (!class_exists('getUserData')) {
  require_once('class_get_useruniqueid.php');
  } */

class GetMyLearning {

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }

    function getLearningDetails($clientid, $uid, $val) {
       
        $this->idclient = $clientid;
        $this->value = $val;

        try {
            $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $uid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
         
            $grouparray = array();
            if (count($rows) > 0) 
                {
                 $empcode = $rows[0]['employeeCode'];
            $group_object = new findGroup();    // this is object to find group id of given unique id 
                $getgroup = $group_object->groupBaseofUid($clientid, $uid);
                $value = json_decode($getgroup, true);
               
                $groupcount  = count($value['groups']);
               
                if($groupcount>0)
                {
                    foreach($value['groups'] as $gr)
                    {
                    array_push($grouparray, $gr);
                    }
                }
                /********** this for custom group **********************/
              $getgroup1 = $group_object->groupBaseofemployeeid($clientid,$empcode);
              $value1 = json_decode($getgroup1, true);
               
                 $groupcount1  = count($value1['group']);
               
                if($groupcount>0)
                {
                    foreach($value1['group'] as $gr1)
                    {
                    array_push($grouparray, $gr1);
                    }
                }
                
             /**************************************************************************************************/
                 $count_group = count($grouparray);
                //echo "total group of empid =: ".$count_group."<br/>";

                if ($count_group <= 0) {
                    $result["success"] = 0;
                    $result["message"] = "No More Post Available";
                    return $result;
                }
                //$fr = "' . implode('", "', $elements) . '";
                else {
              
                      $in = implode("', '", array_unique($grouparray));
                  //  echo "group array : ".$in."<br/>";

                    /*                     * ************************************************************************************************* */

                    $eventquery1 = "select count(distinct(postId)) as total from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and clientId =:cid and flagType = 14 and status = 1 order by autoId desc";

                    $nstmt1 = $this->DB->prepare($eventquery1);
                    $nstmt1->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $nstmt1->execute();
                    $welrows11 = $nstmt1->fetch(PDO::FETCH_ASSOC);
                    $totalnews1 = $welrows11['total'];
                    // echo "total story".$totalnews1;		
                    /** ************************************************************************************************* */

                    $eventquery = "select distinct(postId) from Tbl_Analytic_PostSentToGroup where groupId IN('" . $in . "') and clientId = :cid and flagType = 14 and status = 1 order by autoId desc";

                    $nstmt = $this->DB->prepare($eventquery);
                    $nstmt->bindParam(':cid', $this->idclient, PDO::PARAM_STR);
                    $nstmt->execute();
                    $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
                    $postarray = array();
                    foreach ($welrows as $postid) {
                        array_push($postarray, $postid['postId']);
                    }
                    /*
                      echo "<pre>";
                      print_r($postarray);
                      echo "</pre>";
                     */
                    $unique_postid = array_values(array_unique($postarray));
                   
                    $post = array();
                    $result['success'] = 1;
                    $result['message'] = "data found";
                    $result['totalpost'] = $totalnews1;
                    $result['posts'] = array();
                    $welcount = count($unique_postid);
                    //echo "total post".$welcount."<br>";
                    for ($w=0 ; $w<$welcount; $w++) {
                        $postid = $unique_postid[$w];
                        //$clientid = $welrows[$w]['clientId'];
                        //echo $postid."<br>";
//                        $query3 = "select count(likeBy) as total_likes from Tbl_Analytic_PostLike where postId=:pstid and clientId=:cli";
//                        $stmt3 = $this->DB->prepare($query3);
//                        $stmt3->bindParam(':pstid', $postid, PDO::PARAM_STR);
//                        $stmt3->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
//                        $stmt3->execute();
//                        $rows3 = $stmt3->fetch(PDO::FETCH_ASSOC);
//                        $post["total_likes"] = $rows3["total_likes"];

//                        $query4 = "select count(commentBy) as total_comments from Tbl_Analytic_PostComment where postId=:pstid and clientId=:cli";
//                        $stmt4 = $this->DB->prepare($query4);
//                        $stmt4->bindParam(':pstid', $postid, PDO::PARAM_STR);
//                        $stmt4->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
//                        $stmt4->execute();
//                        $rows4 = $stmt4->fetch(PDO::FETCH_ASSOC);
//                        $post["total_comments"] = $rows4["total_comments"];

                        $query2 = "select *, if(learningImg IS NULL or learningImg = '','', concat('" .site_url. "',learningImg)) as learningImg , DATE_FORMAT(createdDate,'%d %b %Y') as createdDate from Tbl_C_Mylearning where learningId=:pstid and clientId=:cli and status = 1";
                        $stmt2 = $this->DB->prepare($query2);
                        $stmt2->bindParam(':cli', $this->idclient, PDO::PARAM_STR);
                        $stmt2->bindParam(':pstid', $postid, PDO::PARAM_STR);
                        $stmt2->execute();
                        $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                        $post["learningId"] = $rows2["learningId"];
                       
                        $post["clientId"] = $rows2["clientId"];
                        $post["learningName"] = $rows2["learningName"];
                        $post["learningImg"] = $rows2["learningImg"];
                        $post["createdBy"] = $rows2["createdBy"];
                       
                        $post["createdDate"] = $rows2["createdDate"];
                      
                        $uui = $post["createdBy"];

                        $query = "select Tbl_EmployeeDetails_Master.firstName,Tbl_EmployeeDetails_Master.lastName, if(Tbl_EmployeePersonalDetails.userImage IS NULL or Tbl_EmployeePersonalDetails.userImage = '','',concat('" . site_url . "',Tbl_EmployeePersonalDetails.userImage)) as UserImage from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeePersonalDetails.employeeId=:empid and Tbl_EmployeeDetails_Master.employeeId=:empid";
                        $stmt = $this->DB->prepare($query);
                        $stmt->bindParam(':cli', $clientid, PDO::PARAM_STR);
                        $stmt->bindParam(':empid', $uui, PDO::PARAM_STR);
                        $stmt->execute();
                        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                        $post["UserName"] = $rows["firstName"]." ".$rows["lastName"];
                        $post["UserImage"] = $rows["UserImage"];

                        array_push($result["posts"], $post);
                    }

                    /*********************************************************************************************** */
                    $datacount = count($post);
                    //echo $datacount;
                    if ($datacount < 1) {
                        $result['success'] = 0;
                        $result['message'] = "No More Post Available";
                        return $result;
                    } else {
                        return $result;
                    }
                }
            } else {
                $result['success'] = 0;
                $result['message'] = "Sorry You are not Authorized";
                return $result;
            }
        } catch (PDOException $e) {
            echo $e;
            $result['success'] = 0;
            $result['message'] = "data not found " . $e;
            return $result;
        }
    }

    /*     * *********************************************************************************************************** */
    
    
    public function getMyLearningfile($postid) {
        try {
           
            $query = "select *, DATE_FORMAT(createdDate,'%d %b %Y') as createdDate,if(filepath IS NULL or filepath='','',CONCAT('" . site_url . "',filepath)) as filepath from Tbl_C_Mylearningfile where learningId=:postid and status = 1";
            
            $stmt = $this->DB->prepare($query);
           
            $stmt->bindParam(':postid', $postid, PDO::PARAM_STR);
          
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // print_r($rows);
            if(count($rows)>0)
            {
            $response['success'] = 1;
            $response['message'] = "data found";
            $response['data'] = $rows;
            }
            else
            {
                $response['success'] = 0;
            $response['message'] = "data not found";
            }
        } catch (Exception $ex) {
            $response['success'] = 0;
            $response['message'] = "there is some error please write us to info@benepik.com " . $ex;
        }
        return json_encode($response);
    }
}

?>