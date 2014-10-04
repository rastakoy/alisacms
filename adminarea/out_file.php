<?
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
require_once("../core/__function_saver.php");

require_once("../filter/__functions_filter.php");


//require_once("__functions_register.php");
//require_once("__functions_rating.php");
dbgo();
//*************************
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class = new csvToArray("csv_class"); //Объявление класса csv 
//*************************
?>
<!--  -----------------------------------------------------------------------  -->
<html>
<?  require_once("__head.php"); ?>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px;">
<div id="of_title"><?  echo $_GET["title"]; ?></div>
<?  require_once($_GET["of"]); ?>
</body>
</html>
<!--  -----------------------------------------------------------------------  -->