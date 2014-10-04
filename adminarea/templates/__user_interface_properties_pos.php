<? //echo show_images_for_items(2571); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="230" valign="top" style="padding: 14px;">
		<a href="javascript:getelementproperties_bg('<?  echo $elname; ?>')">Cвойства фона</a><br />
		<br />
		<a href="javascript:getelementproperties_txt('<?  echo $elname; ?>')">Свойства шрифта</a><br />
		<br />
		<a href="javascript:getelementproperties_box('<?  echo $elname; ?>')">Cвойства блока</a><br />
		<br />
		<strong>Свойства позиции</strong>
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
             <td width="150" height="30" bgcolor="#E9E9E9">Позиция</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "position"));
			?>
              <select name="se_pospos" id="se_pospos" style="width:70px;">
                <option value="false"></option>
                <option value="absolute" <?  if($myval=="absolute") echo "selected"; ?> >absolute</option>
                <option value="fixed" <?  if($myval=="fixed") echo "selected"; ?> >fixed</option>
                <option value="relative" <?  if($myval=="relative") echo "selected"; ?> >relative</option>
                <option value="static" <?  if($myval=="static") echo "selected"; ?> >static</option>
                            </select> </td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Visibility</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "visibility"));
			?>
              <select name="se_posvisibility" id="se_posvisibility" style="width:70px;">
                <option value="false"></option>
                <option value="inherit" <?  if($myval=="inherit") echo "selected"; ?> >inherit</option>
                <option value="visible" <?  if($myval=="visible") echo "selected"; ?> >visible</option>
                <option value="hidden" <?  if($myval=="hidden") echo "selected"; ?> >hidden</option>
              </select></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Z-index</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "z-index"));
			?><input name="se_posz" type="text" id="se_posz"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Overflow</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "overflow"));
			?>
              <select name="se_posoverflow" id="se_posoverflow" style="width:70px;">
                <option value="false"></option>
                <option value="visible" <?  if($myval=="visible") echo "selected"; ?> >visible</option>
                <option value="hidden" <?  if($myval=="hidden") echo "selected"; ?> >hidden</option>
                <option value="scroll" <?  if($myval=="scroll") echo "selected"; ?> >scroll</option>
                <option value="auto" <?  if($myval=="auto") echo "selected"; ?> >auto</option>
              </select></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Положение left </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "left"));
			?><input name="se_posleft" type="text" id="se_posleft"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Положение top </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "top"));
			?><input name="se_postop" type="text" id="se_postop"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Положение right </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "right"));
			?><input name="se_posright" type="text" id="se_posright"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Положение bottom </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "bottom"));
			?><input name="se_posbottom" type="text" id="se_posbottom"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Clip</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "clip"));
			?><input name="se_posclip" type="text" id="se_posclip"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="40" colspan="2"><div align="center"><img src="/adminarea/images/green/save.gif" width="100" height="18" style="cursor:pointer;" onclick="__getelementproperties_save_pos()" />  <img src="/adminarea/images/green/look.gif" width="100" height="18" style="cursor:pointer;" onclick="se_show_prev_pos()" /></div></td>
          </tr>
        </table></td>
	</tr>
</table>