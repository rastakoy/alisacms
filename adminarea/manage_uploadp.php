<div id="fm_panel" class="fm_panel">
	<div class="fm_panel_group">
		<select name="folder_item_type" class="folder_select" id="folder_item_type" 
		style="width:150px; display: block; float:left;" onChange="__of_mup_get_provider_select(this.value)">
		  <option value="0" selected>Выберите производителя</option>
		  <? $respit = mysql_query("select * from providers order by id asc");
			while($rowit = mysql_fetch_assoc($respit)){
				if($row["itemtype"] == $rowit["id"]) $selected = "selected"; else $selected = "";
				echo "<option value=\"$rowit[id]\" $selected >$rowit[name]</option>";
			} ?>
		</select>
		<!-- <div id="fm_panel_button"><img src="images/of/fm_delete.gif" width="16" height="16"></div> -->
	</div>
	<div class="fm_panel_group" style="display:none;" id="file_panel">
		<iframe frameborder="0" scrolling="no" width="150" height="30" src="manage_uploadp_file.php" ></iframe>
		<!--<div id="fm_panel_button" onClick="__of_up_add_field()"><img src="images/of/fm_plus.gif" width="16" height="16"></div>-->
	</div>
	<div class="fm_panel_group" style="display:none; padding-top:7px; 
	padding-left:5px; padding-right:5px; height:20px;" id="item_off_panel">
		<input type="checkbox" name="check_item_off" value="1" id="check_item_off">Выключать ненайденные элементы
	</div>
	<div class="fm_panel_group" style="display:none; padding-top:3px; 
	padding-left:5px; padding-right:5px; height:20px;" id="price_coff_panel">
		  Цена %<input name="price_coff" type="text" id="price_coff" style="width: 25px;" maxlength="3">
	</div>
	<div class="fm_panel_group" style="display:none; padding-top:3px; 
	padding-left:5px; padding-right:5px; height:20px;" id="dollar_panel">
		  В ин.валюте <input type="checkbox" name="check_item_off" value="1" id="check_dollar">
		  Курс <input name="price_coff" type="text" id="price_dollar" style="width: 50px;" maxlength="5" disabled="disabled">
	</div>
	<div class="fm_panel_group" style="display:none; padding-top:3px; 
	padding-left:5px;  padding-right:5px; height:20px;" id="price_load_panel">
		  <input type="button" name="price_load" id="price_load" value="Обработать" onClick="__of_mup_start_convert()">
	</div>
</div>
<!--  ----------------------------------------------------  -->
<div id="divcontent"></div>
<?

?>
<script type="text/javascript" src="js/__ajax_of_manage_upload.js"></script>

