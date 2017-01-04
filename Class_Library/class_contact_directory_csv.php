<?php
session_start();
require_once('class_connect_db_Communication.php');

class ContactDirectory
{

  public $DB;
  public function __construct()
  {
    $db = new Connection_Communication();
      $this->DB = $db->getConnection_Communication();
  }
  
public $filename;
public $filetempname;
public $fullcsvpath;
public $client_id;
public $createdby;

function uploadUserCsv($clientid1,$user,$file_name,$file_temp_name,$fullpath) 
{

$this->fullcsvpath = $fullpath;
  
date_default_timezone_set('Asia/Calcutta');
$c_date = date('Y-m-d H:i:s');
    $status = "Active";
    $access = "User";
    $this->client_id = $clientid1;
    $user_session = $_SESSION['user_unique_id'];
   //echo "this is sessionid -".$user_session."\n";
    $this->createdby = $user;
  //  echo "user unique id := ".$this->createdby;
      $this->filename = $file_name;
      $this->filetempname = $file_temp_name;
      $target_file = basename($this->filename);
      
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

      if($imageFileType != "csv") 
      {
       echo "Sorry, only .csv files are allowed.";
    $uploadOk = 0;
      }
    else
    {
    $handle = fopen($this->filetempname, "r");
             while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
            {
                  $userdata[] = $data;
            }
    
   /**************start insert into database **************************************************/
   
    // print_r($userdata);
      $countrows = count($userdata);
      if($countrows>200)
      {
      echo "<script>alert(Sorry! You can't upoad data more than 200 employee at a time) </script>";
      }
     // echo $countrows;
     /*****************************fetch existing admin details (emaild)**************************************/
//     echo "<pre>";
 //    print_r($userdata);
   //  echo "</pre>";
     try{
                  for($row=1; $row<$countrows; $row++)
                  {
                  
                  $lname  = $userdata[$row][0];
                  $lId = self::checklocation($this->client_id,$lname);
                  //echo "this is locationid -".$lId;
                  $dname  = $userdata[$row][1];
                  $dId = self::checkdept($this->client_id,$dname, $lId);
                  //echo "\n  this is deptid -".$dId;
                 
                 /******************************************************************************/
                 
                  try{
			$max = "select max(autoId) from Tbl_ContactDirectoryPerson";
			$query = $this->DB->prepare($max);
			if($query->execute())
			{
				$tr  = $query->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$contid1 = "CP-".$m_id1;
				
				 }
				
	               }
		      catch(PDOException $e)
			{
				echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
                 
                 $pquery = "insert into Tbl_ContactDirectoryPerson(contactId, clientId, locationId, departmentId, imgPath, userName, contactNoPersonal, contactNoOffice, designation, emailId, status, createdDate, createdBy, updatedDate, updatedBy )values(:contactId, :clientId, :locationId, :departmentId, :imgPath,:userName, :contactNoPersonal, :contactNoOffice, :designation, :emailId, :status, :createdDate, :createdBy, :updatedDate, :updatedBy)";
                 
                 $img = "";
                 $status = "Active";
                 
                $pstmt = $this->DB->prepare( $pquery);
		$pstmt->bindParam(':contactId',$contid1 , PDO::PARAM_STR);
		$pstmt->bindParam(':clientId',$this->client_id, PDO::PARAM_STR);
		$pstmt->bindParam(':locationId',$lId , PDO::PARAM_STR);
		$pstmt->bindParam(':departmentId',$dId , PDO::PARAM_STR);
		$pstmt->bindParam(':imgPath',$img, PDO::PARAM_STR);
		//$pstmt->bindParam(':userUniqueId',$img, PDO::PARAM_STR);
		$pstmt->bindParam(':userName',$userdata[$row][2], PDO::PARAM_STR);
		$pstmt->bindParam(':contactNoPersonal',$userdata[$row][5], PDO::PARAM_STR);
		$pstmt->bindParam(':contactNoOffice',$userdata[$row][4], PDO::PARAM_STR);
		$pstmt->bindParam(':designation',$userdata[$row][3], PDO::PARAM_STR);
		$pstmt->bindParam(':emailId',$userdata[$row][6], PDO::PARAM_STR);
		$pstmt->bindParam(':status', $status, PDO::PARAM_STR);
		$pstmt->bindParam(':createdDate',$c_date, PDO::PARAM_STR);
		$pstmt->bindParam(':createdBy',$user_session, PDO::PARAM_STR);
		$pstmt->bindParam(':updatedDate',$img, PDO::PARAM_STR);
		$pstmt->bindParam(':updatedBy',$img, PDO::PARAM_STR);
		
		$res = $pstmt->execute();
        $response["posts"] = array();
		if($res)
		{
			$response["success"] = 1;
            $response["msg"] = "Data Successfully uploaded";
            return json_encode($response);
		}
                 
                  
                  }
                  
            }
		    catch(PDOException $e)
			{
				
		    $response["success"] = 1;
            $response["msg"] =  $e;;
            return json_encode($response);
				
				//trigger_error('Error occured inserting data : '. $e->getMessage(), E_USER_ERROR);
			}
 
}	

}
function checklocation($cli,$locationname)
{
$lquery = "select * from Tbl_ContactDirectoryLocation where locationName = :lname";
 $lstmt = $this->DB->prepare( $lquery);
                    $lstmt->bindParam(':lname',$locationname, PDO::PARAM_STR);
 $lstmt->execute();
 $res = $lstmt->fetchAll(PDO::FETCH_ASSOC);
 //print_r($res);
  if(count($res)>0)
  {
  $locationid = $res[0]['locationID'];
  return $locationid;
  }
  else
  {
    try{
			$max = "select max(autoId) from Tbl_ContactDirectoryLocation";
			$query = $this->DB->prepare($max);
			if($query->execute())
			{
				$tr  = $query->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$locationid1 = "L-".$m_id1;
				
				 }
				
	               }
		      catch(PDOException $e)
			{
				echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
  
   /*********************************************************************/
              
                  $locationquery = "insert into Tbl_ContactDirectoryLocation(locationId,clientId,locationName)values(:lid,:cid,:lname)";
                  $locationstmt = $this->DB->prepare( $locationquery);
                    $locationstmt->bindParam(':lid',$locationid1, PDO::PARAM_STR);
                    $locationstmt->bindParam(':cid',$cli, PDO::PARAM_STR);
                    $locationstmt->bindParam(':lname',$locationname, PDO::PARAM_STR);
                    $locationstmt->execute();
  	return $locationid1;
  }

}


/**************************************************************************/

function checkdept($cli,$deptname,$lId)
{
$lquery = "select * from Tbl_ContactDirectoryDepartment where departmentName = :lname and locationId = :lid";
 $lstmt = $this->DB->prepare( $lquery);
                    $lstmt->bindParam(':lname',$deptname, PDO::PARAM_STR);
                    $lstmt->bindParam(':lid',$lId, PDO::PARAM_STR);
 $lstmt->execute();
 $res = $lstmt->fetchAll(PDO::FETCH_ASSOC);
 //print_r($res);
  if(count($res)>0)
  {
  $deptid = $res[0]['deptId'];
  return $deptid;
  }
  else
  {
    try{
			$max = "select max(autoId) from Tbl_ContactDirectoryDepartment";
			$query = $this->DB->prepare($max);
			if($query->execute())
			{
				$tr  = $query->fetch();
				$m_id = $tr[0];
				$m_id1 = $m_id+1;
				$deptid1 = "Dept-".$m_id1;
				
				 }
				
	               }
		      catch(PDOException $e)
			{
				echo $e;
				trigger_error('Error occured fetching max autoid : '. $e->getMessage(), E_USER_ERROR);
			}
  
   /*********************************************************************/
              
                  $deptquery = "insert into Tbl_ContactDirectoryDepartment(deptId, clientId, locationId, departmentName)values(:did,:cid,:lid, :dname)";
                  $deptstmt = $this->DB->prepare( $deptquery);
                    $deptstmt->bindParam(':did',$deptid1, PDO::PARAM_STR);
                    $deptstmt->bindParam(':cid',$cli, PDO::PARAM_STR);
                    $deptstmt->bindParam(':lid',$lId, PDO::PARAM_STR);
                    $deptstmt->bindParam(':dname',$deptname, PDO::PARAM_STR);
                    $deptstmt->execute();
  	return $deptid1;
  }

}

}
?>