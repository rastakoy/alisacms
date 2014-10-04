<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="230" valign="top" style="padding: 14px;">
		<a href="javascript:getelementproperties_bg('<?  echo $elname; ?>')">Cвойства фона</a><br />
		<br />
		<a href="javascript:getelementproperties_txt('<?  echo $elname; ?>')">Свойства шрифта</a><br/>
		<br />
		<a href="javascript:getelementproperties_box('<?  echo $elname; ?>')">Cвойства блока</a><br />
		<br />
		<a href="javascript:getelementproperties_pos('<?  echo $elname; ?>')">Позиция</a>
		<br/><br/>
		<strong>Обводка (border)</strong>
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
            <td height="30" bgcolor="#E9E9E9">Заливка (верх) </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-top-style"));
			?><input name="se_bts" type="text" id="se_bts"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Заливка (право)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-right-style"));
			?><input name="se_brs" type="text" id="se_brs"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Заливка (низ)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-bottom-style"));
			?><input name="se_bbs" type="text" id="se_bbs"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Заливка (лево)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-left-style"));
			?><input name="se_bls" type="text" id="se_bls"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
             <td width="150" height="30" bgcolor="#E9E9E9">Толщина (верх)</td>
             <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-top-width"));
			?><input name="se_btw" type="text" id="se_btw"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Толщина (право)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-right-width"));
			?><input name="se_brw" type="text" id="se_brw"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Толщина (низ)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-bottom-width"));
			?><input name="se_bbw" type="text" id="se_bbw"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Толщина (лево)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-left-width"));
			?><input name="se_blw" type="text" id="se_blw"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Цвет (верх) </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-top-color"));
			?><input name="se_btc" type="text" id="se_btc"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Цвет (право)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-right-color"));
			?><input name="se_brc" type="text" id="se_brc"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Цвет (низ)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-bottom-color"));
			?><input name="se_bbc" type="text" id="se_bbc"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Цвет (лево)</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "border-left-color"));
			?>
            <input name="se_blc" type="text" id="se_blc"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
		  </tr>
          <tr>
            <td height="40" colspan="2"><div align="center"><img src="/adminarea/images/green/save.gif" width="100" height="18" style="cursor:pointer;" onclick="__getelementproperties_save_bor()" />  <img src="/adminarea/images/green/look.gif" width="100" height="18" style="cursor:pointer;" onclick="se_show_prev_bor()" /></div></td>
          </tr>
        </table></td>
	</tr>
</table>