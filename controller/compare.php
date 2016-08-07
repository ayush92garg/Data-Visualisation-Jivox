<?php
include "../includes/head.php";
$city_1 = $_GET["city_name_1"];
$city_2 = $_GET["city_name_2"];
$type = $_GET["type"];
$final_data = array();


switch ($type) {//switch for the differnet values of type (Age/Type/Gender)
		case 'Age':
			$query_1 = "select ageGroup,population from data where cityName = '$city_1';";
			try{
				$result_1 = $dbh->query($query_1);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"compare_error_".date("Y-m-d H:i:s"));
			}

			$query_2 = "select ageGroup,population from data where cityName = '$city_2';";
			try{
				$result_2 = $dbh->query($query_2);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"compare_error_".date("Y-m-d H:i:s"));
			}

			while ($data_1 = $result_1->fetch()) {
				if (isset($arr_1[$data_1["ageGroup"]])) {
					$arr_1[$data_1["ageGroup"]] += intval($data_1["population"]);
				}else{
					$arr_1[$data_1["ageGroup"]] = intval($data_1["population"]);
				}
			}

			while ($data_2 = $result_2->fetch()) {
				if (isset($arr_2[$data_2["ageGroup"]])) {
					$arr_2[$data_2["ageGroup"]] += intval($data_2["population"]);
				}else{
					$arr_2[$data_2["ageGroup"]] = intval($data_2["population"]);
				}
			}


			$count_1 = 0;
			foreach ($arr_1 as $ageGroup_1 => $population_arr_1) {
				$categories_1[] = $ageGroup_1;
				$series_1["data"][$count_1] = $population_arr_1;
				$count_1++;
			}

			$count_2 = 0;
			foreach ($arr_2 as $ageGroup_2 => $population_arr_2) {
				$categories_2[] = $ageGroup_2;
				$series_2["data"][$count_2] = $population_arr_2;
				$count_2++;
			}
			
			$cooked_data = array();

			for ($i=0; $i < count($series_2["data"]) ; $i++) { 
				$cooked_data[$i]["name"] = $categories_2[$i];
				$cooked_data[$i]["data"] = array(intval($series_1["data"][$i]),intval($series_2["data"][$i]));
			}			

			$final_data[0] = array($city_1,$city_2);
			$final_data[1] = $cooked_data;
			break;
		case 'Gender':
			$query_1 = "select numberOfMale, numberOfFemale from data where cityName = '$city_1';";
			$query_2 = "select numberOfMale, numberOfFemale from data where cityName = '$city_2';";
			
			try{
				$result_1 = $dbh->query($query_1);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"state_error_".date("Y-m-d H:i:s"));
			}
			
			try{
				$result_2 = $dbh->query($query_2);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"state_error_".date("Y-m-d H:i:s"));
			}
			
			$arr_1["numberOfMale"] = 0;
			$arr_1["numberOfFemale"] = 0;
			$arr_2["numberOfMale"] = 0;
			$arr_2["numberOfFemale"] = 0;


			while ($data_1 = $result_1->fetch()) {
				$arr_1["numberOfMale"] += intval($data_1["numberOfMale"]);
				$arr_1["numberOfFemale"] += intval($data_1["numberOfFemale"]);
			}

			while ($data_2 = $result_2->fetch()) {
				$arr_2["numberOfMale"] += intval($data_2["numberOfMale"]);
				$arr_2["numberOfFemale"] += intval($data_2["numberOfFemale"]);
			}

			$count = 0;

			foreach ($arr_1 as $key => $value) {
				$cooked_data[$count]["name"] = $key;
				$cooked_data[$count]["data"] = array($arr_1[$key],$arr_2[$key]);
				$count++;
			}

			$final_data[0] = array($city_1,$city_2);
			$final_data[1] = $cooked_data;
			break;
		case 'Type':
			$query_1 = "select type,population from data where cityName = '$city_1';";
			try{
				$result_1 = $dbh->query($query_1);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"compare_error_".date("Y-m-d H:i:s"));
			}

			$query_2 = "select type,population from data where cityName = '$city_2';";
			try{
				$result_2 = $dbh->query($query_2);
			}catch(Exception $e){
				write_error_to_file($e->getMessage(),"compare_error_".date("Y-m-d H:i:s"));
			}

			while ($data_1 = $result_1->fetch()) {
				if (isset($arr_1[$data_1["type"]])) {
					$arr_1[$data_1["type"]] += intval($data_1["population"]);
				}else{
					$arr_1[$data_1["type"]] = intval($data_1["population"]);
				}
			}

			while ($data_2 = $result_2->fetch()) {
				if (isset($arr_2[$data_2["type"]])) {
					$arr_2[$data_2["type"]] += intval($data_2["population"]);
				}else{
					$arr_2[$data_2["type"]] = intval($data_2["population"]);
				}
			}


			$count_1 = 0;
			foreach ($arr_1 as $typeGroup_1 => $population_arr_1) {
				$categories_1[] = $typeGroup_1;
				$series_1["data"][$count_1] = $population_arr_1;
				$count_1++;
			}

			$count_2 = 0;
			foreach ($arr_2 as $typeGroup_2 => $population_arr_2) {
				$categories_2[] = $typeGroup_2;
				$series_2["data"][$count_2] = $population_arr_2;
				$count_2++;
			}
			
			$cooked_data = array();

			for ($i=0; $i < count($series_2["data"]) ; $i++) { 
				$cooked_data[$i]["name"] = $categories_2[$i];
				$cooked_data[$i]["data"] = array(intval($series_1["data"][$i]),intval($series_2["data"][$i]));
			}			

			$final_data[0] = array($city_1,$city_2);
			$final_data[1] = $cooked_data;
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