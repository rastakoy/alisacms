<?
function __fd_transform_ddmmyy_to_txt($data){
	$r = "";
	$mass = explode(".", $data);
	$mass[1] = $mass[1] + 0;
	if($mass[1] == 1) $r = "������";
	if($mass[1] == 2) $r = "�������";
	if($mass[1] == 3) $r = "����";
	if($mass[1] == 4) $r = "������";
	if($mass[1] == 5) $r = "���";
	if($mass[1] == 6) $r = "����";
	if($mass[1] == 7) $r = "����";
	if($mass[1] == 8) $r = "������";
	if($mass[1] == 9) $r = "��������";
	if($mass[1] == 10) $r = "�������";
	if($mass[1] == 11) $r = "������";
	if($mass[1] == 12) $r = "�������";
	//*************************
	if(strlen($mass[2]) == 2) $mass[2] = "20".$mass[2];
	return $mass[0].".".$r.".".$mass[2];
}
?>