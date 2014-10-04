<?
header("Content-type: text/plain; charset=windows-1251");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_format.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_forms.php");
require_once("../core/__functions_loadconfig.php");
require_once("../core/__functions_full.php");
require_once("../core/__functions_pages.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_uploadp.php");
require_once("../core/__functions_auto.php");
require_once("../core/__functions_tmpl.php");

require_once("../filter/__functions_filter.php");


//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
//*************************
$paction = $_POST["paction"];
//*************************
if($paction=="get_constructor_start"){
	$elname = $_POST["elname"];
	$file = "../styles/tmpl-1/style.auto.css"; 
	$rmass = __fa_css_to_array($file, $elname);
	//**************
	$mass = __fa_get_bg_styles($rmass);
	require_once("templates/__user_interface_properties_bg.php");
}
//*************************
?>