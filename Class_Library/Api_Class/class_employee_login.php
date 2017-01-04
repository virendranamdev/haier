<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('class_connect_db_Communication.php');
require ('../../twilio-php-master/Services/Twilio.php');

class ClientEmployeeLogin {

    public $db_connect;

    public function __construct() {
        $dbh = new Connection_Communication();
        $this->db_connect = $dbh->getConnection_Communication();
    }

    public $empid;
    public $dob;
    public $doj;

    function checkEmployeeLogin($name, $fname, $dob) {
        $this->name  = $name;
        $this->fname = $fname.'%';
        $this->dob   = $dob;

        try {
            $rt = "select ud.*,up.userFatherName,up.userDOB from Tbl_EmployeeDetails_Master as ud join Tbl_EmployeePersonalDetails as up on up.employeeId = ud.employeeId where
ud.firstName =:name and  up.userFatherName like :fname and up.userDOB=:dob";

            $stmt = $this->db_connect->prepare($rt);
            $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindParam(':dob', $this->dob, PDO::PARAM_STR);
            $stmt->bindParam(':fname', $this->fname, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetchAll(PDO::PARAM_STR);
                if ($row) {
                    $response['success'] = 1;
                    $response['msg'] = "valid user";
                    $response['username'] = $row[0]['firstName'] . " " . $row[0]['middleName'] . " " . $row[0]['lastName'];
                    $response['useruniqueid'] = $row[0]['employeeId'];
                    $response['mobileno'] = $row[0]['contact'];
                    $response['emailid'] = $row[0]['emailId'];
                    $response['FatherName'] = $row[0]['userFatherName'];
                    $response['DOB'] = $row[0]['userDOB'];
                } else {
                    $response['success'] = 0;
                    $response['msg'] = "Your registration details are not correct, please contact administrator with below details";
                    $response['username'] = "";
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
        }
        return json_encode($response);
    }

    /*     * ****************************************generate login otp********************************************* */

    public $mobile;
    public $emailid;

    function generateLoginOTP($mob, $email, $empid) {
        $this->mobile = $mob;
        $this->emailid = $email;
        $this->empid = $empid;

        $password = self::randomPassword(6);
        $md5pass = md5($password);

        try {

            $query = "update Tbl_EmployeeDetails_Master set contact=:mob,emailId =:eml, password=:pass where employeeId = :empid";
            $stmt = $this->db_connect->prepare($query);
            $stmt->bindParam(':mob', $this->mobile, PDO::PARAM_STR);
            $stmt->bindParam(':eml', $this->emailid, PDO::PARAM_STR);
            $stmt->bindParam(':pass', $md5pass, PDO::PARAM_STR);
            $stmt->bindParam(':empid', $this->empid, PDO::PARAM_STR);
            $stmt->execute();
            $rows_found = $stmt->rowCount();

            $query = "update Tbl_EmployeePersonalDetails set emailId =:eml1 where employeeId = :empid";
            $stmt1 = $this->db_connect->prepare($query);
            $stmt1->bindParam(':eml1', $this->emailid, PDO::PARAM_STR);
            $stmt1->bindParam(':empid', $this->empid, PDO::PARAM_STR);
            $stmt1->execute();

            $query1 = "select firstName from Tbl_EmployeeDetails_Master where employeeId = :empid";
            $stmt11 = $this->db_connect->prepare($query1);
            $stmt11->bindParam(':empid', $this->empid, PDO::PARAM_STR);
            $stmt11->execute();
            $name = $stmt11->fetch(PDO::FETCH_ASSOC);
            $username = $name['firstName'];

            if ($rows_found > 0) {
//echo $rows_found;
                $loginsms = "Manav-Rachna Connect verification code is " . $password;

                $account_sid = 'AC6cada6ee591e119871888eecc7c759c5';
                $auth_token = 'ed74429787ae54cb2af89120ccc4833f';
                $client = new Services_Twilio($account_sid, $auth_token);

                $client->account->messages->create(array(
                    'To' => "+91" . $this->mobile,
                    'From' => "+13144007176",
                    'Body' => $loginsms,));

                $response['success'] = 1;

                $response['msg'] = "Your Latest Password sent to Your mobile and Email id";
                $response['emaild'] = $this->emailid;
                $response['contactno'] = "+91" . $this->mobile;
                $response['empcode'] = $this->empid;
                $response['otp'] = $password;


                /*                 * *******************************send mail***************************************** */
                $to = $this->emailid;
                $subject = 'Manav-Rachna Connect Login OTP';
                $from = 'info@benepik.com';

                // To send HTML mail, the Content-type header must be set

                $headers = 'MIME-Version: 1.0' . "\r\n";

                $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";


                // Create email headers

                $headers .= 'From: Benepik <' . $from . ">\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();



                // Compose a simple HTML email message

                $message = '<html><body>';

                $message .= '<p>Dear ' . $username . ',<p>';

                $message .= '<p>Manav-Rachna Connect verification code is  ' . $password . '</p><br>';


                $message .= '<p>Regards,</p>';
                $message .= '<p>Team Benepik</p>';

                $message .= '</body></html>';


                if (mail($to, $subject, $message, $headers)) {

                    // echo 'Your mail has been sent successfully.';
                } else {

                    // echo 'Unable to send email. Please try again.';
                }
            } else {
                $response['success'] = 0;
                $response['msg'] = "your unique user id not match";
            }
        } catch (PDOException $ex) {
            echo $ex;
            $response['success'] = 0;
            $response['msg'] = $ex;
            $response['username'] = "";
        }
        return json_encode($response);
    }

    function randomPassword($length) {
        $alphabet = "0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}

?>