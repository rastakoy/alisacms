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
//require_once("__functions_register.php");
//require_once("__functions_rating.php");
//require_once("__functions_pages.php");
dbgo();
$__page_name = "index";
$__page_title = "Конфигуратор";
?>
<html>
<?  require_once("__head.php"); ?>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif; line-height: 18px; padding: 20px;">
<div class="all_items_types">
<h3>Конфигуратор</h3>
<?
$resp = mysql_query("select * from itemstypes order by id asc");
while($row = mysql_fetch_assoc($resp)){
	echo "<div class=\"itemtype_name\"><a style=\"itemstypes_img\" href=\"javascript:show_conf($row[id])\">$row[name]</a></div><div class=\"itemtype_name_z\" id=\"itemtype_name_$row[id]\"></div>";
}
?>
</div>
<div id="div_mypopup" style="display:none;">
<a href="javascript:show_pref()">Настройка</a><br/>
<a href="javascript:">Редактировать</a><br/>
<a href="javascript:">Удалить</a>
</div>
<script src="js/manage_configurator.js"></script>
</body>
</html>