<div id="fm_panel" class="fm_panel">
<div class="fm_panel_group">
	<div class="fm_panel_button" onClick="add_type()"><img src="images/of/fm_plus.gif" width="16" height="16"></div>
	<select name="folder_item_type" class="folder_select" id="folder_item_type" 
	style="width:150px; display: block; float:left;" onChange="get_template(this.value)">
      <option value="0" selected>Форма не задана</option>
      <? $respit = mysql_query("select * from itemstypes order by id asc");
		while($rowit = mysql_fetch_assoc($respit)){
			if($row["itemtype"] == $rowit["id"]) $selected = "selected"; else $selected = "";
			echo "<option value=\"$rowit[id]\" $selected >$rowit[rus_name]</option>";
		} ?>
	</select>
	<!-- <div id="fm_panel_button"><img src="images/of/fm_delete.gif" width="16" height="16"></div> -->
</div>
<div class="fm_panel_group">
	<div class="fm_panel_button" onClick="__aofm_addItemToTeplate('inputcheckbox')">
		<img src="images/of/fm_add_inputcheckbox.gif" width="16" height="16"></div>
	<div class="fm_panel_button" onClick="__aofm_addItemToTeplate('inputtext')">
		<img src="images/of/fm_add_inputtext.gif" width="16" height="16"></div>
	<div class="fm_panel_button" onClick="__aofm_addItemToTeplate('textarea')">
		<img src="images/of/fm_add_textarea.gif" width="16" height="16"></div>
	<div class="fm_panel_button" onClick="__aofm_addItemToTeplate('selectfromitems')">
		<img src="images/of/fm_add_selectfromitems.gif" width="16" height="16"></div>
	<!--<div class="fm_panel_button"><img src="images/of/fm_add_hidden.gif" width="16" height="16"></div>-->
</div>
<div class="fm_panel_group">
	<div class="fm_panel_button" onClick="__aofm_editDatabase()">
		<img src="images/of/fm_edit_database.gif" width="16" height="16"></div>
</div>
<div class="fm_panel_group" id="DBManager" style="display:none;">
	<div class="fm_panel_button" onClick="__aofm_addToDatabase()">
		<img src="images/of/fm_plus_database.gif" width="16" height="16"></div>
</div>
</div>
<div id="tmp_content"></div>
<script type="text/javascript" src="js/__ajax_of_form_maker.js"></script>