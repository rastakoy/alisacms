<?
	$filename_csv = trim($filename_csv);
	if(!$filename_csv) $filename_csv="temp";
	//$csv_file = set_name_csv("../csv/", $filename_csv.".csv", 0);
	if($edited)
		if($edited_mass["csv"]!="")
			if(file_exists("../csv/".$edited_mass["csv"]))
				$csv_file = $edited_mass["csv"];
	
	echo "csv_file = $csv_file";
	
	$not_null = false;
	
	//$values = $HTTP_POST_VARS["textarea_csv_0"];
	$temp_values = explode("^^~^", $values);
	$values=false; $values=array();
	foreach($temp_values as $key=>$val)  if($key!=count($temp_values)-1) $values[$key]=explode("~+~", $val);
	//print_r($values);
	//echo "print_r --------------------------------------------\n----\n----\n----\n----\n";
		//echo "<script>alert(\"$val\")<script>";
	//print_r($values);
	if($values)
		foreach($values as $key=>$val)
			foreach($val as $k=>$v)
				if($v!="") $not_null =true;
	
	//if($HTTP_POST_VARS["data_csv"])
		//foreach($HTTP_POST_VARS["data_csv"] as $key=>$val)
			//foreach($val as $k=>$v)
				//if($v!="") $not_null =true;
	
		//*****************
		//print_r($values);
		foreach($values as $key=>$val){
			for($i=0; $i<$cells_csv; $i++){
				if($i==$cells_csv-1){
					//print_r($val);
					$conte.=add_kav_csv($val[$i]);
				}
				else{
					//print_r($val);
					$conte.=add_kav_csv($val[$i]).";";
				}
			}
			$conte.="\n";
		}
		echo "CONTE=$conte";
		//if (!is_writeable($csv_file)){chmod($file, 0777);}
		$fp=fopen("../csv/".$csv_file, "w");
		fwrite($fp, $conte);
		@fclose($fp);
		//*****************
?>