<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree.php");
require_once("../core/__functions_images.php");
dbgo();
require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 

eval(strip_get_vars_eval($HTTP_GET_VARS));
eval(strip_post_vars_eval($HTTP_POST_VARS));

//print_r($_POST);

if(!$parent) {
	$resp = mysql_query(" select * from items where parent=0 && href_name='items' && folder=1 ");
	$row = mysql_fetch_assoc($resp);
	$parent = $row["id"];
}
$__page_name = "manage_models";
if($parent){
$resp = mysql_query("select * from items where id=$parent");
$row = mysql_fetch_assoc($resp);
}
$__parafraf_name = $row["name"];
$__page_title = "Каталог продукции";
if($parent) $__page_title.= " — $__parafraf_name";
$__delete_link = "manage_models.php?delete=$delete&access=true&parent=$parent";
$__cancel_link = "manage_models.php?parent=$parent";
?>
<html>
<?  require_once("__head.php"); ?>

<body>
<?
require_once("tree/__js_show_tree_block_v3.php");
echo __farmmed_rekursiya_show_items_v3($parent, false, false, 0);
?>
</body>
</html>
