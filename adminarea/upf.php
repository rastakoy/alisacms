<?
$tree_index = 0;
//**************************************
$parent = $_GET["parent"];
$prior = $_GET["prior"];
if(!$parent) $parent="0";
if(!$prior) $prior="0";
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_pages.php");
dbgo();
require_once("../__register.php");
$aa = false;
//print_r($_FILES);
//print_r($_POST);
//print_r($_GET);
//echo "{\"display\":\"parent=$parent\"}";
//exit;
//********************************
function getFtype($filename) {
	$ret = "file";
	$ext = getExtension($filename);
	if($ext=="jpg" || $ext=="jpeg"){
		$ret = "img";
	}
	return $ret;
}
//********************************
function getExtension($filename) {
	$arr = explode(".", $filename);
	return $arr[count($arr)-1];
	//return substr(strrchr($filename, '.'), 1);
}
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
	$query = "select * from filemanager order by id desc limit 0,1";
	$resp = mysql_query($query);
	$row = mysql_fetch_assoc($resp);
	return $row["id"];
}
//********************************
if($_FILES["qqfile"]){
	$adddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
	$ext = getExtension($_FILES["qqfile"]["name"]);
	$filenames = __images_set_img_name("../userupload/", $_FILES["qqfile"]["name"], $ext );
	$res = copy(iconv("UTF-8", "CP1251", $_FILES["qqfile"]["tmp_name"]), "../userupload/".$filenames);
	if($res) {
		$query = "INSERT INTO filemanager (name, link, ftype, fileadddate, parent, prior) VALUES ('$ext', '$filenames', '".getFtype($filenames)."', $adddate, $parent, $prior)";
		$resp = mysql_query($query);
		echo "{\"success\":\"true\", \"newfileid\":\"".getfileinfo()."\"}";
		$aa = true;
	} else {
		echo "{\"success\":\"false\"}";
	}
}
//********************************
//print_r($_COOKIE);
//print_r($row_user);
if(isset($_GET["qqfile"])){
	//save("../files/asd.tmp");
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
	
	$adddate = mktime (date("G") ,date("i") ,date("s") , date("m")  ,date("d"),date("Y"));
	$ext = getExtension($nnn);
	$filenames = __images_set_img_name("../userupload/", $nnn, $ext );
	//$filenames = __fp_set_name("tmp/", iconv("UTF-8", "CP1251", $_GET["qqfile"], "");
	$ptype = $_GET["ptype"];
	$res = copy("../tmp/".$nnn, "../userupload/".$filenames);
	if($res) {
		$query = "INSERT INTO filemanager (name, link, ftype, fileadddate, ptype, parent, prior) 
		VALUES ('$ext', '$filenames', '".getFtype($filenames)."', $adddate, '$ptype', $parent, $prior)";
		$resp = mysql_query($query);
		unlink("../tmp/".iconv("UTF-8", "CP1251", $_GET["qqfile"]));
		echo "{\"success\":\"true\", ";
		foreach($_GET as $key=>$val)
			echo " \"$key\":\"$val\", ";
		echo "\"newid\":\"".getfileinfo()."\", \"fileext\":\"".getExtension($nnn)."\" }";
		$aa = true;
	} else {
		echo "{\"success\":\"false\"}";
	}
}
//echo "{\"success\":\"false\"}";
//*****************************************************************

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

