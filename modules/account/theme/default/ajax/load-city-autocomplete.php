<?php
	//$k=$_GET['k'];
	$city=$_POST['term'];
	$state_id=$_REQUEST['stateid'];
	$city_data = $account_obj->select_city($city,$state_id);
	$cities=array();

		foreach($city_data as $key=>$value)
		{ 
			
			$cities[]=$value['city_name'];
		}$result = array();
		
		foreach ($cities as $key=>$value) {
				array_push($result, array("id"=>$value, "label"=>$value, "value" => $value));
				
				if (count($result) > 11)
				break;
		}echo json_encode($result);

// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
?>