<table width="100%" border="0" cellspacing="1" cellpadding="1">
<tr>
    <td width="70" bgcolor="#FFFFFF">№П/П</td>
    <td bgcolor="#FFFFFF">Номер</td>
    <td bgcolor="#FFFFFF">Текст</td>
    <td bgcolor="#FFFFFF">Дата</td>
	<td bgcolor="#FFFFFF">Баланс</td>
  </tr>
<?
$count = 1;
$resp = mysql_query("select * from smsmanager order by id desc  ");
while($row=mysql_fetch_assoc($resp)){ ?>
  <tr>
    <td width="70" bgcolor="#FFFFFF"><?=$count?></td>
    <td bgcolor="#FFFFFF"><?=$row['phone']?></td>
    <td bgcolor="#FFFFFF"><?=$row['text']?></td>
    <td bgcolor="#FFFFFF"><?=$row['time']?></td>
	<td bgcolor="#FFFFFF"><?=$row['balance']?></td>
  </tr>
<?
	$count++;
} ?></table> 

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

