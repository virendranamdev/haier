<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');
include_once('class_find_groupid.php');  
class AchiverStory
{
  public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
    $this->DB = $db->getConnection_Communication();
  }

  function AchiverStoryDisplay($clientid,$uid,$val)
    {
     $this->idclient = $clientid;
     $this->value = $val;
	
        try
        {
        $query = "select * from Tbl_EmployeeDetails_Master where clientId=:cli and employeeId=:empid";
        $stmt = $this->DB->prepare($query);
		$stmt->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
        $stmt->bindParam(':empid',$uid, PDO::PARAM_STR);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
            if(count($rows)>0)
            {
             $group_object = new findGroup();    // this is object to find group id of given unique id 
             $getgroup = $group_object->groupBaseofUid($clientid,$uid);
             $value = json_decode($getgroup,true);
        
            /**************************************************************************************************/

			 $count_group = count($value['groups']);
			 //echo "total group of empid =: ".$count_group."<br/>";

				if($count_group <= 0 )
				{
				    $result["success"]=0;
			    	$result["message"]="Sorry You are Not in Any Group";  
					return $result;

				}
				//$fr = "' . implode('", "', $elements) . '";
				else
				{
					$in = implode("', '", array_unique($value['groups']));
					//echo "group array : ".$in."<br/>";

            /****************************************************************************************************/
			  
			    $eventquery1 = "select count(distinct(storyId)) as total from Tbl_Analytic_StorySentToGroup where groupId IN('".$in."') and clientId =:cid order by autoId desc";
										
                    $nstmt1 = $this->DB->prepare($eventquery1);
                    $nstmt1->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
                    $nstmt1->execute();
                    $welrows11 = $nstmt1->fetch(PDO::FETCH_ASSOC);
			       $totalstory = $welrows11['total'];
				  // echo "total story".$totalstory;
			/**********************************************************************************/  
				  $eventquery = "select distinct(storyId) from Tbl_Analytic_StorySentToGroup where groupId IN('".$in."') and clientId =:cid order by autoId desc limit $val, 5";
										
                    $nstmt = $this->DB->prepare($eventquery);
                    $nstmt->bindParam(':cid',$this->idclient, PDO::PARAM_STR);
                    $nstmt->execute();
                    $welrows = $nstmt->fetchAll(PDO::FETCH_ASSOC);
			        $postarray = array();
						foreach($welrows as $postid)
						{
						array_push($postarray,$postid['storyId']);
						}
						
						/*echo "<pre>";
						print_r($postarray);
						echo "</pre>";
						*/
						 $unique_postid = array_values(array_unique($postarray));
						 $totalpost = count($unique_postid);
                          //   print_r($unique_postid);      
						
	/********************************************************************/
	
						$post = array();
						$result['success'] = 1;
						$result['message'] = "data found";
						$result['totalpost'] = $totalstory;
						$result['posts'] = array();
						$welcount = count($unique_postid);
						//echo "total post".$welcount."<br>";
						for($w=0;$w<$welcount;$w++)
						{
							 $postid = $unique_postid[$w];
							 //$clientid = $welrows[$w]['clientId'];
							  //echo $postid."<br>";
							  $query3 = "select count(likeBy) as total_likes from Tbl_Analytic_PostLike where postId=:pstid and clientId=:cli";
							 $stmt3 = $this->DB->prepare($query3);
							 $stmt3->bindParam(':pstid',$postid, PDO::PARAM_STR);
							 $stmt3->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
							 $stmt3->execute();
							 $rows3 = $stmt3->fetch(PDO::FETCH_ASSOC);
							 $post["total_likes"]=$rows3["total_likes"];

							 $query4 = "select count(commentBy) as total_comments from Tbl_Analytic_PostComment where postId=:pstid and clientId=:cli";
							 $stmt4 = $this->DB->prepare($query4);
							 $stmt4->bindParam(':pstid',$postid, PDO::PARAM_STR);
							 $stmt4->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
							 $stmt4->execute();
							 $rows4 = $stmt4->fetch(PDO::FETCH_ASSOC);
							 $post["total_comments"]=$rows4["total_comments"];

							 $query2 = "select * , concat('".site_url."',imagePath) as imagePath , DATE_FORMAT(createdDate,'%d %b %Y') as createdDate from Tbl_C_AchiverStory where storyId=:pstid and clientId=:cli order by storyId";
							 $stmt2 = $this->DB->prepare($query2);
							 $stmt2->bindParam(':cli',$this->idclient, PDO::PARAM_STR);
							 $stmt2->bindParam(':pstid',$postid, PDO::PARAM_STR);
							 $stmt2->execute();
							 $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);

							
							$post["storyId"] = $rows2["storyId"];
							$post["clientId"] = $rows2["clientId"];
							$post["title"]=$rows2["title"];
							$post["imagePath"]=$rows2["imagePath"];
							
							$post["story"]=$rows2["story"];
							$post["flagtype"]=$rows2["flagType"];

							$post["createdDate"]=$rows2["createdDate"];
							$post["likeType"]=$rows2["likeType"];
							$post["comment"]=$rows2["comment"];
							$post["createdBy"]=$rows2["createdBy"];
							$uui = $post["createdBy"];

							 $query = "select Tbl_EmployeeDetails_Master.firstName, if(Tbl_EmployeePersonalDetails.userImage IS NULL or Tbl_EmployeePersonalDetails.userImage='', '', if(Tbl_EmployeePersonalDetails.linkedIn = '1', Tbl_EmployeePersonalDetails.userImage, Concat('".site_url."',Tbl_EmployeePersonalDetails.userImage))) as UserImage 
							 from Tbl_EmployeeDetails_Master join Tbl_EmployeePersonalDetails on Tbl_EmployeePersonalDetails.employeeId = Tbl_EmployeeDetails_Master.employeeId
							 where Tbl_EmployeeDetails_Master.clientId=:cli and Tbl_EmployeePersonalDetails.employeeId=:empid and Tbl_EmployeeDetails_Master.employeeId=:empid";
							 $stmt = $this->DB->prepare($query);
							 $stmt->bindParam(':cli',$clientid, PDO::PARAM_STR);
							 $stmt->bindParam(':empid',$uui, PDO::PARAM_STR);
							 $stmt->execute();
							 $rows = $stmt->fetch(PDO::FETCH_ASSOC);
							$post["UserName"]=$rows["firstName"];
							$post["UserImage"]=$rows["UserImage"];

							array_push($result["posts"],$post);
									   
						}

    /************************************************************************************************/
						$datacount = count($post);
						//echo $datacount;
						if($datacount < 1)
						{
						$result['success'] = 0;
						$result['message'] = "No Post Available";
						return $result;
						}
						else
						{
						 return $result;
						}
                }
            }
		    else
		    {
		       $result['success'] = 0;
			   $result['message'] = "Sorry You are not Authorized";
			   return $result;
		  
		    }
		 
        }
        catch(PDOException $e)
	    {
		   echo $e;
		   $result['success'] = 0;
		   $result['message'] = "data not fount found ".$e;
		   return $result;
	    }
    }
}
?>