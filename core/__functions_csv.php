<?
//*********************************************
function __csv_sort_to_mask($mask, $sort, $sv=false){
	//print_r($mask);
	$ret_mass = false;
	$tmp_mass = false;
	foreach($mask as $key=>$val){
		foreach($sort as $k=>$v){
			if($val[0] == $v[0]){
				$ret_mass[]=$v;
				$tmp_mass[] = $k;
				//echo "zap ".$v[0]."::: $k <br />";
				break;
			}
		}
	}
	//*************
	foreach($sort as $key=>$val){
		$z = true;
		if($tmp_mass) {
			foreach($tmp_mass as $k=>$v){
				if($key==$v){
					$z = false;	
					break;
				}
			}
		}
		if($z) {
			$ret_mass[] = $val;
			//echo "zap ".$val[0]."::: $v <br />";
		}
	}
	//*************
	if(count($mask)>count($sort) && $sv){
		$sort = $ret_mass;
		$ret_mass = false;
		$tmp_mass = false;
		foreach($mask as $key=>$val){	
			$z = true;
			foreach($sort as $k=>$v){
				if($val[0] == $v[0]){
					$ret_mass[]=$v;
					$tmp_mass[] = $k;
					//echo "zap ".$v[0]."::: $k <br />";
					$z = false;
					break;
				}
			}
			if($z) $ret_mass[] = array("", "");
		} 
		//*************
		foreach($sort as $key=>$val){
			$z = true;
			if($tmp_mass){
				foreach($tmp_mass as $k=>$v){
					if($key==$v){
						$z = false;	
						break;
					}
				}
			}
			if($z) {
				$ret_mass[] = $val;
				//echo "zap ".$val[0]."::: $v <br />";
			}
		}
	}
	//*************
	
	return $ret_mass;
}
//*********************************************
function set_name_csv($way, $file, $num){
	if($num==0){
		//echo $way.$file."\n";
		if(file_exists("$way$file")){
			//echo $way.$file." - sov \n";
			return set_name_csv($way, $file, $num+1);
		}
		else
			return $file;
	}
	else{
		$withoun_extension = substr($file, 0 , strlen($file)-4);
		if(file_exists($way.$withoun_extension.$num.".csv")){
			//echo $way.$file." - sov \n";
			return set_name_csv($way, $file, $num+1);
		}
		else
			return $withoun_extension.$num.".csv";
	}
}
//*********************************************
function add_kav_csv($val){
	$ret_val="";
	$kav = false;
	for($i=0; $i<strlen($val); $i++){
		if(substr($val, $i, 1) == '"' || substr($val, $i, 1) == ";")
			$kav = true;
	}
	if($kav) $ret_val = "\"".preg_replace('/"/', '""', $val)."\"";
	else $ret_val = $val;
	return $ret_val;
}
//*********************************************
function test_csv_for_sep($mass){
	$ret_val = false;
	$ret_val_ =false;
	foreach($mass as $key=>$val){
		//echo substr($val[1], strlen($val[1])-2, 1);
		if(substr($val[1], strlen($val[1])-2, 1)=="~"){
			$a = explode("~", $val[1]);
			if($a[1]==1)
				$ret_val_[0] = "<td width=\"9\"><img src=\"images/har_vr.jpg\" width=\"9\" height=\"30\"></td>
													<td align=\"center\">$a[0]</td>";
			if($a[1]==2)
				$ret_val_[1] = "<td width=\"9\"><img src=\"images/har_vr.jpg\" width=\"9\" height=\"30\"></td>
													<td align=\"center\">$a[0]</td>";
		} else {
			//echo $val[1]."~NO";
		}
		if($key==count($mass)-1 && $ret_val_)
			$ret_val_[2] = "<td width=\"9\"><img src=\"images/har_vr.jpg\" width=\"9\" height=\"30\"></td>
													<td align=\"center\">$val[1]</td>";
	}
	//********
	if($ret_val_){
		$ret_val = $ret_val_[0].$ret_val_[1].$ret_val_[2];
	}
	//********
	//echo $ret_val;
	return $ret_val;
}
?>