<?
//*********************************************
function __fjson_sort_array($level, $mask){
	if($mask=="digit->"){
		$fmass = array();
		$smass = array();
		$new_mass = array();
		foreach($level as $key=>$val){
			if (preg_match("|^[\d]+$|", $key)) {
				$fmass[$key] = $val;
				echo "Cовпадение \n";
			} else {
				$smass[$key] = $val; 
				echo "Не Cовпадение \n";
			}
		}
		//**************************
		ksort($fmass);
		foreach($fmass as $key=>$val)
			$new_mass[$key] = $val;
		foreach($smass as $key=>$val)
			$new_mass[$key] = $val;
		//**************************
		return $new_mass;
	}
}
//*********************************************
function __fjson_read_file(){
	$cfg = get_file("__atemplate.js");
	return $cfg;
	//print_r(__fjson_read_level($cfg));
}
//*********************************************
function __fjson_read_level($txt){
	$skob_count = 0;
	$kav_count=0;
	$start_kav = false;
	$start_data = false;
	$levels = false;
	$nextsibling = false;
	$start_letter=-1;
	$new_string = false;
	$start_new_string=0;
	for($j=0; $j<strlen($txt); $j++){
		//**************************
		
		//**************************
		if(substr($txt, $j, 1) == "{")  {
			if($skob_count==0) $start_letter = $j;
			$skob_count++;
		}
		//**************************
		if(substr($txt, $j, 1) == "}")  {
			$nextsibling = true;
			$skob_count--;
		}
		//**************************
		if(substr($txt, $j, 1) == '"'  &&  $skob_count==1 && !$start_kav && $kav_count<2)  {
			$start_kav = $j+1; 
			$kav_count++;
			$j++;
			//echo "start_kav";
		}
		//**************************
		if(substr($txt, $j, 1) == '"'  &&  $skob_count==1 && $start_kav && $kav_count<2)  {
			//echo "stop_kav";
			$command = substr($txt, $start_kav, $j-$start_kav);
			$start_kav = false;
			//echo $command."\n";
			$kav_count++;
		}
		//**************************
		if(substr($txt, $j, 1) == ":"  &&  $skob_count==1  &&  $kav_count>1)  {
			$start_data = $j+1;
		}
		//**************************
		if(substr($txt, $j, 1) == "{"  &&  $skob_count==2  &&  $kav_count>1)  {
			$kav_count = 0;
		}
		//**************************
		if(substr($txt, $j, 1) == '"'  &&  $skob_count==1 && !$start_kav && $kav_count>1 && $start_data)  {
			$start_kav = $j+1; 
			$kav_count++;
			$j++;
		}
		//**************************
		if(substr($txt, $j, 1) == '"'  &&  $skob_count==1 && $start_kav && $kav_count>1 && $start_data)  {
			$data = substr($txt, $start_kav, $j-$start_kav);
			$start_kav = false;
			$levels[$command] = "$data";
			$kav_count=0;
			$start_data = false;
			$data = false;
		}
		//**************************
		if(substr($txt, $j, 1) == "}"  &&  $skob_count==1  &&  $start_data)  {
			//echo "data=[$start_data:$j]\n";
			//$levels[$command] = substr($txt, $start_letter, $j-$start_letter);
			//echo substr($txt, $start_data, $j-$start_data);
			//echo "--------------------";
			//if($command=="site-properties")
				$levels[$command] = __fjson_read_level(substr($txt, $start_data, $j-$start_data));
			//else
			//	$levels[$command] = "[$start_data:$j]";
			//$levels[$command] = "$data";
			$start_data = false;
		}
		//**************************
		if($nextsibling && $skob_count==0){
			$nextsibling = false;
		}
		//**************************
		$new_string = false;
		//**************************
		//echo substr($txt, $j, 1)."-";
	}
	//print_r($levels);
	return $levels;
}
//*********************************************
?>