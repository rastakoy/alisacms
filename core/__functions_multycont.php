<?
function __multycont_parse($multycont, $multycont_name, $multycont_del){
	$ret_val = "";
	$cnt=0;
	if(count($multycont)>0){
		foreach($multycont as $key=>$val){
			if($multycont_del[$key]==2){
				if($cnt!=0){
					$ret_val.="|separator_cont|".$multycont_name[$key]."|subseparator_cont|".$val;
				}
				else{
					$ret_val.=$multycont_name[$key]."|subseparator_cont|".$val;
				}
				$cnt++;
			}
		}
	}
	return $ret_val;
}

function __multycont_parse_for_user($multycont, $multycont_separator, $multycont_subseparator){
	$mc_mass = array();
	$mc_tmp_mass = explode($multycont_separator, $multycont);
	foreach($mc_tmp_mass as $mc_key=>$mc_val){
		$mc_mass[] = explode($multycont_subseparator, $mc_val);
	}
	return $mc_mass;
}
?>