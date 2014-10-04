<?
//******************************
function  __fconst_get_cascating_tags($field, $table, $value){
	$resp = mysql_query("SHOW FIELDS FROM $table where field='$field' ");
	$row=mysql_fetch_assoc($resp);
	if(   preg_match(   '/^int/', $row["Type"]   )   ){
		return $value;
	} else {
		return "\"$value\"";
	}
}
//******************************
function  __fconst_get_field_type($field, $table, $value){
	$resp = mysql_query("SHOW FIELDS FROM $table where field='$field' ");
	$row=mysql_fetch_assoc($resp);
	if(   preg_match(   '/^int/', $row["Type"]   )   ){
		return $value;
	} else {
		return "\"$value\"";
	}
}
//******************************
function  __fconst_has_values_from_keys_for_forms_testing($keys, $values){
	//print_r($keys);
	//print_r($values);
	$a =false;
	foreach(  $values as $ikey=>$ival  ){
		//if($keys["connectionField"]=="тестовое")  print_r($ival);
		//echo "if($keys[connectionField]  ==  $ival[connectionField]  &&  $ival[pagePost]==\"Добавить\"    )\n";
		if($keys["connectionField"]  ==  "Текстовое поле"  &&  $ival["pagePost"]=="Добавить"    ){
			return true;
		}
		if($keys["connectionField"]  ==  $ival["connectionField"]  &&  $ival["pagePost"]=="Добавить"    ){
			//echo "Совпадение\n";
			$a=true;
			break;
		}
		if(count($ival["childs"])>0){
			$a =  __fconst_has_values_from_keys_for_forms_testing($keys, $ival["childs"]);
			if($a) break;
		}
	}
	return $a;
}
//******************************

//******************************
?>