<?php
	
	/*
		Controller to handle requests for list of cities and state Data queries
		Expects a valid state code for states list and state code & city code for city list
		Returs requested  city/state list
	*/

	include "../includes/head.php";
	//$type is filled by the .htaccess to differenciate between the call (Should not be passed explicitly)
	$type = $_GET['type'];

	//inclduing head.php
	switch ($type) {//switch for the differnet values of type(1=>state_list, 2=> city_list) and get the Sequel Query
		case 1:
			$qs = $_GET['category'];
			if ($qs == "state") {
				$select = "stateName,stateId";//forming query in parts
				$group_by = "stateName";
			}else if ($qs == "city") {
				$select = "cityName,cityId";
				$group_by = "cityName";
			}else{
				echo "Invalid Request";
			}
			$query = "select $select from data group by $group_by;";
			break;
		case 2:
			$state_code = $_GET['state_code'];
			$query = "select cityId, cityName from data where stateId = '$state_code' group by cityName";
			break;
		default:
		echo "Invalid Request";	
	}

	try{
		$list = $dbh->query($query);
		$list->setFetchMode(PDO::FETCH_ASSOC);//no interger indexes required
		$list = $list->fetchAll();
	}catch(Excetion $e){
		write_error_to_file($e->getMessage(),"list_errors".date("Y-m-d H:i:s"));
	}
	$list = json_encode($list);
	header("Content-Type:application/javascript:charset=utf-8",true);
	echo("callback($list)");
?>