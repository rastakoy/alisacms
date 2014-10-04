<?php
$__tree_show_image = 1;
$tree_index = 0;
//**************************************
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../__functions.php");
require_once("../__functions_csv.php");
require_once("../__functions_tree_semantic.php");
require_once("../__functions_images.php");
require_once("../__functions_pages.php");
dbgo();
$outinfo = "";
//require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
//$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 
$__page_parent=$_GET["parent"];
//print_r($_POST);

?>

<html>
<?  require_once("__head.php"); ?>

<body>

<?  require_once("__tiny.php"); ?>
<div id="divinfo" style="display:none;"></div>
<div id="popupmy" style="display:none;">Тестируем проверку попапов для редактирования, скажем названия и описания изображения</div>
<div class="menu"><div class="submenu">
	<div class="menutitle">Главное меню</div>
	<?  require_once("__menu.php"); ?>
</div></div>

<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarealeft"><img src="images/spacer.gif" width="350" height="5"/></td>
    <td class="adminarearight" valign="top">
		<div class="admintitle">
		<a href="javascript:"><img id="additemtocatalogbutton" src="images/green/__top_add_item.gif" width="23" height="23" border="0"></a>
		<a href="javascript:"><img id="edititembutton" src="images/green/__top_edit_na.gif" width="23" height="23" border="0"></a>
		<a href="javascript:"><img id="showinfobutton" src="images/green/__top_info.gif" width="23" height="23" border="0"></a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="javascript:"><img id="deletefolderbutton" src="images/green/__top_delete.gif" width="23" height="23" border="0"></a>
	    <?  //echo $__page_title; ?>
		</div>
		<div id="additemtocatalogselect" style="display:none;">
			<a href="javascript:addItemToCatalog(1)">Папка</a><br/>
			<a href="javascript:addItemToCatalog(0)">Запись</a>
		</div>
		
		<div class="manageadminforms" id="edit_content" style="display:none;">
		  А вот сюда загрузится модуль редактирования папки
	  </div>
	  
<!-- ******************************************************************************************-->
<!--<div id="inline1" ><p>
	Image gallery <small>(ps, try using mouse scroll wheel) </small><br />

	<a rel="example_group" title="Custom title" href="http://farm3.static.flickr.com/2641/4163443812_df0b200930.jpg">
		<img alt="" src="http://farm3.static.flickr.com/2641/4163443812_df0b200930_m.jpg" />
	</a>
	
	<a rel="example_group" title="" href="http://farm3.static.flickr.com/2591/4135665747_3091966c91.jpg">
		<img alt="" src="http://farm3.static.flickr.com/2591/4135665747_3091966c91_m.jpg" />
	</a>
	
	<a rel="example_group" title="" href="http://farm3.static.flickr.com/2561/4048285842_90b7e9f8d1.jpg">
		<img alt="" src="http://farm3.static.flickr.com/2561/4048285842_90b7e9f8d1_m.jpg" />
	</a>
</p></div>-->
<!-- ******************************************************************************************-->
	  
</td></tr></table>

<script>alert("OK");
get_menu("0");
show_ritems("0");
//init_dop_popup_v_01();
//obj_div_myitemname = document.getElementById("div_myitemname");

//JQuery(obj_div_myitemname).hover(function() {
//		alert("ok");
//		$(obj_div_myitemname).css('background-color', 'white');
//	});
</script>
<? if($error) echo "<script>alert('$error')</script>"; ?>
<?  require_once("__footer.php"); ?>
</body>
</html>