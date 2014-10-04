<?
$query = "select * from images where id=$pid";
$resp = mysql_query($query);
$rowi = mysql_fetch_assoc($resp);
?>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="35"><strong>Описание изображения </strong></td>
  </tr>
  <tr>
    <td width="210" valign="top"><img src="../imgres.php?resize=200&link=loadimages/<?  echo $rowi["link"]; ?>" width="200" height="150" border="0"></td>
    <td valign="top"><textarea name="snipid_cont" cols="50" rows="5" id="snipid_cont"><?  echo $rowi["cont"]; ?></textarea></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="center"><a href="javascript:save_new_img_popup(<?  echo $pid; ?>)">Сохранить</a> :: <a href="javascript:hide_new_img_popup()">Отменить</a></td>
  </tr>
</table>
