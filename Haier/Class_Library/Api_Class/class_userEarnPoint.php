<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!class_exists('Connection_Communication')) {
    include("class_connect_db_Communication.php");
}

class EarningPoint {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    function checkUserEntry($flagtype, $employeeID, $postid) {
        try {
            if ($postid == '') {
                $query = "select * from Tbl_User_SelfEarningPoint where employeeId=:empid and flagType=:ftype";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':empid', $employeeID, PDO::PARAM_STR);
                $stmt->bindParam(':ftype', $flagtype, PDO::PARAM_STR);
            } else {
                $query = "select * from Tbl_User_SelfEarningPoint where employeeId=:empid and flagType=:ftype and postId =:pid";
                $stmt = $this->db_connect->prepare($query);
                $stmt->bindParam(':empid', $employeeID, PDO::PARAM_STR);
                $stmt->bindParam(':ftype', $flagtype, PDO::PARAM_STR);
                $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            }
            //    $stmt->bindParam(':dev', $device, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ************************* Add reward for login ************************************* */

    public function addloginReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $login_date = date('Y-m-d H:i:s');
        $module = "Login";
        $loginpoint1 = self::getModulePoint($flag);

        $loginpoint = $loginpoint1[0]['points'];
        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $loginpoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $login_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);

                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $loginpoint;
                } else {
                    $finalbalance = $loginpoint;
                }

                $flag = 0;             // 0:this for credit 1: for debit
                $desc = "Earn:By First Login";
                $recogid = $last_id;
                $sid = 1;                   // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $loginpoint, $finalbalance, $login_date);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    
     /*     * ***************************** earned by Birthday *************************** */

    public function addBirthdayReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $entry_date = date('Y-m-d H:i:s');
        $module = "Birthday";
        $modulepoint1 = self::getModulePoint($flag);

        $birthdaypoint = $modulepoint1[0]['points'];

        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $birthdaypoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $entry_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);
                //print_r($existinguserbalance);
                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $birthdaypoint;
                } else {
                    $finalbalance = $birthdaypoint;
                }

                $flag = 0;   // 0:this for credit 1: for debit
                $desc = "Earn:By Birthday";
                $recogid = $last_id;
                $sid = 1;                    // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $birthdaypoint, $finalbalance, $entry_date);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

     /*     * ***************************** earned by work Anniversary *************************** */

    public function addAnniversaryReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $entry_date = date('Y-m-d H:i:s');
        $module = "Work Anniversary";
        $modulepoint1 = self::getModulePoint($flag);

        $anniversarypoint = $modulepoint1[0]['points'];

        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $anniversarypoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $entry_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);
                //print_r($existinguserbalance);
                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $anniversarypoint;
                } else {
                    $finalbalance = $anniversarypoint;
                }

                $flag = 0;   // 0:this for credit 1: for debit
                $desc = "Earn:By Work Anniversary";
                $recogid = $last_id;
                $sid = 1;                    // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $anniversarypoint, $finalbalance, $entry_date);
            }   
        } catch (PDOException $e) {
            echo $e;
        }
    }

    
    
    
    /*     * ***************************** earned by suggestion *************************** */

    public function addSuggestionReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $entry_date = date('Y-m-d H:i:s');
        $module = "Suggestion";
        $suggestionpoint1 = self::getModulePoint($flag);

        $suggestionpoint = $suggestionpoint1[0]['points'];

        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $suggestionpoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $entry_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);
                //print_r($existinguserbalance);
                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $suggestionpoint;
                } else {
                    $finalbalance = $suggestionpoint;
                }

                $flag = 0;   // 0:this for credit 1: for debit
                $desc = "Earn:By Suggestion";
                $recogid = $last_id;
                $sid = 1;                    // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $suggestionpoint, $finalbalance, $entry_date);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************** earned by grievances *************************** */

    public function addGrievanceReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $entry_date = date('Y-m-d H:i:s');
        $module = "Grievance";
        $modulepoint = self::getModulePoint($flag);

        $grievancepoint = $modulepoint[0]['points'];

        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $grievancepoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $entry_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);
                //print_r($existinguserbalance);
                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $grievancepoint;
                } else {
                    $finalbalance = $grievancepoint;
                }

                $flag = 0;   // 0:this for credit 1: for debit
                $desc = "Earn:By Grievance";
                $recogid = $last_id;
                $sid = 1;                    // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $grievancepoint, $finalbalance, $entry_date);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************** earned by like *************************** */

    public function addpostLikeReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $entry_date = date('Y-m-d H:i:s');
        $module = "Post Like";
        $modulepoint = self::getModulePoint($flag);

        $likepoint = $modulepoint[0]['points'];

        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $likepoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $entry_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);
                //print_r($existinguserbalance);
                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $likepoint;
                } else {
                    $finalbalance = $likepoint;
                }

                $flag = 0;   // 0:this for credit 1: for debit
                $desc = "Earn:By Like";
                $recogid = $last_id;
                $sid = 1;                    // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $likepoint, $finalbalance, $entry_date);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

    /*     * ***************************** earned by comment *************************** */

    public function addpostcommenteReward($client_id, $employeeId, $flag, $postid) {

        date_default_timezone_set('Asia/Kolkata');
        $entry_date = date('Y-m-d H:i:s');
        $module = "Post Comment";
        $modulepoint = self::getModulePoint($flag);

        $commentpoint = $modulepoint[0]['points'];

        try {
            $query = "insert into Tbl_User_SelfEarningPoint(clientId, employeeId, postId, module,flagType, amount, entryDate) values(:client_id, :empid,:pid, :module,:flag, :amount, :date)";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':pid', $postid, PDO::PARAM_STR);
            $stmt->bindParam(':module', $module, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $commentpoint, PDO::PARAM_STR);

            $stmt->bindParam(':date', $entry_date, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $last_id = $this->db_connect->lastInsertId();
                $existinguserbalance = self::getUserbalance($employeeId);
                //print_r($existinguserbalance);
                if (count($existinguserbalance) > 0) {
                    $finalbalance = $existinguserbalance[0]['balance'] + $commentpoint;
                } else {
                    $finalbalance = $commentpoint;
                }

                $flag = 0;   // 0:this for credit 1: for debit
                $desc = "Earn:By Comment";
                $recogid = $last_id;
                $sid = 1;                    // 1:for self earning  2:earned by recognization
                self::addUserbalance($client_id, $employeeId, $desc, $recogid, $sid, $flag, $commentpoint, $finalbalance, $entry_date);
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
    
    
     /*     * ******************************************************* */

    function getUserAccount($employeeId) {
        try {
                    $query = "select if(SUM(amount)='' or SUM(amount) IS NULL ,'0',SUM(amount)) as total from Tbl_User_Transaction where employeeId =:eid and flag = '0'";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':eid', $employeeId, PDO::PARAM_STR);
            $stmt->execute();
            $restotal = $stmt->fetch(PDO::FETCH_ASSOC);
         
           /**************************************/
            
            $query2 = "select if(SUM(amount)='' or SUM(amount) IS NULL ,'0',SUM(amount)) as redeemed from Tbl_User_Transaction where employeeId =:eid and flag = '1'";
            $stmt2 = $this->db_connect->prepare($query2);
            $stmt2->bindParam(':eid', $employeeId, PDO::PARAM_STR);
            $stmt2->execute();
            $restotal2 = $stmt2->fetch(PDO::FETCH_ASSOC);
           
            $response['success']=1;
            $response['total']= $restotal['total'];
            $response['redeemed']=$restotal2['redeemed'];
           
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $response;
    }
    
    /*     * ******************************************************* */

   

    /*     * ************************************************************************************************** */
    /*     * ************************************************************************************************** */
    /*     * ************************************************************************************************** */

    function getModulePoint($flagType) {
        try {
            $query = "select points from Tbl_User_EarningModule where flagType = :flag and status = 1";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':flag', $flagType, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $result;
    }

    /*     * ******************************************************* */

    function getUserbalance($employeeId) {
        try {
                $query = "select balance from Tbl_User_Transaction where employeeId =:eid order by autoId desc";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':eid', $employeeId, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return $result1;
    }

    /*     * ******************************************************* */

    function addUserbalance($clientId, $employeeId, $desc, $recogid, $sid, $flag, $amount, $balance, $date) {
        try {
            $query1 = "insert into Tbl_User_Transaction(clientId, employeeId,description,recognizeId,selfId,flag, amount, balance,entryDate) values(:client_id, :empid,:desc,:rid,:sid,:flag, :amount,:balance, :date)";
            $stmt = $this->db_connect->prepare($query1);
            $stmt->bindParam(':client_id', $clientId, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
            $stmt->bindParam(':rid', $recogid, PDO::PARAM_STR);
            $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
            $stmt->bindParam(':flag', $flag, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
            $stmt->bindParam(':balance', $balance, PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $exc) {
            echo $exc;
        }
    }

    /*     * ************************************** Account Summery ************************************** */

    function getUserAccountSummery($clientid, $employeeId) {
        try {
            $query = "SELECT DATE_FORMAT( entryDate, '%d %b %Y' ) AS entryDate, tut.employeeId, tut.flag, tut.amount, tut.balance,tut.selfid,tut.recognizeId,if(tut.selfid = 1,(select postId from Tbl_User_SelfEarningPoint where autoId = tut.recognizeId),'') as postid,
if(tut.selfid = 1,(select flagType from Tbl_User_SelfEarningPoint where autoId = tut.recognizeId),'') as moduleType
    FROM Tbl_User_Transaction AS tut
    WHERE tut.employeeId = :eid
    AND tut.clientId = :cid 
    ORDER BY autoId";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':eid', $employeeId, PDO::PARAM_STR);
            $stmt->bindParam(':cid', $clientid, PDO::PARAM_STR);
            $stmt->execute();
            $result1 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalres = count($result1);
            if($totalres>0)
            {
            $result = array();
            for ($k = 0; $k < $totalres; $k++) {
                $result[$k]['entryDate'] = $result1[$k]['entryDate'];
                $result[$k]['employeeid'] = $result1[$k]['employeeId'];
                /*                 * ***************************** Earn Redeem ed ******************** */
                if ($result1[$k]['flag'] == 0) {
                    $result[$k]['earn'] = $result1[$k]['amount'];
                    $result[$k]['redeemed'] = 0;
                } else {
                    $result[$k]['earn'] = 0;
                    $result[$k]['redeemed'] = $result1[$k]['amount'];
                    $result[$k]['description'] = "Redeemed";
                    ;
                }
                /*                 * ***************************** Earn Redeem ed ******************** */
                if ($result1[$k]['selfid'] == 1) {
                    $flagType = $result1[$k]['moduleType'];
                   
                    switch ($flagType) {
                        case 1:
                            $result[$k]['description'] = "First Login"; 
                            break;
                        case 2:
                            $result[$k]['description'] = "Birthday";
                            break;
                        case 3:
                            $result[$k]['description'] = "Work Anniversary";
                            break;
                        case 4:
                            $result[$k]['description'] = "Like Post";
                            break;
                        case 5:
                            $result[$k]['description'] = "Comment Post";
                            break;
                        case 6:
                            $result[$k]['description'] = "Suggestion";
                            break;
                        case 7:
                            $result[$k]['description'] = "Grievance ";
                            break;
                        case 8:
                            $result[$k]['description'] = "Like Album";
                            break;
                        case 9:
                            $result[$k]['description'] = "Comment Album";
                            break;
                        default:
                            $result[$k]['description'] = "";    
                       
                    }
                }
            }
              $response['success'] = 1;
            $response['message'] = "data found";
            $response['account'] = $result;
            }
 else {
     $response['success'] = 0;
            $response['message'] = "data not found";
            $response['account'] = array();
 }
          
        } catch (Exception $exc) {
            $response['success'] = 0;
            $response['message'] = "data not found";
            $response['account'] = array();
        }
        return json_encode($response);
    }

}
