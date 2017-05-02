<?php
if(!class_exists("Connection_Communication")){include_once('class_connect_db_Communication.php');}
class Group
{
  public $DB;
  public function __construct()
  {
      $db = new Connection_Communication();
      $this->DB = $db->getConnection_Communication();
  }
  
  
  function getGroup($clientid)
  {
     $this->clientid = $clientid;
     
     try{
     $query = "select * from Tbl_ClientGroupDetails where clientId=:cli order by autoid desc";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
           if($rows)
           {
           $result=array();

           $result['success'] = 1;
           $result['message'] = "successfully fetch data";
           $result['posts']=$rows;

           return json_encode($result);
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

  function getGroupDetails($clientid,$groupid)
  {
     $this->clientid = $clientid;
     $this->groupid = $groupid;
     
     try{
     $query = "select * from Tbl_ClientGroupDetails where clientId=:cli and groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
           if($rows)
           {
           $result=array();

           $result['success'] = 1;
           $result['message'] = "successfully fetch data";
           $result['posts']=array();

foreach($rows as $row)
{
$post["clientId"]=$row["clientId"];
$post["groupId"]=$row["groupId"];
$post["groupName"]=$row["groupName"];
$post["groupDescription"]=$row["groupDescription"];

$idclient = $row["clientId"];
$idgroup = $row["groupId"];

$post["adminEmails"]=array();

     $query = "select ud.* from Tbl_EmployeeDetails_Master As ud join Tbl_ClientGroupAdmin as cga on cga.userUniqueId = ud.employeeId
      where cga.clientId=:cli and cga.groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt->execute();
            $row1 = $stmt->fetchAll();
          
if($row1)
{
 foreach($row1 as $r)
 {
   $new["adminEmail"]= $r["firstName"]." ".$r["lastName"]." (".$r["emailId"].")";
   array_push($post["adminEmails"],$new);
 }
}

$post["branch"]=array();
$post["departments"]=array();

     $query1 = "select * from Tbl_ClientGroupDemoParam where clientId=:cli and groupId=:gid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt1->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt1->execute();
            $row2 = $stmt1->fetchAll();
if($row2)
{
 foreach($row2 as $row)
 {
   $baseone = $row["columnName"];

if($baseone=='branch')
{   
$new1["columnValue"]=$row["columnValue"];
array_push($post["branch"],$new1);
}
else
{
$new1["columnValue"]=$row["columnValue"];
array_push($post["departments"],$new1);
}

 }
}

array_push($result['posts'],$post);
}

           return json_encode($result);
           }
       }
       catch(PDOException $ex)
       {
       echo $ex;
       }
}

function GrgetGroupDetails($clientid,$groupid)
  {
     $this->clientid = $clientid;
     $this->groupid = $groupid;
     
     try{
     $query = "select * from Tbl_ClientGroupDetails where clientId=:cli and groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $this->clientid, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $this->groupid, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetchAll();
           if($rows)
           {

           $result=array();
           $result['success'] = 1;
           $result['message'] = "successfully fetch data";
           $result['posts']=array();

$idclient = $rows[0]["clientId"];
$idgroup = $rows[0]["groupId"];


     $query = "select adminEmail from Tbl_ClientGroupAdmin where clientId=:cli and groupId=:gid";
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt->execute();
            $row1 = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$post["groupName"]=$rows[0]["groupName"];
$post["groupDescription"]=$rows[0]["groupDescription"];
$post["adminEmails"] =$row1; 
$post["demographics"] = array();

     $query1 = "select distinct(columnName) from Tbl_ClientGroupDemoParam where clientId=:cli and groupId=:gid";
            $stmt1 = $this->DB->prepare($query1);
            $stmt1->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt1->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt1->execute();
            $row2 = $stmt1->fetchAll();
if($row2)
{
/*$count = count($row2["columnName"]);
echo "Total no. records executed:- ".$count."<br>";
*/

foreach($row2 as $row)
{
$baseon = $row["columnName"];
     $query2 = "select columnValue from Tbl_ClientGroupDemoParam where clientId=:cli and groupId=:gid and columnName=:col";
            $stmt2 = $this->DB->prepare($query2);
            $stmt2->bindParam(':cli', $idclient, PDO::PARAM_STR);
            $stmt2->bindParam(':gid', $idgroup, PDO::PARAM_STR);
            $stmt2->bindParam(':col', $baseon, PDO::PARAM_STR);
            $stmt2->execute();
            $row3 = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);

         if($row3)
            {
                 $postr["columnName"]=$baseon;
                 $postr["columnValue"]=$row3;
                 array_push($post["demographics"],$postr);
            }
   }

}
$result["posts"] = $post;

           return json_encode($result);
	    }
     }
       catch(PDOException $ex)
       {
       echo $ex;
       }
   }
   
   /*************************** get custom group user ********************************/
   
 function getCustomGroupUser($clientid,$groupids)
 {
     $count1 = count($groupids);
   //  print_r($count1);
            $allrows1 = array();
       for ($t = 0; $t < $count1; $t++)     {

                $groupid = $groupids[$t];
              //  echo $groupid;
            
   try{
       $query = "select master.employeeId from Tbl_CustomGroupDetails as custom join Tbl_EmployeeDetails_Master as master on master.employeeCode = custom.employeeId where custom.clientId = :cid and custom.groupId = :gid";
       $stmt2 = $this->DB->prepare($query);
            $stmt2->bindParam(':cid',$clientid, PDO::PARAM_STR);
            $stmt2->bindParam(':gid',$groupid, PDO::PARAM_STR);
            $stmt2->execute();
                 $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                 
         for($r=0;$r<count($rows2);$r++)
         {
          //  echo  $rows2[$r]['employeeId'];
             array_push($allrows1, $rows2[$r]['employeeId']);
         }
                              
            
 }  catch (PDOException $es)
 {
     echo $es;
 }
   
       }
          return json_encode($allrows1);
}
/********************** get custom group details **********************/

function getCustomGroupDetails($groupid,$cid)
{           
   try{
       $query = "select groupId from Tbl_ClientGroupDetails where clientId = :cid and groupId = :gid and status = 'active' and groupType = 2" ;
      
	  $stmt2 = $this->DB->prepare($query);
            $stmt2->bindParam(':cid',$cid, PDO::PARAM_STR);
            $stmt2->bindParam(':gid',$groupid, PDO::PARAM_STR);
            $stmt2->execute();
            $rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $result=array();
			if(count($rows2['groupId']) > 0)
			{
			$query1 = "select cgd.groupId, tcgd.groupName, tcgd.groupDescription , cgd.employeeId as empcode, edm.employeeId,CONCAT(edm.firstName,' ',edm.middleName,' ',edm.lastName) as empname , edm.emailId, edm.contact , edm.department,edm.designation,edm.location,edm.status,edm.accessibility,edm.branch from Tbl_CustomGroupDetails as cgd JOIN Tbl_EmployeeDetails_Master as edm ON cgd.employeeId = edm.employeeCode JOIN Tbl_ClientGroupDetails as tcgd ON cgd.groupId = tcgd.groupId where cgd.clientId = :cid and cgd.groupId = :gid and cgd.status = 'Active'";
      
	        $stmt3 = $this->DB->prepare($query1);
            $stmt3->bindParam(':cid',$cid, PDO::PARAM_STR);
            $stmt3->bindParam(':gid',$groupid, PDO::PARAM_STR);
            $stmt3->execute();
            $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
			
			   if($rows3)
			   {
			   $result['success'] = 1;
			   $result['message'] = "data fetch successfully";
			   $result['posts']=$rows3;    
			   } 
			   else
			   {
			   $result['success'] = 0;
			   $result['message'] = "data not fetch";
			   }	
			}
			else
			{
			$result['success'] = 0;
			$result['message'] = "No Group Available";
			}					
	  }  
	  catch (PDOException $es)
      {
		 $result['success'] = 0;
		 $result['message'] = "data not fetch ".$es;	
     }
          return json_encode($result);
}

/******************** / get custom group details **********************/
}
?>