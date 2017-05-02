<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include_once('class_connect_db_Communication.php');

if (!class_exists('FindGroup')) {
    require_once('Api_Class/class_find_groupid.php');
}

class MyLearning 
{

    public $DB;

    public function __construct() {
        $db = new Connection_Communication();
        $this->DB = $db->getConnection_Communication();
    }
    
    
    function createMyLearning($clientid, $learningtitle, $learningimg, $createdby, $createddate,$status) 
                {
    // echo $status;
        try {
                $query = "insert into Tbl_C_Mylearning(clientId,learningName,learningImg,createdBy,createdDate, status)values(:cid,:lname,:limg, :createdby,  :createddate,:status )";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
                $stmt->bindParam(':lname', $learningtitle, PDO::PARAM_STR);
                $stmt->bindParam(':limg',$learningimg, PDO::PARAM_STR);
                 $stmt->bindParam(':createdby',$createdby, PDO::PARAM_STR);
                 $stmt->bindParam(':createddate',$createddate, PDO::PARAM_STR);                
                 $stmt->bindParam(':status',$status, PDO::PARAM_STR);
                          
                $stmt->execute();
                $last_id = $this->DB->lastInsertId(); 
                
                $result['success'] = 1;
                $result['message'] = "learning is successfully created";
                $result['lastid'] = $last_id;
                return($result);
            
        } catch (PDOException $e) {
            echo $e;
        }
    }
    
    /********************************create my learning file ******************************/
    
       
    function createMyLearningFile($learningid,$filetitle, $learningimgname, $createdby, $createddate,$status) {
 
        try {

                $query = "insert into Tbl_C_Mylearningfile(learningId,fileName,filepath,createdBy,createdDate,status)values(:lid,:fname,:fpath,:createdby, :createddate,:sts)";
                $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':lid', $learningid, PDO::PARAM_STR);
                $stmt->bindParam(':fname', $filetitle, PDO::PARAM_STR);
                $stmt->bindParam(':fpath', $learningimgname, PDO::PARAM_STR);
                $stmt->bindParam(':createdby', $createdby, PDO::PARAM_STR);
                $stmt->bindParam(':createddate', $createddate, PDO::PARAM_STR);
                $stmt->bindParam(':sts', $status, PDO::PARAM_STR);
                
                $stmt->execute();

                $result['success'] = 1;
                $result['message'] = "file created";
                return($result);
            
        } catch (PDOException $e) {
            echo $e;
        }
    }
    
    /********************************create my learning file ******************************/
    
    function getMyLearning($clientId)
    {
      
        try {
             $query = "SELECT *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate  FROM Tbl_C_Mylearning where clientId = :cid";
              $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':cid', $clientId, PDO::PARAM_STR);
                 $stmt->execute();
              $res =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                
             
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $result['success'] = 0;
                $result['message'] = "error";
                 $result['data'] =  '';
        }
        
        return(json_encode($res));
        }
    
        /***************************************************************************/
        
         function getMyLearningFile($learningid)
         {
      
        try {
             $query = "SELECT *,DATE_FORMAT(createdDate,'%d %b %Y %h:%i %p') as createdDate FROM Tbl_C_Mylearningfile where learningId = :lid";
              $stmt = $this->DB->prepare($query);
                $stmt->bindParam(':lid', $learningid, PDO::PARAM_STR);
                 $stmt->execute();
              $res =  $stmt->fetchAll(PDO::FETCH_ASSOC);
           
             
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            $result['success'] = 0;
                $result['message'] = "error";
                 $result['data'] =  '';
        }
        
        return(json_encode($res));
        }
    
        
        /**********************************************/
         function deleteMyLearningFile($learningid,$fid)
         {
      echo $fid;
        try {
             $query1 = "DELETE FROM Tbl_C_Mylearningfile where learningId = :lid and fileId=:fid";
              $stmt = $this->DB->prepare($query1);
                $stmt->bindParam(':lid', $learningid, PDO::PARAM_STR);
                 $stmt->bindParam(':fid', $fid, PDO::PARAM_STR);
                $stmt->execute();
               
                $result['success'] = 1;
                $result['message'] = "File Successfully Deleted";
                
               
             
        } catch (Exception $exc) {
            echo $exc;
             $result['success'] = 0;
                $result['message'] = "File not Deleted".$exc;
        }
        
        return(json_encode($result));
        }
        
}
?>