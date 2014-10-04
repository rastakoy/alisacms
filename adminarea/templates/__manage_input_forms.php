<?
if($edit){
	echo "<div style=\"text-transform: uppercase;\">Редактировать ";
	}
else{
	echo "<div id=\"sb_plus\" style=\"display: block; float: left; width: 15px;\"><b>+</b></div>
	<div id=\"sb_minus\" style=\"display: none; float: left; width: 15px;\"><b>-</b>
	</div> <a href=\"javascript:show_block()\" style=\"text-transform: uppercase;\">Добавить  ";
	}
?>
объект
<?
if(!$edit) echo "</a>";
if($edit){
	echo "Или <a class=\"amip\" href=\"$_SERVER[PHP_SELF]?parent=$parent&new_object=1\">Добавить новый объект</a>";
}
?>