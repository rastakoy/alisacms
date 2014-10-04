<?
function __fd_transform_ddmmyy_to_txt($data){
	$r = "";
	$mass = explode(".", $data);
	$mass[1] = $mass[1] + 0;
	if($mass[1] == 1) $r = "Январь";
	if($mass[1] == 2) $r = "Февраль";
	if($mass[1] == 3) $r = "Март";
	if($mass[1] == 4) $r = "Апрель";
	if($mass[1] == 5) $r = "Май";
	if($mass[1] == 6) $r = "Июнь";
	if($mass[1] == 7) $r = "Июль";
	if($mass[1] == 8) $r = "Август";
	if($mass[1] == 9) $r = "Сентябрь";
	if($mass[1] == 10) $r = "Октябрь";
	if($mass[1] == 11) $r = "Ноябрь";
	if($mass[1] == 12) $r = "Декабрь";
	//*************************
	if(strlen($mass[2]) == 2) $mass[2] = "20".$mass[2];
	return $mass[0].".".$r.".".$mass[2];
}
?>