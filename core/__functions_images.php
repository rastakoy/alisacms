<?
//*********************************************
function __images_get_img_from_parent_id($parent){
	$query = " select * from images where parent=$parent order by prior asc limit 0,1  ";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	return $row["link"];
	//return $mass;
	//print_r($mass);
}
//*********************************************
function __images_create_images_array($mass){
	$mass = explode("~", $mass);
	return $mass;
	//print_r($mass);
}
//*********************************************
function __images_set_img_name($way, $file, $ext="jpg", $num=0){
	if($num==0){
		if(file_exists("$way$file"))
			return __images_set_img_name($way, $file, $ext, $num+1);
		else
			return $file;
	}
	else{
		$without_extension = substr($file, 0 , strlen($file)-4);
		if(file_exists($way.$without_extension.$num.".".$ext))
			return __images_set_img_name($way, $file, $ext, $num+1);
		else
			return $without_extension.$num.".".$ext;
	}
}
//*********************************************
function __images_load_and_convert($userfile_mass, $userfile_argv, $max_img_file_size, $temp_folder, $user_folder, $resize){
//$link = "../images/".$userfile_mass;
$link = "$user_folder"."$userfile_argv";
echo "user_folder=$user_folder<br>\n";
//$link = "$userfile_argv";

//$link = $temp_folder.$userfile["name"];
//echo "link = $link<br/>\n";
//echo "end = ".$user_folder.$link."<br/>\n";
//��������� �������� ������ � ������� JPG !!!
//� ���������������, �. �������. mailto: inter-t@rambler.ru
//��� ������ ���������� � ������� RRR:GGG:BBB  � ���������� $bgcolor=255:255:255 (����� ���)

//echo "�������� ������� ���������������<br/>\n";
//echo "link = $link<br/>\n";
//echo "resize = $resize<br/>\n";

$resize = explode("x", $resize);
if($resize[1]!="") {
	$resize_x = $resize[0];
	$resize_y = $resize[1];
	$resize = false;
} else {
	$resize = $resize[0];
}

//echo "resize_x = $resize_x<br/>\n";
//echo "resize_y = $resize_y<br/>\n";

if(!$link) exit(); //���� �� ����� ���� � ��������� �����, �� �����
if(!$resize && !$resize_x) exit(); // ���� �� ����� ������ - ���� �����

//echo "resize � link ��������<br/>\n";

//$image = $temp_folder.$link; //���������� $image �������� ���� � ��������� �����
//echo "image=$image<br/>\n";
$image = $link;
//echo "�������� ������� image_in<br/>\n";
$image_in=imagecreatefromjpeg($link); //������� ������ $image_in, � ������� ����� �������� ��������� �����������
//echo "������ ������ image_in<br/>\n";
//if($type == "limages")
//        $image = "limages/".$link;
//if($type == "nimages")
//        $image = "nimages/".$link;
//if($type == "cont_images")
//        $image = "cont_images/".$link;

$subtitr = "images/logotip.png";

//---------------------------------------------------------
//���������� �������� ������ �����������:
//$new_w = ������ ������������ �����������
//$new_h = ������ ������������ �����������

//��� ����� ��������� ����������� ������� 4:3:
//if($resize>imagesx($image_in) || imagesx($image_in) < $resize/4*3 ){
//	$resize = imagesx($image_in);
//}
if($resize){
$new_w = $resize; // ����������� ������
$new_h = $resize/4*3; // ����������� ������
}
//����� ��� ����� ������ ���������� $resize_x � $resize_y
else{
$new_w = $resize_x; // ����������� ������
$new_h = $resize_y; // ����������� ������
}

//echo "�������� ����� ������:$new_w � ������:$new_h<br/>\n";

//---------------------------------------------------------

//---------------------------------------------------------
//����������� ������ � ������ ����������� ������������ � ����� $new_w(������);$new_h(������) - ��. ����.
$img_w = imagesx($image_in);  //������ �����������
$img_h = imagesy($image_in); //������ �����������

if($img_w <= 1600){
	$new_w = $img_w;
	$new_h = $img_h;
}

$max_w = $new_w; //����������� ���������� ������ �� ��� �
$max_h = $new_h; //����������� ���������� ������ �� ��� �

$img_w = $resize_x;
$img_h = $resize_y;

if($new_w <= 1600){
	$img_w = $new_w;
	$img_h = $new_h;
}

	//������� ������������� ������� ������� (� ���������������)  �� ����������� ���� ������� {--
	//if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
	//	if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
	//		$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //������ ����������� (� ������������ � ������)
	//		$img_h = $max_h;  //������ ����������� (� ������������ � �������������� ������)
	//	} else {
	//		$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //������ ����������� (� ������������ c ������)
	//		$img_w = $max_w;  //������ ����������� (� ������������ � �������������� ������)
	//	}
	//}
	//     --}
	// ��������������� ����������� �� ���� � � �
	$center_x = $max_w/2-$img_w/2;
	$center_y = $max_h/2-$img_h/2;

$image_out=imagecreatetruecolor($new_w,$new_h); //������� ������ ��������� �����������
if(!$bgcolor){
	$bg = imagecolorallocate($image_out, 255,255,255); //���������� ��� �����������:
}  else  {
	$bgcolor =  explode(":", $bgcolor);
	$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //������ ��� �����������:
}

//�������� ������������� ��������� ����������� �����:
imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
//���������� � ������������� ��������� �����������, ������� ������, �������� �����������:
imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));


