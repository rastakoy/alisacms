<?
$specimg = $_GET["spec"];
$pid = $_GET["pid"];
//-----------------Загрузка ворованного рисунка------
if($specimg){
	echo $specimg."<br/>\n";
	for($i=strlen($specimg); $i>0; $i--){
		if(substr($specimg, $i, 1) == "/") {
			$specname = substr($specimg, $i+1, strlen($specimg)-$i);
			break;
		}
	}
	if(file_exists("../loadimages/".$specname)){
		$specname = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y")).".jpg";
	}
	
	echo $specname."<br/>\n";
	//$specimg = eregi_replace("thumb", "img", $specimg);
	//$specimg = eregi_replace("460x250", "goods", $specimg);
	echo $specimg."<br/>\n";
	$filename = "$specimg";
	$handle = fopen($filename, "r");
	$contents = '';
	while (!feof($handle)) {
		$contents .= fread($handle, 8192);
	}
	fclose($handle);
	
	$handle = fopen("../loadimages/".$specname, 'a');
	fwrite($handle, $contents);
	fclose($handle);
	echo "Запись произведена filename=$filename<br/>\n";
	
	$size = getimagesize($filename);
	
	//print_r($size);
	
	//************************************************
	$link="";
	if($size["mime"]=="image/jpeg" || $size["mime"]=="image/pjpeg" || $size["mime"]=="image/gif" || $size["mime"]=="image/png" || $size["mime"]=="image/x-png")   
	{

		//**************************************
		$query = "INSERT INTO images (name, parent, link, prior) VALUES ('img', $pid, '$specname', 0)";
		echo $query;
		$resp = mysql_query($query);
		echo "<script>";
		echo "top.images_get_images();";
		echo "top.document.getElementById(\"div_up_iframe\").innerHTML = \"\";";
		echo "</script>";
		//**************************************
		
		if($size["mime"]=="image/jpeg" || $size["mime"]=="image/pjpeg"){
			//$link = __images_set_img_name($temp_folder, $userfile["name"], "jpg", "0");
			echo "FUCK!!!";
			$link = $specname;
		}
		/*if($userfile["type"]=="image/gif"){
			//$link = __images_set_img_name($temp_folder, eregi_replace(".gif", ".jpg", $userfile["name"]), "jpg", "0");
			$img = imagecreatefromgif($temp_folder.$userfile["name"]);
			imagejpeg($img, $temp_folder.eregi_replace(".gif", ".jpg", $temp_folder.$userfile["name"]), 75);
			unlink($temp_folder.$userfile["name"]);
			$link = eregi_replace(".gif", ".jpg", $userfile["name"]);
			//echo "type=gif ::: $link<br>\n";
		}
		if($userfile["type"]=="image/png" || $userfile["type"]=="image/x-png"){
			$img = imagecreatefrompng($temp_folder.$userfile["name"]);
			imagejpeg($img, $temp_folder.eregi_replace(".png", ".jpg", $temp_folder.$userfile["name"]), 75);
			unlink($temp_folder.$userfile["name"]);
			$link = eregi_replace(".png", ".jpg", $userfile["name"]);
			//echo "type=png ::: $link<br>\n";
		}*/
    
	}
	else{
		echo "Неверный формат файла! -+-<br>\n"; exit;
    }

	
	$image1 = $specname;
}
?>