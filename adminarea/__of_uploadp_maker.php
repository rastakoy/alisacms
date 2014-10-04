<?
$uploadp_step = $_POST["uploadp_step"];
if(!$uploadp_step) $uploadp_step=1;
?>
<div id="fm_panel" class="fm_panel">
	<div class="fm_panel_group">
		<select name="folder_item_type" class="folder_select" id="folder_item_type" 
		style="width:150px; display: block; float:left;" onChange="__of_up_get_template(this.value)">
		  <option value="0" selected>Форма не задана</option>
		  <? $respit = mysql_query("select * from providers order by id asc");
			while($rowit = mysql_fetch_assoc($respit)){
				if($row["itemtype"] == $rowit["id"]) $selected = "selected"; else $selected = "";
				echo "<option value=\"$rowit[id]\" $selected >$rowit[name]</option>";
			} ?>
		</select>
		<!-- <div id="fm_panel_button"><img src="images/of/fm_delete.gif" width="16" height="16"></div> -->
	</div>
	<div class="fm_panel_group">
		<div class="fm_panel_button" onClick="__of_up_add_field()"><img src="images/of/fm_plus.gif" width="16" height="16"></div>
	</div>
</div>

<!--  ----------------------------------------------------  -->
<div id="tmp_content"></div>
<div id="code_content" style="display:none;">
<div style="background-color:#FFFFFF; padding:14px;"><b>Редактор кода</b></div>
<textarea id="code_content_ta"
style="font-family:Verdana; font-size:12px; width:100%; height: 250px; padding:14px;"></textarea>
<div align="center" style="padding-top: 14px;">
<img  onclick="save_code()" src="images/green/save.gif" width="100" height="18" border=\"0\" style="cursor:pointer;">
<img onclick="cancel_code()" src="images/green/cancel.gif" width="100" height="18" border="0" style="cursor:pointer;">
<img onclick="cancel_code()" src="images/green/delete.gif" width="100" height="18" border="0" style="cursor:pointer;">
</div>
</div>
<script type="text/javascript" src="js/__ajax_of_uploadp_maker.js"></script>
