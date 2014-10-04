<? //echo show_images_for_items(2571); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="230" valign="top" style="padding: 14px;">
		Cвойства фона<br />
		<br />
		<a href="javascript:getelementproperties_txt('<?  echo $elname; ?>')">Свойства шрифта</a><br />
		<br />
		<a href="javascript:getelementproperties_box('<?  echo $elname; ?>')">Свойства блока</a>
		<br/><br/>
		<a href="javascript:getelementproperties_pos('<?  echo $elname; ?>')">Позиция</a>
		<br/><br/>
		<a href="javascript:getelementproperties_bor('<?  echo $elname; ?>')">Обводка (border)</a>
		</td>
		<td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="5">
            <tr>
              <td height="30" colspan="3">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><strong>Элемент &quot;<?  echo $elname; ?>&quot; </strong></td>
                    <td width="30"><div align="center"><img src="/adminarea/images/green/icon_close_ucw.gif" width="17" height="17" style="cursor:pointer;" onclick="se_hide_menu_css()" /></div></td>
                  </tr>
              </table></td>
            </tr>
          <tr>
             <td width="320" rowspan="6" valign="top" bgcolor="#E9E9E9"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                 <tr><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "background-image"));
			//echo "mv=$myval<br/>";
			$myval = preg_replace("/url\(\/loadimages\//", "", $myval);
			$myval = preg_replace("/\)/", "", $myval);
			//echo "mv=-$myval-<br/>";
			?><td width="314"><img id="bg_prewiev_image" src="<?  echo "imgres.php?resize=260&link=loadimages/$myval"; ?>" width="260" height="195" /></td>
                   <td width="30" valign="top"><div align="center"><img src="/adminarea/images/green/myitemname_popup/specpred<?  if($myval=="none") echo "_no"; ?>.gif" name="imgbgoff" width="16" height="16" id="imgbgoff" style="cursor:pointer;" onclick="elementproperties_toggle_bgimgoff(this)" /></div></td>
                 </tr>
               </table></td>
		    <td width="100" height="30" bgcolor="#E9E9E9"><div align="right">Цвет фона </div></td>
            <td height="30" bgcolor="#E9E9E9">
			<div id="div_colorpicker"></div><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "background-color"));
			?><img src="/adminarea/images/ui/button_spacer.gif" width="18" height="18" 
			style="position:absolute; cursor:pointer;" onclick="se_show_colors()" /><input 
			type="text" id="color_value" class="jqcp_value" size="8" value="<?  echo $myval; ?>" onchange="__getelementproperties_look_bg()">
			
			<div id="div_colorbox"><?  require_once("___colorbox.php"); ?></div>
			</td>
          </tr>
          <tr>
            <td width="100" height="30" bgcolor="#E9E9E9"><div align="right">Клонирование</div></td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "background-repeat"));
			?><select name="se_bgrepaet" id="se_bgrepaet" style="width:100px;" onchange="__getelementproperties_look_bg()">
              <option value="false"></option>
			  <option value="no-repeat" <?  if($myval=="no-repeat") echo "selected"; ?> >no-repeat</option>
              <option value="repeat" <?  if($myval=="repeat") echo "selected"; ?> >repeat</option>
              <option value="repeat-x" <?  if($myval=="repeat-x") echo "selected"; ?> >repeat-x</option>
              <option value="repeat-y" <?  if($myval=="repeat-y") echo "selected"; ?> >repeat-y</option>
            </select>            </td>
          </tr>
          <tr>
            <td width="100" height="30" bgcolor="#E9E9E9"><div align="right">Положение</div></td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "background-attachment"));
			?><select name="se_bgattach" id="se_bgattach" style="width:70px;" onchange="__getelementproperties_look_bg()">
              <option value="false"></option>
			  <option value="fixed" <?  if($myval=="fixed") echo "selected"; ?> >fixed</option>
              <option value="scroll" <?  if($myval=="scroll") echo "selected"; ?> >scroll</option>
            </select></td>
          </tr>
          <tr>
            <td width="100" height="30" bgcolor="#E9E9E9"><div align="right">Горизонтально</div></td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "background-position"));
			$myval = explode(" ", $myval);
			?><select name="se_bgpos_x" id="se_bgpos_x" style="width:70px;"
			onchange="if(this.value=='value') document.getElementById('se_bgpos_x_val').disabled='';
			else document.getElementById('se_bgpos_x_val').disabled='disabled';__getelementproperties_look_bg();">
              <option value="false"></option>
			  <option value="left" <?  if($myval[0]=="left") echo "selected"; ?> >left</option>
              <option value="center" <?  if($myval[0]=="center") echo "selected"; ?> >center</option>
              <option value="right" <?  if($myval[0]=="right") echo "selected"; ?> >right</option>
              <option value="value" <?  if($myval[0]!="left" && $myval[0]!="center" && $myval[0]!="right" && $myval[0]!="") echo "selected"; ?> >value</option>
            </select>
			<?  if($myval[0]!="left" && $myval[0]!="center" && $myval[0]!="right" && $myval[0]!="") { ?>
			<input onchange="__getelementproperties_look_bg()" name="se_bgpos_x_val" type="text" id="se_bgpos_x_val" style="width:50px;" value="<?  echo $myval[0]; ?>" />
			<?  } else { ?>
			<input onchange="__getelementproperties_look_bg()" name="se_bgpos_x_val" type="text" disabled="disabled" id="se_bgpos_x_val" style="width:50px;" />
			<?  } ?>
			</td>
          </tr>
          <tr>
            <td width="100" height="30" bgcolor="#E9E9E9"><div align="right">Вертикально</div></td>
            <td height="30" bgcolor="#E9E9E9"><select 
			name="se_bgpos_y" id="se_bgpos_y" style="width:70px;" 
			onchange="if(this.value=='value') document.getElementById('se_bgpos_y_val').disabled='';
			else document.getElementById('se_bgpos_y_val').disabled='disabled';__getelementproperties_look_bg();">
              <option value="false"></option>
			  <option value="top" <?  if($myval[1]=="top") echo "selected"; ?> >top</option>
              <option value="center" <?  if($myval[1]=="center") echo "selected"; ?> >center</option>
              <option value="bottom" <?  if($myval[1]=="bottom") echo "selected"; ?> >bottom</option>
              <option value="value" <?  if($myval[1]!="top" && $myval[1]!="center" && $myval[1]!="bottom" && $myval[1]!="")
			  echo "selected"; ?> >value</option>
            </select>
			<?  if($myval[1]!="top" && $myval[1]!="center" && $myval[1]!="bottom" && $myval[1]!="") { ?>
			<input onchange="__getelementproperties_look_bg()" name="se_bgpos_y_val" type="text" id="se_bgpos_y_val" style="width:50px;" value="<?  echo $myval[1]; ?>" />
			<?  } else { ?>
			<input onchange="__getelementproperties_look_bg()" name="se_bgpos_y_val" type="text" disabled="disabled" id="se_bgpos_y_val"  style="width:50px;" />
			<?  } ?>
			</td>
          </tr>
          <tr>
            <td width="100" height="30" bgcolor="#E9E9E9">&nbsp;</td>
            <td height="30" bgcolor="#E9E9E9">&nbsp;</td>
          </tr>
          <tr>
            <td height="40" colspan="3"><div align="center"><img src="/adminarea/images/green/save.gif" width="100" height="18" style="cursor:pointer;" onclick="__getelementproperties_save_bg()" />  <img src="/adminarea/images/green/look.gif" width="100" height="18" style="cursor:pointer;" onclick="se_show_prev()" /></div></td>
          </tr>
	<tr><td height="250" colspan="3" valign="top"><div style="overflow:auto; height:250px;">
	<?  echo "<div id='myDiv'>".show_images_for_items(false, true)."<div style='float:none; clear:both'></div></div>";  ?>
	</div></td>
	</tr>
        </table></td>
	</tr>
</table>