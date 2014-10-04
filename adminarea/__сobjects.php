<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
require_once("../__config.php");
dbgo();
$e = false;
if($edit){
	$resp = mysql_query("select * from сobjects where id=$edit");
	$row=mysql_fetch_assoc($resp);
	$e[0] = $row['name'];
	$e[1] = $row['cont'];
}
$image1 = "";
//$image2 = "";
?>
<html>
<head>
<title>Управление объектами жилой недвижимости</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="../style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?php
if($delete && $access){
	$resp = mysql_query("select pic from сobjects where id=$delete");
	$row = mysql_fetch_assoc($resp);
	unlink("../сobjects/".$row["pic"]);
	$resp = mysql_query("delete from сobjects where id=$delete");
}

if($delete && !$access){
	?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><font color="#E4E4E4">Вы действительно желаете удалить объект жилой недвижимости <strong> 
      <? 
$resp = mysql_query("select * from сobjects where id = $delete");
$row = mysql_fetch_assoc($resp);
?>
      <img src="../imgres.php?type=сobjects&resize=60&link=<? echo $row['pic']; ?>" width="60" height="45"> 
      </strong>?</font></td>
  </tr>
  <tr>
    <td><input type="submit" name="Submit2" value="Удалить"  onClick="window.open('__сobjects.php?delete=<? echo $delete; ?>&access=true', '_self')">
      <input type="submit" name="Submit3" value="Отменить" onClick="window.open('__сobjects.php', '_self')"> </td>
  </tr>
</table>
<?
	echo "</body></html>";
	exit();
}


