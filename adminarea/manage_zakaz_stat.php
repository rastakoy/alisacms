<?php
$mr=$_GET["mr"];
$wuser = $_GET["wuser"];
if(!$wuser) $wuser = $_POST["wuser"];
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
require_once("../core/__functions.php");
require_once("../core/__functions_post.php");
require_once("../core/__functions_prices.php");
require_once("../core/__functions_zakaz.php");
//print_r($_POST);
eval(strip_get_vars_eval($_GET));
eval(strip_post_vars_eval($_POST));
dbgo();

//print_r($_POST);
$zak_status = $_POST["zak_status"];
if(!$zak_status && $zakid){
	$resp = mysql_query("update zakaz set zstatus=0 where id=$zakid");
}

if($zak_status){
	$resp = mysql_query("update zakaz set zstatus=$zak_status where id=$zakid");
}

if($_POST["mr"]==0) $mr==0;
//if($dd1==$dd2) 
if(!$dd1) $dd1=1;
if(!$mm1) $mm1=4;
if(!$yy1) $yy1=2012;

if(!$dd2) $dd2 = 1;
if(!$mm2) $mm2 = 1;
if(!$yy2) $yy2 = 2014;

$__page = "manage_models";
$__page_title = "Статистика добавлений";
$__delete_link = "manage_addstat.php?delete=$delete&access=true";
$__cancel_link = "manage_addstat.php";
?>
<html>
<? require_once("__head.php"); ?>
<? //require_once("__js_select_open_window_models.php"); ?>
<? //require_once("__js_show_block.php"); ?>
<?
//PROGRAM CODE HERE
//****************
if($delete && $access){
	$resp = mysql_query("select * from news where id=$delete");
	$row = mysql_fetch_assoc($resp);
	if(file_exists("../nimages/".$row['link']) && $row['link']!="")
		unlink("../nimages/".$row['link']);
	$resp = mysql_query("delete from news where id=$delete");
}
//****************
if($edit){
	$resp = mysql_query("select * from news where id=$edit");
	$row = mysql_fetch_assoc($resp);
	$edit_mass = $row;
}
//****************
if($news_data && $news_text) //Если отправлена информация о обновлении
{
$link = "";
if (is_uploaded_file($userfile)) {
	if ($userfile_size>500000) { echo "Слишком большой файл!<br>\n"; exit; }
	//*********************************************
	//Определяем тип изображения
	if($userfile_type=="image/jpeg" || $userfile_type=="image/pjpeg" || $userfile_type=="image/gif" || $userfile_type=="image/png" || $userfile_type=="image/x-png")  
	{
		if (file_exists("../nimages/".$userfile_name) || file_exists("../nimages/".eregi_replace(".gif", ".jpg", $userfile_name)) || file_exists("../nimages/".eregi_replace(".png", ".jpg", $userfile_name))) {
			echo "Файл с таким именем существует, задайте другое имя для файла";
			exit();
			//unlink("../nimages/".$userfile_name);
		}
    	$res = copy($userfile, "../nimages/".$userfile_name);
    	if (!$res){echo "Ошибка загрузки!<br>\n"; exit;}
    }
	else{
		echo "Неверный формат файла!<br>\n"; exit;
    }
	//$resp = mysql_query("select detaliz from kobjects where id=$did");
	//$row = mysql_fetch_assoc($resp);
	//echo $userfile_name."<br/>\n";
	if($row['detaliz']!="" && $row['detaliz']!=$userfile_name){
		unlink("../nimages/$row[detaliz]");
		//echo "unlink(../maps/$row[detaliz])<br/>\n";
	}
	//echo "type = ".$userfile_type."<br/>\n";
	if($userfile_type=="image/jpeg" || $userfile_type=="image/pjpeg"){
		$link = $userfile_name;
	}
	if($userfile_type=="image/gif"){
		$img = imagecreatefromgif("../nimages/$userfile_name");
		imagejpeg($img, "../nimages/".eregi_replace("gif", "jpg", $userfile_name), 75);
		unlink("../nimages/$userfile_name");
		$link = eregi_replace("gif", "jpg", $userfile_name);
	}
	if($userfile_type=="image/png" || $userfile_type=="image/x-png"){
		//echo "START CONVERT<br/>\n";
		$img = imagecreatefrompng("../nimages/$userfile_name");
		imagejpeg($img, "../nimages/".eregi_replace("png", "jpg", $userfile_name), 75);
		unlink("../nimages/$userfile_name");
		$link = eregi_replace("png", "jpg", $userfile_name);
	}
}
	//$news_text = eregi_replace("\r\n", "\n<br>", $news_text);
	$query = "insert into news (id, datas, cont, link ) VALUES (NULL, '$news_data', '$news_text', '$link')";
	
if($edited)
{
	$i_m = "";
	$i_i = "";
	if( $link != "" ) { $i_m   = " link =  '$link'   , "  ;}
	
	if($del1){  $i_m   = " link=  ''   , "  ;
	//Delete code here...
	$respt = mysql_query("select link from news where id = $edited");
	$rowt = mysql_fetch_assoc($respt);
	if(file_exists("../nimages/$rowt[link]") && $rowt['link']!=""){
		unlink("../nimages/$rowt[link]");
		}
	}

	$query = "update news SET $i_m  $i_i  datas='$news_data', cont='$news_text' where id = $edited";
}	
	
	$resp = mysql_query($query);
	
}//Конец условия
//*******************************************************
//****************
?>



