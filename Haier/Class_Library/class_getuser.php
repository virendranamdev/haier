<?php
include_once('class_connect_db_Communication.php');

class GetUser
{
    
    public $DB;
  public function __construct()
  {
	$db = new Connection_Communication();
      	$this->DB = $db->getConnection_Communication();

  }

  public $postid;
 public $cid;
  function getAllUser($cid)
  {
  $this->cid = $cid;
      $query = "select ud.*,up.* from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId  where ud.clientId =:cid order by ud.createdDate desc";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute(array(':cid'=>$this->cid));
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
    	 return json_encode($rows);
		
      
  }

/* this is unuse

  function getSinglePost($pid)
  {
     $this->postid = $pid;
    
     try{
     $query = "Select * from PostDetails where post_id =:pid";
             $stmt = $this->DB->prepare($query);
             $stmt->bindParam(':pid',$this->postid, PDO::PARAM_STR);
             
             if($stmt->execute())
                  {
                  $rows = $stmt->fetchAll();
    	           return json_encode($rows);
                  }
     }
     catch(PDOException $e)
     {
     echo $e;
     }
  }
  
  function getIndexPost()
  {
	  $query = "select * from PostDetails order by created_date desc limit 0,3";
	  try
	  {
		 $stmt = $this->DB->prepare($query); 
		 $stmt->execute();
	  }
         
         catch(PDOException $e)
         {
         echo $e;
         }

 	  $rows = $stmt->fetchAll();
    	 return json_encode($rows);
        //  }
		  
  }*/
  
/************************* update user status ***************************/
function updateUserStatus($empid, $sta,$access) 
    {
        $this->empid = $empid;
        $this->status = $sta;
     if($access == 'User')
     {
         try {        
             $query1 = "update Tbl_EmployeeDetails_Master set status=:sta where employeeId =:sid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':sid1', $this->empid, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $this->status, PDO::PARAM_STR);
            $stmt1->execute();
	
            if ($stmt1->execute()) 
                {
                $response["success"] = 1;
                $response["message"] = "status change now";              
            }
        } catch (PDOException $e) {
          //  echo $e;
             $response["success"] = 0;
                $response["message"] = "there is some problem please contact info@benepik.com".$e;
        }
         
     }
 else {
         
      try {        
             $query1 = "update Tbl_EmployeeDetails_Master set status=:sta where employeeId =:sid1";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':sid1', $this->empid, PDO::PARAM_STR);
            $stmt1->bindParam(':sta', $this->status, PDO::PARAM_STR);
            $stmt1->execute();
			
			$query2 = "update Tbl_ClientGroupAdmin set status = 0 where userUniqueId = :sid2";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':sid2', $this->empid, PDO::PARAM_STR);
            //$stmt2->bindParam(':sta2', $this->status, PDO::PARAM_STR);
            $stmt2->execute();
	
            $query = "update Tbl_ClientAdminDetails set status= :sta1 where userUniqueId =:sid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':sid', $this->empid, PDO::PARAM_STR);
            $stmt->bindParam(':sta1', $this->status, PDO::PARAM_STR);
            if ($stmt->execute()) 
                {
                $response["success"] = 1;
                $response["message"] = "status change now";              
            }
        } catch (PDOException $e) {
          //  echo $e;
             $response["success"] = 0;
                $response["message"] = "there is some problem please contact info@benepik.com".$e;
        }
 }
        
       
         return json_encode($response);
    }
/********************* / update user *************************************/
}
?>