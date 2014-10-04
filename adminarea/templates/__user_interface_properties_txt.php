<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="230" valign="top" style="padding: 14px;">
		<a href="javascript:getelementproperties_bg('<?  echo $elname; ?>')">Cвойства фона</a><br />
		<br />
		<strong>Свойства шрифта</a></strong><br/>
		<br />
		<a href="javascript:getelementproperties_box('<?  echo $elname; ?>')">Cвойства блока</a><br />
		<br />
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
             <td width="150" height="30" bgcolor="#E9E9E9">Шрифт</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "font-family"));
			?><input name="se_txt_font" type="text" id="se_txt_font"  style="width:300px;" value='<?  echo $myval; ?>' /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Размер шрифта </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "font-size"));
			?><input name="se_txt_size" type="text" id="se_txt_size"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Стиль шрифта </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "font-style"));
			?><input name="se_txt_style" type="text" id="se_txt_style"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Высота линии </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "line-height"));
			?><input name="se_txt_lheight" type="text" id="se_txt_lheight"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="30" bgcolor="#E9E9E9">Жирность</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "font-weight"));
			?><input name="se_txt_weight" type="text" id="se_txt_weight"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Преобразование</td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "text-transform"));
			?><input name="se_txt_transform" type="text" id="se_txt_transform"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Цвет </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "color"));
			?><input name="se_txt_color" type="text" id="se_txt_color"  style="width:100px;" value="<?  echo $myval; ?>" /></td>
          </tr>
		  <tr>
            <td height="30" bgcolor="#E9E9E9">Декорирование </td>
            <td height="30" bgcolor="#E9E9E9"><?
			$myval = trim(__fa_get_element_in_array_by_key($mass, "text-decoration"));
			?><input name="se_txt_decor" type="text" id="se_txt_decor"  style="width:350px;" value="<?  echo $myval; ?>" /></td>
          </tr>
          <tr>
            <td height="40" colspan="2"><div align="center"><img src="/adminarea/images/green/save.gif" width="100" height="18" style="cursor:pointer;" onclick="__getelementproperties_save_txt()" /></div></td>
          </tr>
        </table></td>
	</tr>
</table>