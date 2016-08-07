<?php
$file = fopen('resources/census_data/education_level.csv', 'r');

$line_number = 1;
$res = array();
$type_array = array("total_person","total_males","total_females","illitrate_person","illitrate_male","illitrate_female","litrate_person","litrate_male","litrate_female","literate_wo_education_person","literate_wo_education_male","literate_wo_education_female","below_primary_person","below_primary_male","below_primary_female","primary_person","primary_male","primary_female","middle_person","middle_male","middle_female","matric_person","matric_male","matric_female","intermediate_person","intermediate_male","intermediate_female","non_technical_diploma_person","non_technical_diploma_male","non_technical_diploma_female","technical_diploma_person","technical_diploma_male","technical_diploma_female","graduate_person","graduate_male","graduate_female","unclassified_person","unclassified_male","unclassified_female");


$type = array("literate_wo_education","primary","middle","matric","intermediate","diploma","graduate","post_graduate","PHD");

$columns_array = array("stateCode","townCode","townName","age_all","age_0_6","age_7","age_8","age_9","age_10","age_11","age_12","age_13","age_14","age_15","age_16","age_17","age_18","age_19","age_20_24","age_25_29","age_30_34","age_35_39","age_40_44","age_45_49","age_50_54","age_55_59","age_60_64","age_65_69","age_70_74","age_75_79","age_80","age_none","type");

while (($line = fgetcsv($file)) !== FALSE) {
  	//$line is an array of the csv elements
  	$column_number = 1;
	if ($line_number > 7) {
		// print_r($line);
		// exit;
		// $query = "insert into education_level_data()"
		$count = 6;
		foreach ($type_array as $value) {
			$res[$line[1]][$line[2]][$line[5]][$value] = $line[$count];
			$count++;
		}
		// $column_number++;
	// print_r($res);
		// continue;
	}
	$line_number++;
}
fclose($file);
$check_array=array();
$query="";
foreach ($res as $stateCode => $all_towns) {
	foreach ($all_towns as $town_code => $column_name) {
		foreach ($column_name as $each_col => $type) {
			$each_col = "age_".str_replace("-", "_",$each_col);
			foreach ($type as $type_name => $type_val) {
				// $each_col = "age_".str_replace("-", "_",$each_col);
				if (!in_array( $town_code."_".$type_name, $check_array)) {
					$query .= "insert into education_level_data(stateCode,townCode,$each_col,type) values($stateCode,$town_code,$type_val,'$type_name');\n";
					array_push($check_array, $town_code."_".$type_name);
				}else{
					$query .= "update education_level_data set $each_col = '$type_val' where stateCode = $stateCode and type='$type_name';\n";
					
				}
				 // on duplicate key update $each_col = '$type_val';\n"
				// echo $query.";\n";
				
			}
		}
	}
}
file_put_contents("test.sql",$query,FILE_APPEND);



?>