<body>
<table border="0" cellpadding="0" cellspacing="0" class="adminarea">
  <tr>
    <td class="adminarearight" valign="top">
		<div class="admintitle"><?  echo $__page_title; ?></div>
		<?
		{
		?>
		<form action="manage_news.php?parent=<? echo $parent; ?><? if($edit) echo "&edited=$edit"; ?>" method="post" enctype="multipart/form-data" name="form1">
		</form>
	  <div class="adminitems">
		  <div class="itemstitle">Список заказов (в порядке от последнего к первому до
		  <font color="#FF0000">24.01.2009</font>):</div>
		  <div ><form method="post">
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="160" style="padding-right:10px;"><div align="right">Отсортировать по дате <span style="font-weight: bold"><br>
                  от</span> </div></td>
                  <td width="200" height="30">
				  
				  <select name="dd1" id="dd1">
				  <?
				  //$date1 = mktime (0 ,0 ,0 , $mm1, $dd1, $yy1);
				  
				  ?>
				  <?  for($i=1; $i<32; $i++){
				  	echo "<option value=\"$i\" ";
					if($dd1) { if($i==$dd1) echo "selected "; }
					else { if($i==03) echo "selected "; }
					echo ">$i</option>";
				  } ?>
                  </select>
                    <select name="mm1" id="mm1">
					<?  for($i=1; $i<13; $i++){
				  	echo "<option value=\"$i\" ";
					if($dd1) { if($i==$mm1) echo "selected "; }
					else { if($i==5) echo "selected "; }
					echo ">";
					if(strlen($i)<2) echo "0";
					echo "$i</option>";
				  } ?>
                    </select>
                    <select name="yy1" id="yy1">
					<?  for($i=2009; $i<2020; $i++){
				  	echo "<option value=\"$i\" ";
					if($dd1) { if($i==$yy1) echo "selected "; }
					else { if($i==2009) echo "selected "; }
					echo ">$i</option>";
				  } ?>
                  </select></td>
                  <td><select name="wuser" id="wuser"><option value="" style="line-height: 40px;">--Фильтр пользователей--</option><?  
							$wresp = mysql_query("select * from users order by fio");
							while($wrow = mysql_fetch_assoc($wresp)) {
								$logg = $wrow["login"];
								if(!$logg) $logg = "Не зарегистрирован";
								echo "<option value=\"$wrow[id]\" ";
								if($wrow["id"] == $wuser) 
									echo "selected "; 
								echo ">$wrow[fio] - ($logg)</option>";
							} 
				  ?></select></td>
                  <td><?
				  $cur_dd = date("d");
				  $cur_mm = date("m");
				  $cur_yy = date("Y");
				  ?>
                    <!--<select name="mr" id="mr">
					<option value="0">Все лица</option>
                      <?   $mresp = mysql_query("select * from managers");
					  while($mrow = mysql_fetch_assoc($mresp)){
					  echo "<option value=\"$mrow[id]\" ";
					  if($mrow["id"]==$mr) echo "selected ";
					  echo ">$mrow[name]</option>";
				  } ?>
                    </select>--></td>
                </tr>
                <tr>
                  <td style="padding-right:10px;"><div align="right"><span style="font-weight: bold">до</span></div></td>
                  <td height="30"><select name="dd2" id="dd2">
                    <?  for($i=1; $i<32; $i++){
				  	echo "<option value=\"$i\" ";
					if($dd1) { if($i==$dd2) echo "selected "; }
					else { if($i==$cur_dd) echo "selected "; }
					echo ">$i</option>";
				  } ?>
                  </select>
                    <select name="mm2" id="select2">
                      <?  for($i=1; $i<13; $i++){
				  	echo "<option value=\"$i\" ";
					if($dd1) { if($i==$mm2) echo "selected "; }
					else { if($i==$cur_mm) echo "selected "; }
					echo ">";
					if(strlen($i)<2) echo "0";
					echo "$i</option>";
				  } ?>
                    </select>
                    <select name="yy2" id="select3">
                      <?  for($i=2009; $i<2020; $i++){
				  	echo "<option value=\"$i\" ";
					if($dd1) { if($i==$yy2) echo "selected "; }
					else { if($i==$cur_yy) echo "selected "; }
					echo ">$i</option>";
				  } ?>
                    </select></td>
                  <td><input type="submit" name="Submit2" value="Отсортировать"></td>
                  <td>&nbsp;</td>
                </tr>
            </table>
		  </form></div>
<script>
function show_deta(nid){
oB = document.getElementById("atr_"+nid);
//alert(nid);
if(oB.style.display=="none")
	oB.style.display="";
else
	oB.style.display="none";
}
</script>
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
            <?
	 
	 if($wuser){
	 	$wuserws = " &&  cont like('user=$wuser\\n%') ";
	 }
	 
	 $dd2+=1;
	  if($mr) {
	  	$query = "select * from zakaz  order by id desc";
		if($dd1){
			$date1 = mktime (0 ,0 ,0 , $mm1, $dd1, $yy1);
			$date2 = mktime (0 ,0 ,0 , $mm2, $dd2, $yy2);
			$query = "select * from zakaz  
			adddate>=$date1 and adddate<=$date2 $wuserws order by id desc";
		}
	  } else {
	  	$query = "select * from zakaz  order by id desc";
		if($dd1){
			$date1 = mktime (0 ,0 ,0 , $mm1, $dd1, $yy1);
			$date2 = mktime (0 ,0 ,0 , $mm2, $dd2, $yy2);
			$query = "select * from zakaz where 
			adddate>=$date1 and adddate<=$date2 $wuserws order by id desc";
		}
	  }
	  //echo "query=\n\n".$query;
	  $query = "select * from zakaz where remember=1 order by id desc";
	  $resp = mysql_query($query);
	  $count=mysql_num_rows($resp);
	  while($row=mysql_fetch_assoc($resp)){
 	  if($row["adddate"]){
	  ?>
            <tr bgcolor="#FFFFFF">
              <td width="70" height="47" bgcolor="#FFFFFF"><div align="center" style="font-weight: bold"><?  echo $count;  $count--;?></div></td>
              <td width="110">Заказ <strong>№<?  echo $row["id"]; ?></strong></td>
              <td width="250">
<? 
$name_query = "select * from users where id=$row[zuser]";
$name_resp = mysql_query($name_query);
$name_row = mysql_fetch_assoc($name_resp);
echo $name_row["fio"];
?></td>
              <td width="100" bgcolor="#FFFFFF"><a href="javascript:show_deta(<?  echo $row["id"]; ?>)">Подробнее</a></td>
              <td width="100" bgcolor="#FFFFFF"><? echo strftime("%d.%m.%Y %H:%M:%S", $row["adddate"]); ?></td>
			  <td bgcolor="#FFFFFF"><form name="form_<?  echo $row["id"]; ?>" method="post" action="">
			    <select name="zak_status" id="zak_status">
			      <option value="0">В обработке</option>
			      <option value="1" <?  if($row["zstatus"]==1)  echo "  selected "; ?> >Принят</option>
			      <option value="2" <?  if($row["zstatus"]==2)  echo "  selected "; ?> >Отменен</option>
			      <option value="3" <?  if($row["zstatus"]==3)  echo "  selected "; ?> >Выполнен</option>
		        </select>
			    <input name="zakid" type="hidden" id="zakid" value="<?  echo $row["id"]; ?>">
				<input type="hidden" name="wuser" value="<?  echo $wuser; ?>">
                              <input type="submit" name="Submit" value="Установить статус">
			  </form>
		      </td>
            </tr>
			<tr bgcolor="#FFFFFF" style="display:none;" id="atr_<?  echo $row["id"]; ?>"> 
              <td height="47" colspan="6" bgcolor="#F2F2F2"><?   echo __fz_get_zakaz($row["zaknum"], $row["zuser"], $row["id"]);  //echo __fpost_zakaz_html($row["id"]); ?></td>
          </tr>
            <? } 
		  }
		   ?>
          </table>
	  </div>
		<?
		}
		?>
	</td>
  </tr>
</table>
<?  require_once("__footer.php"); ?>
<?  $resp = mysql_query("select * from zakaz order by adddate desc limit 0,1");
$row=mysql_fetch_assoc($resp); ?>
<script>top.nztime=<?  echo $row["adddate"]; ?></script>
</body>
</html>