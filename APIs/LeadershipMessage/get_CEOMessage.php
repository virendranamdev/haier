<?php
error_reporting(E_ALL ^ E_NOTICE);
if (file_exists("../../Class_Library/class_get_ceomessage.php") && include("../../Class_Library/class_get_ceomessage.php")) {

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
        //echo json_encode($response);
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    $jsonArr = json_decode(file_get_contents("php://input"), true);
/*{
"clientid":"CO-25",
"value":"0"
}*/

    if (!empty($jsonArr['clientid'])) {
        $obj = new GetCEOMessage();

        extract($jsonArr);
        $response = $obj->getAllCEOMessageFORandroid($clientid, $value);
    } else {
        $result['success'] = 0;
        $result['result'] = "Invalid json";
        
        $response = json_encode($result);
    }

    header('Content-type: application/json');
    echo $response;
}
?>
