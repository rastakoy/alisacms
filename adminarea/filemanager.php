<?php
$__tree_show_image = 1;
$tree_index = 0;
//**************************************
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_csv.php");
require_once("../core/__functions_tree_semantic.php");
require_once("../core/__functions_images.php");
require_once("../core/__functions_pages.php");
dbgo();
$outinfo = "";
//require_once("__class_csvToArray.php"); // Загрузка файла библиотеки
//$csv_class =& new csvToArray("csv_class"); //Объявление класса csv 
$__page_parent=$_GET["parent"];
//print_r($_POST);

?>

<html>
<?  require_once("__head.php"); ?>
<?
if($_GET["nf"]==1){  echo "<script>var nf=1;</script>"; }
?>
<body style="padding: 20px;">

<ul id="myMenu" class="contextMenu">
	<li id="contextFilesDelete"><a href="#pictype_gal" id="pictype_gal">Удалить файл</a></li>
</ul>

<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td valign="top" style="padding: 5px; margin-bottom: 20px; min-height:220px;"><h1>Файловый менеджер</h1>
<div style="margin-bottom: 10px;"><a href="javascript:__filemanager_delete_sel_files()"><b>Удалить отмеченные файлы</b></a></div>
<div id="myDiv">

<ul id="files_items">
	<li class="ui-state-default" style="padding-top:0px; height:80px;" id="li_load_images" ><div  id="file-uploader">
		<noscript><p>Please enable JavaScript to use file uploader.</p></noscript></div>
	</li>
</ul>

</div>
<div style="float:none; clear:both"></div>
<ul id="sortable" style="display:none; margin-top:30px;"></ul>
<div style="float:none; clear:both"></div>
</td></tr>
</table>
<script>
//******************************
var files_selected;
//******************************
function __jl_init_uploader(){
	var uploader = new qq.FileUploader({
		// pass the dom node (ex. $(selector)[0] for jQuery users)
		element: $('#file-uploader')[0],
		action: 'upload_filemanager.php',
		params: {parent: cur_item_id},
		onComplete: function(id, fileName, responseJSON){
			//alert("upload: "+fileName+"\n-------\n"+responseJSON);
			if(responseJSON["success"] == "true"){
				//document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
			} else {
				//document.getElementById('divinfo').innerHTML += "Загрузка файла завершилась неудачей<br/>";
				//document.getElementById('divinfo').innerHTML += responseJSON["success"]+"<br/>\n";
				//document.getElementById('divinfo').innerHTML += "----<br/>\n";
			}
			if(responseJSON["success"] == "true"){
				files_get_files();
				//alert(responseJSON["fileext"]);
				//show_new_img_popup(responseJSON["newimgid"]);
				//show_files_popup(responseJSON["newimgid"]);
			}
		}
	});
}
//******************************
function init_context_menu(){
	//*****
	$("#myDiv").contextMenu({
				menu: 'myMenu',
				oncontext: function(){
								  alert("ok");
				},
				onShowMenu: function(){
								  alert("ok2");
				}
	},
	function(action, el, pos) {
		//obj_tt = document.getElementById(cur_simgid);
		//alert(obj_tt.style.backgroundImage);
		if(  action=="contextFilesDelete"  ){
			alert("delete file");
		}
	});
	//*****
}
//******************************
__jl_init_uploader();
files_get_files();
//init_context_menu();
</script>
</body></html>