<?php
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
dbgo();
$__page_name = "wrong";
$__page_title = "Список зарегистрированных на сайте пользователей";
$id=$_POST["id"];
$discount=$_POST["discount"];
$deleteuser = $_GET["deleteuser"];
if($deleteuser){
	$resp = mysql_query("delete from users where id=$deleteuser");
}
if($id){
	$resp = mysql_query("update users set discount=$discount where id=$id");
}
//*************************************************************
$id_ue				=$_POST["id_ue"];
$discount_ue		=$_POST["discount_ue"];
$diller_ue			=$_POST["diller_ue"];
//*********************************
print_r($_POST);
if($id_ue){
	if(!$diller_ue) $diller_ue="0";
	$query = "update users set diller=$diller_ue  where id=$id_ue";
	echo $query."<br/>\n";
	$resp = mysql_query($query);
	$resp = mysql_query("update users set discount=$discount_ue  where id=$id_ue");
}
//*************************************************************
?>
<html>
<?  require_once("__head.php"); ?>
<?  //require_once("__js_show_block.php"); ?>
<?
//PROGRAM CODE HERE
//****************

//****************
?>
<body>
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarearight" valign="top">
		<div class="admintitle"><?  echo $__page_title; ?></div>
		
            <?
	  $resp = mysql_query("select * from users where reg=1  order by id asc ");
	  while($row=mysql_fetch_assoc($resp)){
	  ?>
            <table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
			<tr <?  if($row["look_basket"]==1) { echo "  bgcolor=\"#EFD1D1\">  ";  } else { ?>bgcolor="#FFFFFF"><?  }  ?>
              <td width="300" height="40" ><div align="left">
			  <? 
			  	echo "<b>".$row["login"]."</b><br/>".$row["fio"];
			  ?>
			  </div></td>
			   <td width="200"><input type="checkbox" name="checkbox" value="checkbox" class="userbasket" id="userbasket_<?  echo $row["id"];  ?>"
			   <?  if($row["look_basket"]==1) echo "  checked  ";  ?> > Добавить к просмотру</td>
              <!--<td width="40"><div align="center"><strong><? echo $row['prior']; ?></strong></div></td>-->
              <td>
                <!--<form name="form<?  echo $row["id"]; ?>" method="post" action="">
                  <input name="discount" type="text"  value="<? echo $row['discount']; ?>">
				  <input name="id" type="hidden"  value="<? echo $row['id']; ?>">
                                <input type="submit" name="Submit" value="Назначить скидку">
								<?
								if($row["unreg"] == 1){
									echo "<a href=\"?deleteuser=$row[id]\"><font color=red>Удалить</font></a>";
								}
								?>
                <input type="button" name="edituser" 
				onClick="edit_user(<?  echo $row["id"]; ?>)" value="Редактировать">
				</form>
				-->
              </td>
            </tr> </table>
			<!--<div style="background-color:#F0F0F0; display: none; height: 150px; padding:10px; 
			border: 1px;" 
			id="edituser_<?  echo $row["id"]; ?>">
			  <form name="form_ue_<?  echo $row["id"]; ?>" method="post" action="">
			  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="30">Назначить скидку </td>
                  <td><input name="discount_ue" type="text"  value="<? echo $row['discount']; ?>"></td>
                </tr>
                <tr>
                  <td width="200" height="30">Отметить как дилера </td>
                  <td><input type="checkbox" name="diller_ue" value="1" 
				  <?   if($row["diller"]==1) echo "checked";  ?>		></td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td><input type="submit" name="Submit2" value="Редактировать данные" style="width: 200px;"></td>
                </tr>
				<tr>
                  <td height="30">&nbsp;</td>
                  <td><input type="button" name="button_show_user_zakaz" value="Заказы пользователя" style="width: 200px;"></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
			  <input name="id_ue" type="hidden"  value="<? echo $row['id']; ?>">
			  </form>
			</div>-->
            <? 
		} 
		?>
         
	</td>
  </tr>
</table>
<?  require_once("__footer.php"); ?>
<script>
function edit_user(uid){
	//alert(uid);
	obj=document.getElementById("edituser_"+uid);
	if(obj.style.display=="none"){
		obj.style.display="";
	} else {
		obj.style.display="none";
	}
}

$(document).ready(function(){
	$(".userbasket").click(function(){
		if(this.checked){
			paction = "paction=look_basket&userid="+this.id.replace(/^userbasket_/, "")+"&value=1";
			this.parentNode.parentNode.style.backgroundColor = "#EFD1D1";
		} else {
			paction = "paction=look_basket&userid="+this.id.replace(/^userbasket_/, "")+"&value=0";
			this.parentNode.parentNode.style.backgroundColor = "#FFFFFF";
		}
		//alert(paction);
		//*************************
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(sub_inp.parentNode.parentNode.tagName);
			}
		});
		
	})
})
</script>
</body>
</html>
