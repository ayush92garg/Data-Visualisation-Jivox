<?php

	/*
		Controller to handle City Level Data queries
		Expects a valid state code, city code and type
		Returs aggregated population data for the required city and input type
	*/

	//inclduing head.php
	include "../includes/head.php";
	$state_code = $_GET["state_code"];//state_code
	$city_code = $_GET["city_code"];//city_codee
	$type = $_GET["type"];//type

	$final_data = array();//stores the final data which is returned to the caller

	switch ($type) {//switch for the differnet values of type (Age/Type/Gender)
		case 'Age':
			$query = "select ageGroup,population from data where stateId = $state_code and cityId = $city_code;";
			try{
				$result = $dbh->query($query);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"state_error_".date("Y-m-d H:i:s"));
			}
			$population_addition = array();
			while ($data = $result->fetch()) {
				if (isset($arr[$data["ageGroup"]])) {
					$arr[$data["ageGroup"]] += intval($data["population"]);
				}else{
					$arr[$data["ageGroup"]] = intval($data["population"]);
				}
			}
			$count = 0;
			foreach ($arr as $ageGroup => $population_arr) {
				$categories[] = $ageGroup;
				$series["data"][$count] = $population_arr;
				$count++;
			}
				
			$final_data[0] = $categories;
			$final_data[1] = $series;
			break;
		case 'Gender':
			$query = "select numberOfMale, numberOfFemale from data  where stateId = $state_code and cityId = $city_code;";
			try{
				$result = $dbh->query($query);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"state_error_".date("Y-m-d H:i:s"));
			}
			$arr["numberOfMale"] = 0;
			$arr["numberOfFemale"] = 0;
			$categories = array("Number Of Male","Number Of female");
			while ($data = $result->fetch()) {
				$arr["numberOfMale"] += intval($data["numberOfMale"]);
				$arr["numberOfFemale"] += intval($data["numberOfFemale"]);
			}
			$series["data"][0] = $arr["numberOfFemale"];
			$series["data"][1] = $arr["numberOfMale"];
			$final_data[1] = $series;
			$final_data[0] = $categories;
			break;
		case 'Type':
			$query = "select type, population from data  where stateId = $state_code and cityId = $city_code;";
			try{
				$result = $dbh->query($query);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"state_error_".date("Y-m-d H:i:s"));
			}
			while ($data = $result->fetch()) {
				if (isset($final_data[$data["type"]])) {
					$arr[$data["type"]] += intval($data["population"]);
				}else{
					$arr[$data["type"]] = intval($data["population"]);
				}
			}
			$count = 0;
			foreach ($arr as $type => $population_arr) {
				$categories[] = $type;
				$series["data"][$count] = $population_arr;
				$count++;
			}
				
			$final_data[0] = $categories;
			$final_data[1] = $series;
			break;
		default:
				$final_data = "Invalid Request Paramter Passed for type";
			break;
	}

	//encodnig data array into json and returning it to the caller
	$final_data = json_encode($final_data);
	header("Content-Type:application/javascript:charset=utf-8",true);
	echo("callback($final_data)");
?>