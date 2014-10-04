<? //echo show_images_for_items(2571); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="230" valign="top" style="padding: 14px;">
		<a href="javascript:getelementproperties_bg('<?  echo $elname; ?>')">Cвойства фона</a><br />
		<br />
		<a href="javascript:getelementproperties_txt('<?  echo $elname; ?>')">Свойства шрифта</a><br />
		<br />
		<strong>Свойства блока</strong>
		<br/><br/>
		<a href="javascript:getelementproperties_pos('<?  echo $elname; ?>')">Позиция</a>
		<br/><br/>
		<a href="javascript:getelementproperties_bor('<?  echo $elname; ?>')">Обводка (border)</a>
		<pre><?  //print_r($mass); ?></pre>
		</td>
		<td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="5">
            <tr>
              <td height="30" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><strong>Элемент &quot;<?  echo $elname; ?>&quot; </strong></td>
                    <td width="30"><div align="center"><img src="/adminarea/images/green/icon_close_ucw.gif" width="17" height="17" style="cursor:pointer;" onclick="se_hide_menu_css()" /></div></td>
                  </tr>
              </table></td>
            </tr>
          <tr>
             <td width="150" height="30" bgcolor="#E9E9E9">Ширина</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "width"));
			?><input name="se_boxwidth" type="text" id="se_boxwidth"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Высота</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "height"));
			?><input name="se_boxheight" type="text" id="se_boxheight"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Float</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "float"));
			?><select name="se_boxfloat" id="se_boxfloat" style="width:70px;">
              <option value="false"></option>
              <option value="left" <?  if($myval=="left") echo "selected"; ?> >left</option>
              <option value="right" <?  if($myval=="right") echo "selected"; ?> >right</option>
              <option value="none" <?  if($myval=="none") echo "selected"; ?> >none</option>
            </select></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Clear</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "clear"));
			?><select name="se_boxclear" id="se_boxclear" style="width:70px;">
              <option value="false"></option>
              <option value="left" <?  if($myval=="left") echo "selected"; ?> >left</option>
              <option value="right" <?  if($myval=="right") echo "selected"; ?> >right</option>
              <option value="both" <?  if($myval=="both") echo "selected"; ?> >both</option>
              <option value="none" <?  if($myval=="none") echo "selected"; ?> >none</option>
                        </select></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9"><strong>Отступ padding </strong></td>
            <td height="30" bgcolor="#E9E9E9">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">padding-top</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "padding-top"));
			?><input name="se_box_ptop" type="text" id="se_box_ptop"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">padding-right</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "padding-right"));
			?><input name="se_box_pright" type="text" id="se_box_pright"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">padding-bottom</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "padding-bottom"));
			?><input name="se_box_pbottom" type="text" id="se_box_pbottom"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">padding-left</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "padding-left"));
			?><input name="se_box_pleft" type="text" id="se_box_pleft"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9"><strong>Отступ margin </strong></td>
            <td height="30" bgcolor="#E9E9E9">&nbsp;</td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">margin-top</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "margin-top"));
			?><input name="se_box_mtop" type="text" id="se_box_mtop"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">margin-right</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "margin-right"));
			?><input name="se_box_mright" type="text" id="se_box_mright"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">margin-bottom</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "margin-bottom"));
			?><input name="se_box_mbottom" type="text" id="se_box_mbottom"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">margin-left</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "margin-left"));
			?><input name="se_box_mleft" type="text" id="se_box_mleft"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="40" colspan="2"><div align="center"><img src="/adminarea/images/green/save.gif" width="100" height="18" style="cursor:pointer;" onclick="__getelementproperties_save_box()" />  <img src="/adminarea/images/green/look.gif" width="100" height="18" style="cursor:pointer;" onclick="se_show_prev_box()" /></div></td>
          </tr>
        </table></td>
	</tr>
</table>