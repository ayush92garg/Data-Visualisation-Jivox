<?php

define('DB_HOST','localhost');
define('DB_USER','ayush');
define('DB_PASSWORD','ayush');
define('DB_DATABASE','jivox');

$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE, DB_USER,DB_PASSWORD,array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false,PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8mb4'));

$raw_data = file_get_contents("resources/india_states.geojson");
$geo_data = json_decode($raw_data,true);

$count = 0;
foreach ($geo_data["features"] as $key => $value) {
	// $query = 'insert into geo_data(ID_0,ISO,NAME_0,ID_1,NAME_1,NL_NAME_1,VARNAME_1,TYPE_1,ENGTYPE_1,filename,filename_1,filename_2,filename_3,filename_4) values(';
	$count ++; 
	foreach ($value["geometry"]["coordinates"] as $value1) {
		print_r($value1);
		echo json_encode($value1);
		// file_put_contents("resources/coordiante_json_files/".$count.".json",json_encode($value1));


		// print_r($value1)."\n";exit;
		// $query .= '"'.$value1.'",';
	}
	exit;
	// $query = trim($query,",").");\n";
	// file_put_contents("geo_data_dump.sql",$query,FILE_APPEND);
}
// print_r($geo_data);


?>