if($name) //Если отправлена информация о обновлении
{
//-----------------Загрузка рисунка-----------------------
if (is_uploaded_file($userfile)) {
// uploading file to the server dir
    if ($userfile_size>$max_new_file_size) { echo "Слишком большой файл!<br>\n"; exit; }
    //echo $userfile_type."<br>\n";
	//*********************************************
	//Определяем тип изображения
	if($userfile_type=="image/jpeg" || $userfile_type=="image/pjpeg")  
	{
		if (file_exists("../сobjects/".$userfile_name)) {
			echo "Задайте другое имя, так как файл с таким именем уже существует";
			exit();
			//unlink("../load_images/".$userfile_name);
		}
    	$res = copy($userfile, "../сobjects/".$userfile_name);
    	if (!$res){echo "Ошибка загрузки!<br>\n"; exit;}
    	}
	else{
		echo "Неверный формат файла!<br>\n"; exit;
    	}
// reading file into variable
//$f=fopen("temp/".$userfile_name, "rb");
//$preview=fread($f, filesize("temp/".$userfile_name));
//fclose($f);
//$preview=addslashes($preview);
//$image1 = $preview;
$image1 = $userfile_name;

//unlink ("temp/".$userfile_name);
}
	if(!$show_on_map) $show_on_map = "0";
	//$news_text = eregi_replace("\r\n", "\n<br>", $news_text);
	$query = "insert into сobjects (id, name, pic, cont, show_on_map) VALUES (NULL, '$name' , '$image1', '$cont', $show_on_map)";
	
if($edited)
{
	$i_m = "";
	$i_i = "";
	if( $image1 != "" ) { $i_m   = " pic =  '$image1'   , "  ;}
	//if( $image2 != "" ) {  $i_i   = " pic2 =  '$image2'   , "  ;}
	
	if($del1){  $i_m   = " pic=  ''   , "  ;
	//Delete code here...
	$respt = mysql_query("select pic from сobjects where id = $edited");
	$rowt = mysql_fetch_assoc($respt);
	if(file_exists("../сobjects/$rowt[pic]") && $rowt['pic']!=""){
		unlink("../сobjects/$rowt[pic]");
		}
	}
	$query = "update сobjects SET $i_m  $i_i  name='$name', cont='$cont', show_on_map=$show_on_map where id = $edited";
}	
	$resp = mysql_query($query);
}//Конец условия
//*******************************************************
?>
<form action="__сobjects.php<? if($edit) echo "?edited=$edit"; ?>" method="post" enctype="multipart/form-data" name="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr> 
      <td height="30" class="bu"><font color="#E4E4E4"><strong>Управление объектами жилой недвижимости </strong></font> <input name="new_device" type="hidden" id="new_device" value="true"></td>
    </tr>
    <tr> 
      <td><font color="#E4E4E4"><strong>
	  <?
	  if($edit)
	  	echo "Редактировать";
	  else
	  	echo "Добавить";
	  ?>
	   объект</strong></font></td>
    </tr>
    <tr> 
      <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="120" height="100" bgcolor="#9FBEDD"><div align="center"><strong>Изображение</strong></div></td>
                <td width="250" height="50" bgcolor="#FFFFFF"><div align="left">
                    
					<?
					if($row['pic']==""){
					?>
					<input name="userfile" type="file" id="userfile">
                    <?
								 } if($edit &&  $row['pic']!=""){
								  ?>
<img src="../imgres.php?type=сobjects&resize=60&link=<? echo $row['pic']; ?>"  
width="60" height="45" class="imggal"><br>
                    Удалить изображение
<input type="checkbox" name="del1" value="true">
<? }  ?>
</div></td>
                <td bgcolor="#FFFFFF"><strong>Пример введения информации :<br>
                  </strong> Выберите файл изображения в формате <strong>jpg<br>
                  </strong>c пропорцией размера <strong> 4:3</strong> (800х600, 
                  например)</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="120" height="100" bgcolor="#9FBEDD"><div align="center"><strong>Название </strong><br>
                (адрес объекта)</div></td>
                <td width="250" height="50" bgcolor="#FFFFFF"><div align="left">
                  <input name="name" type="text" id="name" value="<? if($edit) echo $e[0]; ?>">
                </div></td>
                <td bgcolor="#FFFFFF"><strong>Пример введения информации :<br>
                </strong> Введите текст c адресом объекта. </td>
              </tr>
            </table></td>
          </tr>
          <tr> 
            <td><table width="100%" border="0" cellspacing="0" cellpadding="6">
                <tr> 
                  <td width="120" height="100" bgcolor="#9FBEDD"><div align="center"><strong>Комментарий </strong></div></td>
                  <td width="250" height="50" bgcolor="#FFFFFF"><div align="left">
                    <textarea name="cont" cols="25" rows="5" id="cont"><? if($edit) echo $e[1]; ?></textarea>
                  </div></td>
                  <td bgcolor="#FFFFFF"><strong>Пример введения информации :<br>
                    </strong> Введите текст комментария. </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td width="120" height="100" bgcolor="#9FBEDD"><div align="center"><strong>Отображать объект  на карте  </strong></div></td>
                <td width="250" height="50" bgcolor="#FFFFFF"><div align="left"><span class="cont">
                  <input name="show_on_map" type="checkbox" id="show_on_map" value="1" <? if($row['show_on_map']==1) echo "checked"; ?>>
                </span></div></td>
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
    </tr>
	    <tr> 
      <td height="35"> <div align="center"> 
          <input type="submit" name="Submit" value="Отправить данные">
        </div></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Список доступных объектов жилой недвижимости:</td>
    </tr>
    <tr> 
      <td><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
        <?
	  $resp = mysql_query("select * from сobjects order by id desc");
	  while($row=mysql_fetch_assoc($resp)){
 	  ?>
        <tr bgcolor="#FFFFFF">
          <td width="70" height="47" bgcolor="#FFFFFF"><div align="center"> <img src="../imgres.php?type=сobjects&resize=60&link=<? echo $row['pic']; ?>" width="60" height="45" class="imggal"> </div></td>
          <td width="180" bgcolor="#FFFFFF" class="cont"><? echo $row['name']; ?></td>
          <td width="90" bgcolor="#9FBEDD" class="cont"><a href="<? echo "?edit=$row[id]"; ?>"><strong><font color="#376A9D">Управление</font></strong></a></td>
          <td width="110" bgcolor="#9FBEDD" class="cont"><a href="<? echo "__mapa.php?object=$row[id]"; ?>"><strong><font color="#376A9D">Расположение</font></strong></a></td>
          <td width="110" bgcolor="#9FBEDD" class="cont"><a href="<? echo "?edit=$row[id]"; ?>"><strong><font color="#376A9D">Редактировать</font></strong></a></td>
          <td bgcolor="#9FBEDD" class="cont"><a href="<? echo "?delete=$row[id]"; ?>"><strong><font color="#FF0000">Удалить</font></strong></a></td>
        </tr>
        <? } 
		  
		   ?>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>