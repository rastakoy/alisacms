<?
//echo "asd: $pid";
$query = "select * from user_comments where id=$pid";
$resp  = mysql_query($query);
$row   = mysql_fetch_assoc($resp);
//print_r($row);
?>
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="35" valign="top"><div align="center"><strong>Комментарий пользователя</strong></div></td>
  </tr>
  <tr>
    <td valign="top">Комментарий<br /> 
    <textarea style="width:100%" name="uc_cont" cols="50" rows="4" id="uc_cont"><?  echo $row["cont"]; ?></textarea>
    <hr size="1" />
    Ваш ответ (не обязательно) <br />
    <textarea style="width:100%" name="uc_respon" cols="50" rows="4" id="uc_respon"><?  echo $row["respon"]; ?></textarea></td>
  </tr>
  <tr>
    <td height="30" align="center"><a href="javascript:save_uc(<?  echo $pid; ?>)">Сохранить</a> :: <a href="javascript:hide_new_img_popup()">Отменить</a></td>
  </tr>
</table>