if($subtitr){
	$img_logo=imagecreatefrompng($subtitr); //������� ������ ����������� ��������
	//��������� ��������� �������� �������� ��������, ����� ���������� ������ �����������
	if($new_w>=600 && $new_h>=600) 
		$logo_w = 600;
	elseif($new_w>=600 && $new_h<600) 
		$logo_w = $new_h;
	else
		if($new_h>=$new_w) $logo_w = $new_w;
		else $logo_w = $new_h;
	//��������������� ����������� ��������
	$logo_w = $new_w / 100 * 30;
	$logo_h = $logo_w;
	$center_x = $new_w/2  - $logo_w/2;
	$center_y = $new_h   - $logo_h;
	// ��������� �������� �� �����������:
	imagecopyresampled($image_out,$img_logo,$center_x,$center_y,0,0, $logo_w,$logo_w,imagesx($img_logo),imagesy($img_logo));
}

//header("Content-type: image/jpeg");
$link = preg_replace("/loadimages\//", "", $link);
$tmp_name = __images_set_img_name($user_folder, $link, "jpg", 0);
echo "link = $link<br/>\n";
//echo "user_folder = $user_folder<br/>\n";
//echo "temp_folder = $temp_folder<br/>\n";
//$tmp_name = preg_replace("/\/loadimages\//", "", $tmp_name);
echo "user_folder.tmp_name = $user_folder**"."$tmp_name<br/>\n";
//unlink($temp_folder.$link);
imagejpeg($image_out, "$user_folder".$tmp_name, 75); //�������� ����������� � ��������� 75% (���� �� ����������� ��������)	
return $tmp_name;

}

function __fi_create_images_array($mass){
	$mass = explode("~", $mass);
	return $mass;
	//print_r($mass);
}

function __images_delete_control($mass1, $mass2){
	$mass1=explode("~", $mass1);
	$mass2=explode("~", $mass2);
	//print_r($mass1);
	//echo "\n------------\n";
	//print_r($mass2);
	foreach($mass2 as $key2=>$val2){
		$search = false;
		foreach($mass1 as $key1=>$val1){
			if($val1==$val2){
				$search = true;
			}
		}
		if(!$search){
			if(file_exists("../models_images/$val2") && $val2!=""){
				//echo "�������� ��������� - $val2";
				unlink("../models_images/$val2");
			}
		}
	}
}
//**************************************
function __fi_get_galery($galtype){
	if($galtype==0) return false;
	$resp_gt = mysql_query("select * from galtypes where id=$galtype");
	$row_gt = mysql_fetch_assoc($resp_gt);
	$mass = false;
	$fmass = explode("\n", $row_gt["pairs"]);
	foreach($fmass as $key => $val){
		$amass = explode("=", $val);
		$mass[$amass[0]] = trim($amass[1]);
	}
	return $mass;
}
//**************************************
function __fi_create_galery($galtype, $mass, $resize=120){
	if(!is_array($mass)) return "";
	$res = explode("x", $resize);
	$ret  = "\n\n<ul id=\"$galtype\">";
		foreach($mass as $key=>$v){
			if(!$v["useintext"]){
				$ret .= "<li class=\"li-$galtype\"><img class=\"img-$galtype\" alt=\"$v[cont]\"  src=\"imgres.php?resize=$res[0]&link=loadimages/$v[link]\"  /></li>\n";
			}
		}
	$ret .= "</ul>";
	return $ret;
}


