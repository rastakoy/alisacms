<?
$tree_index = 0;
//**************************************
$parent = $_GET["parent"];
if(!$parent) $parent="0";
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_pages.php");
dbgo();
$aa = false;
//print_r($_FILES);
//print_r($_POST);
//print_r($_GET);
//echo "{\"display\":\"parent=$parent\"}";
//exit;
//********************************
function save($path) {    
	$input = fopen("php://input", "r");
	$temp = tmpfile();
	$realSize = stream_copy_to_stream($input, $temp);
	fclose($input);
	
	if ($realSize != $this->getSize()){            
		return false;
	}
	
	$target = fopen($path, "w");        
	fseek($temp, 0, SEEK_SET);
	stream_copy_to_stream($temp, $target);
	fclose($target);
	
	return true;
}
//********************************
function getfileinfo() {
	$query = "select * from files_csv order by id desc limit 0,1";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	return $row["id"];
}
//********************************
if($_FILES["qqfile"]){
	$filenames = __images_set_img_name("../csv/", $_FILES["qqfile"]["name"], "csv" );
	$res = copy(iconv("UTF-8", "CP1251", $_FILES["qqfile"]["tmp_name"]), "../csv/".$filenames);
	if($res) {
		$query = "INSERT INTO files_csv (name, parent, link, prior, img_in_text) VALUES ('img', $parent, '$filenames', 0, 1)";
		$resp = mysql_query($query);
		echo "{\"success\":\"true\", \"newfileid\":\"".getfileinfo()."\"}";
		$aa = true;
	} else {
		echo "{\"success\":\"false\"}";
	}
}
//********************************
if(isset($_GET["qqfile"])){
	//save("../csv/asd.tmp");
	//echo "{\"success\":\"".$_GET["qqfile"]."\"}";
	//echo "{\"data\":\"testing\",\n";
	
	$input = fopen("php://input", "r");
	$temp = tmpfile();
	$realSize = stream_copy_to_stream($input, $temp);
	//echo "\"tmpf\":\"$realSize\",\n";
	fclose($input);
	
	$target = fopen("../tmp/".iconv("UTF-8", "CP1251", $_GET["qqfile"]), "w");        
	fseek($temp, 0, SEEK_SET);
	stream_copy_to_stream($temp, $target);
	fclose($target);
	
	$nnn = iconv("UTF-8", "CP1251", $_GET["qqfile"]);
	$nnn = __fp_rus_to_eng($nnn);
	
	$filenames = __images_set_img_name("../csv/", $nnn, "csv" );
	//$filenames = __fp_set_name("../tmp/", iconv("UTF-8", "CP1251", $_GET["qqfile"], "");
	$res = copy("../tmp/".iconv("UTF-8", "CP1251", $_GET["qqfile"]), "../csv/".$filenames);
	if($res) {
		$query = "INSERT INTO files_csv (name, parent, link, prior) VALUES ('img', $parent, '$filenames', 0)";
		$resp = mysql_query($query);
		unlink("../tmp/".iconv("UTF-8", "CP1251", $_GET["qqfile"]));
		echo "{\"success\":\"true\", \"newimgid\":\"".getfileinfo()."\"}";
		$aa = true;
	} else {
		echo "{\"success\":\"false\"}";
	}
}
//*****************************************************************
//**********  Переименование файла
//echo "переименование<br/>\n";
$aa=false;
if($aa){
	//echo "переименование включено<br/>\n";
	$resp = mysql_query("select * from files_csv order by id desc limit 0,1");
	$row=mysql_fetch_assoc($resp);
	
	if($row["parent"]){
		$image = "../csv/$row[link]";
		//echo "переименовываем ../csv/$row[link]<br/>\n";
		//$image = "../images/__testres.csv";
		$image_in=imagecreatefromjpeg($image);
		$img_w = imagesx($image_in);
		$img_h = imagesy($image_in);
		//echo "получены размеры изображения:  $img_w x $img_h<br/>\n";
		$sresp = mysql_query("select * from items where id=$row[parent]");
		$srow = mysql_fetch_assoc($sresp);
		$imgname = $srow["href_name"]."_.csv";
		
		$res = copy("../csv/".$row["link"], "../csv/".$srow["href_name"]."_.csv");
		//if(!$res) echo "не удалось скопировать данный файл<br/>\n";
		//if($res) echo "Данный файл скопирован<br/>\n";
		if(file_exists("../csv/".$srow["href_name"]."_.csv")){
			//echo "Файл ../csv/".$srow["href_name"]."_.csv существует<br/>\n";
		}
		//echo "imgname=$imgname<br/>\n";
		
		if($img_w>1600) {
			$img_w=1600;
			$img_h = 1200;
		}
		//echo "Запуск функции конвертирования:<br/>\n";
		$image1 = __images_load_and_convert($row["link"], $imgname, 8000000, "../tmp/", "../csv/", $img_w."x$img_h");
		//echo "функция конвертирования выполнена, результат: $image1<br/>\n";
		
		
		unlink("../csv/".$row["link"]);
		unlink("../csv/".$srow["href_name"]."_.csv");
		$respo = mysql_query("update images set link='$image1' where id=$row[id] ");
		
		//echo "image1=$image1<br/>\n";
	}
}

//echo "<pre>";
//echo "asd";
//print_r($_FILES);
//echo "</pre>"

//echo "{\"success\":\"mytest = ";
//echo $_GET["mytest"];
//echo $_FILES["qqfile"]["name"];
//echo "::: get = ".$_GET['qqfile'];
//echo"\"}";
//echo "{arr:";
//print_r($_FILES);
//echo "}";
/* if(!$_FILES["qqfile"] && !$_GET["qqfile"]){ ?>
<form action="?parent=1896" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <input name="qqfile" type="file" id="qqfile" />
  <input type="submit" name="Submit" value="Submit" />
</form>
<?  }  */ ?>

