<?php

$filename = "/home/amigobulls/Desktop/input_data.csv";


$categ = array("literate_wo_education","primary","middle","matric","intermediate","diploma","graduate","post_graduate","PHD");


$query = "";

if (($handle = fopen($filename, 'r')) !== FALSE){
    while (($row = fgetcsv($handle)) !== FALSE)
    {   
        if($row[1]=="00"){
            $state_name = $row[2];
            $state_code = $row[0];
            continue;
        }else{
            $dist_name = $row[2];
            $dist_code = $row[1];
        }
        for($ix=0;$ix<100;$ix=$ix+10){
            $age_group = "$ix"."_".($ix+10);
            foreach ($categ as $cat) {
                $population = rand(200000,2000000);
                $rat = rand(13,17)/10;
                $nom = round($population/$rat);
                $nof = round($population- ($population%$rat));
                $query .= "insert into data values (0,".$state_code.",'".$state_name."','".$dist_code."','".$dist_name."','".$age_group."','".$cat."',".$population.",".$nom.",".$nof.");\n";
            }
        }
    }
    fclose($handle);
}

file_put_contents("data.sql", $query);

?>