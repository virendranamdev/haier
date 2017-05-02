<?php
require_once('Class_Library/class_login_analytic.php');
$obj = new LoginAnalytic();
	//$json = json_decode(file_get_contents("php://input"));\
	/*print_r($json);
	   if(isset($_POST["mydata"])
	   {
		   $jsonArr = $_POST["mydata"];
		    echo "return data".$jsonArr;
	   }
	   else
	   {
		   echo "error";
	   }
	   */
	   if(!empty($_POST["mydata"]))
	   {
		   $jsonArr = $_POST["mydata"];
		   //echo $jsonArr;
		   //print_r($jsonArr);
		   $data = json_decode($jsonArr , true);
		   //print_r($data);
		   
			if (!empty($data)) 
			{
			 $client = $data['client'];
			 $fromdt = $data['start_date'];
			 $enddte = $data['end_date'];
			 $device = $data['device'];
			
			$result = $obj->userAppInstalltion($client,$fromdt,$enddte,$device);
			$res = json_decode($result , true);
			
			//print_r($res);
			
			//echo $result;
			//echo "<pre>";
			
			//echo count($res);
			/*for($i=0; $i<count($res); $i++)
			{
			$device = $res[$i]['deviceName'];
			if($device == 2)
			{
				$dev = 'android';
			}
			else
			{
				$dev = 'ios';
			}
			$res[$i]['deviceName'] = $dev;
			}*/
			
			//echo $jsonres = json_encode($res);
			//echo $result;
			//print_r($result);
			
			$post = array();
			for($i=0; $i<count($res); $i++)
			{
				
			$pdata['sn'] = $res[$i]['sn'] = $i+1 ;
			$pdata['employeeID'] = $res[$i]['employeeCode'];
			$pdata['firstName'] = $res[$i]['firstName'];
			$pdata['department'] = $res[$i]['department'];
			$pdata['location'] = $res[$i]['location'];
			//$pdata['deviceName'] = $res[$i]['deviceName'];
						
			if($res[$i]['deviceName'] == 2)
			{
				$dev = 'Android';
			}
			else
			{
				$dev = 'IOS';
			}
			$pdata['deviceName'] = $res[$i]['deviceName'] = $dev;
			$pdata['date_entry_time'] = $res[$i]['date_entry_time'];
			//$pdata['appVersion'] = $res[$i]['appVersion'];
			array_push($post,$pdata);
			}
			
			echo $jsonres = json_encode($post);
		   }
		   
	   }
		
	 

?>