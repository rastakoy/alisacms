<?
if($_POST["submit"]=="��������� ������"){
	$query = "select * from pages order by id asc";
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)) {
		$a = $_POST[$row["name"]];
		$q = "update pages set cont='$a' where name='$row[name]'  ";
		//echo $q."<br/>\n";
		$resps = mysql_query($q);
	}
}
?>
&nbsp;
<h1 align="center">��������� �����</h1>
<form method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
<?
$query = "select * from pages order by id asc";
$resp = mysql_query($query);
while($row=mysql_fetch_assoc($resp)) {
?>
<tr>
    <td width="150" height="75" class="folders_td_left">
	<strong><?  echo $row["rusname"]; ?>:</strong>
	<?
	if($row["name"]=="lookbasket"){
		echo "<a href=\"javascript:setLookBasketVal('����')\">����</a><br/>";
		echo "<a href=\"javascript:setLookBasketVal('������')\">������</a><br/>";
		echo "<a href=\"javascript:setLookBasketVal('��������� �������������')\">��������� �������������</a><br/>";
		echo "<a href=\"javascript:setLookBasketVal('������������������')\">������������������</a><br/>";
	}
	?></td>
    <td width="20">&nbsp;</td>
    <td width="400" class="folders_td_cont">
	  <textarea name="<?  echo $row["name"]; ?>" cols="60" rows="3" 
	  class="folder_inputt" <?  if($row["name"]=="lookbasket"){ echo "id=\"lookbasket\""; } ?>><?  echo $row["cont"]; ?></textarea></td></tr>
<?  } ?>
<tr>
    <td colspan="3" align="center"><input type="submit" name="submit" value="��������� ������" /></td>
</tr>
</table></form>
<script>
function setLookBasketVal(val){
	document.getElementById('lookbasket').value=val;
}
</script>