//*******************************************
function __fi_create_img_tumbs($folder, $tumbs, $name){
	//return "test";
	if(!preg_match("/jpg$/", $name)) return "images/no_photo.jpg";
	if(!is_dir($folder."/".$tumbs)){
		$structure = $folder."/".$tumbs."/";
		mkdir($structure, 0, true);
		chmod($structure, 0777);
	}
	if(file_exists("$folder/$tumbs/$name")){
		return "$folder/$tumbs/$name";
	} else {
		$ress = explode("x", $tumbs);
		$saver = "$folder/$tumbs/$name";
		__fi_create_tumbs_img("$folder/$name", false, $ress[0], $ress[1], $saver, $perc=80);
		//$fp = fopen("imgres.php?resize_x=120&resize_y=120&link=$folder/$name&saver=$folder/$tumbs/$name&perc=80", "r");
        //if ($fp) fclose($fp);
		return "$folder/$tumbs/$name";
	}
}
//*******************************************
function __fi_create_tumbs_img($link, $resize, $resize_x=false, $resize_y=false, $saver=false, $perc=false){
	if(!$link) return false;
	if(!$resize && !$resize_x) return false;
	$image = $link;
	if(!preg_match('/^models_images/', $image) && !preg_match('/(^|^\.\.\/)loadimages/', $image) && !preg_match('/^sp_images/', $image) && !preg_match('/^marks/', $image))
	$image = "loadimages/".$link;
	//if(  preg_match(  '/(^\.\.\/)loadimages/', $link  )  )  $image .=  "../".$image;
	
	if($resize){
		$new_w = $resize; // ����������� ������
		$new_h = $resize/4*3; // ����������� ������
	} else {
		$new_w = $resize_x; // ����������� ������
		$new_h = $resize_y; // ����������� ������
	}
	//---------------------------------------------------------
	$image_in=imagecreatefromjpeg($image); //������� ������ $image_in, � ������� ����� �������� ��������� �����������
	$img_w = imagesx($image_in);  //������ �����������
	$img_h = imagesy($image_in); //������ �����������
	$max_w = $new_w; //����������� ���������� ������ �� ��� �
	$max_h = $new_h; //����������� ���������� ������ �� ��� �
	//������� ������������� ������� ������� (� ���������������)  �� ����������� ���� ������� {--
	if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
		if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
			$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //������ ����������� (� ������������ � ������)
			$img_h = $max_h;  //������ ����������� (� ������������ � �������������� ������)
		} else {
			$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //������ ����������� (� ������������ c ������)
			$img_w = $max_w;  //������ ����������� (� ������������ � �������������� ������)
		}
	}
	//     --}
	// ��������������� ����������� �� ���� � � �
	$center_x = $max_w/2-$img_w/2;
	$center_y = $max_h/2-$img_h/2;

	$image_out=imagecreatetruecolor($new_w,$new_h); //������� ������ ��������� �����������
	if(!$bgcolor){
		$bg = imagecolorallocate($image_out, 255,255,255); //���������� ��� �����������:
	}  else  {
		$bgcolor =  explode(":", $bgcolor);
		$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //������ ��� �����������:
	}
	imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
	imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));

	if($subtitr){
		$img_logo=imagecreatefrompng($subtitr); //������� ������ ����������� ��������
		if($new_w>=600 && $new_h>=600) 
			$logo_w = 600;
		elseif($new_w>=600 && $new_h<600) 
			$logo_w = $new_h;
		else
			if($new_h>=$new_w) $logo_w = $new_w;
			else $logo_w = $new_h;
		$center_x = 10; //$new_w/2 - $logo_w/2;
		$center_y = $new_h/2 - $logo_w/2;
		imagecopyresampled($image_out,$img_logo,$center_x,$center_y,0,0, $logo_w,$logo_w,imagesx($img_logo),imagesy($img_logo));
	}
	if($saver){
		if(!$perc) $perc = 90;
		if(file_exists($saver)){
			unlink($saver);
		}
		imagejpeg($image_out, $saver, $perc);
	}
}
?>