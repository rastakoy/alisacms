<?
//**************************************************
if ($paction=="mtm_set_mtm") {
	$smkey = $_POST["smkey"];
	$smlevel = $_POST["smlevel"];
	$smid = $_POST["smid"];
	$smlevel_way = $_POST["smlevel_way"];
	//**********************
	$cont = preg_replace( "/\r/", "", $cont );
	//**********************
	$resp = mysql_query("select * from items where id=$smid");
	$row=mysql_fetch_assoc($resp);
	$cont = $row["mtm_cont"];
	$smlevel_way = trim($smlevel_way);
	$mass = explode("-", $smlevel_way);
	$test = $mass;
	unset($test[count($test)-2]);
	echo "smlevel_way=$smlevel_way\n";
	$tvaloo = implode("-", $test);
	$atr = "/\n$tvaloo\n/";
	$cont = preg_replace( $atr, "\n", $cont );
	echo "tvaloo=$tvaloo\n";
	$tval = "";
	foreach($mass as $key=>$val){
		$atr = "/(^|-)$tval$val-\n/";
		$tval = "$tval$val-";
		if($key<count($mass)-2){
			echo "atr=$atr";
			$cont = preg_replace( $atr, "", $cont );
		}
	}
	//$mtm_cont = preg_replace($atr, "\n", $cont);
	$mtm_cont = $cont.$smlevel_way."\n";
	$atr = "/\n\n/";
	$mtm_cont = preg_replace($atr, "\n", $mtm_cont);
	$mtm_cont = preg_replace("/^\n/", "", $mtm_cont);
	echo "mtm_cont=$mtm_cont\n";
	$query = "update items set mtm_cont='$mtm_cont' where id=$smid  ";
	echo $query;
	$resp = mysql_query($query);
	//**********************
	//echo __mtm_generate_level($smlevel_way, $smid);
	//**********************
}
//**************************************************
if ($paction=="mtm_unset_mtm") {
	$smkey = $_POST["smkey"];
	$smlevel = $_POST["smlevel"];
	$smid = $_POST["smid"];
	$smlevel_way = $_POST["smlevel_way"];
	//**********************
	$resp = mysql_query("select * from items where id=$smid");
	$row=mysql_fetch_assoc($resp);
	$cont = $row["mtm_cont"];
	$cmass = explode("\n", $cont);
	$rv = false;
	foreach($cmass as $key=>$val){
		$val = trim($val);
		$atr = "/(^|-)$smlevel_way/";
		if(preg_match($atr, $val)){
			$atr = "";
			$mass = explode("-", $val);
			//print_r($mass);
			for($i=$smlevel; $i<count($mass)-1; $i++){
				$atr = $atr.$mass[$i]."-";
				//echo "$atr\n";
			}
			$atr = "/".$atr."/";
			//echo "atr=$atr\n";
			$val = preg_replace($atr, "", $val);
			//echo "val=$val\n";
			$rv .= $val."\n";
		} else {
			$rv .= $val."\n";
		}
	}
	$atr = "/\r/";
	$rv= preg_replace($atr, "", $rv);
	$atr = "/\n\n\n\n/";
	$rv= preg_replace($atr, "", $rv);
	$atr = "/\n\n\n/";
	$rv= preg_replace($atr, "", $rv);
	$atr = "/\n\n/";
	$rv= preg_replace($atr, "\n", $rv);
	$rv = trim($rv);
	$query = "update items set mtm_cont='$rv' where id=$smid  ";
	echo $query;
	$resp = mysql_query($query);
}
//**************************************************
if ($paction=="mtm_generate_level") {
	$smid = $_POST["smid"];
	$smlevel_way = $_POST["smlevel_way"];
	$smkey = $_POST["smkey"];
	//**********************
	echo __mtm_generate_level($smlevel_way, $smid, $smkey);
}
//**************************************************
if ($paction=="mtm_set_fname") {
	$fname = iconv("UTF-8", "CP1251", $_POST["fname"]);
	$fid = $_POST["fid"];
	$query = "update mtm_filter set name='$fname'  where id=$fid " ;
	$resp = mysql_query($query);
	echo $fname;
}
//**************************************************
if ($paction=="mtm_set_fstyle") {
	$fid = $_POST["fid"];
	$fstyle = $_POST["fstyle"];
	$query = "update mtm_filter set fstyle='$fstyle'  where id=$fid " ;
	$resp = mysql_query($query);
	echo $fstyle;
}
//**************************************************
if ($paction=="mtm_set_fbg") {
	$fid = $_POST["fid"];
	$fbg = $_POST["fbg"];
	$query = "update mtm_filter set fbg='$fbg'  where id=$fid " ;
	$resp = mysql_query($query);
	echo $fbg;
}
//**************************************************
if ($paction=="mtm_set_cont") {
	$cont = iconv("UTF-8", "CP1251", $_POST["cont"]);
	$fid = $_POST["fid"];
	$query = "update mtm_filter set cont='$cont'  where id=$fid " ;
	$resp = mysql_query($query);
	echo $cont;
}
//**************************************************
if ($paction=="mtm_del_level") {
	$fid = $_POST["fid"];
	//**************************************
	$query = "select * from mtm_filter where id=$fid " ;
	echo $query."\n";
	$resp = mysql_query($query);
	$row=mysql_fetch_assoc($resp);
	//**************************************
	$query = "select * from  mtm_filter where parent=$row[parent] && prior >= $row[prior] " ;
	$resp = mysql_query($query);
	while($row=mysql_fetch_assoc($resp)){
		$respo = mysql_query("delete from mtm_filter where id=$row[id] ");
	}
	//**************************************
}
//**************************************************
if ($paction=="mtm_add_level") {
	$fid = $_POST["fid"];
	//**************************************
	$query = "select * from mtm_filter where id=$fid " ;
	//echo $query."\n";
	$resp = mysql_query($query);
	$row=mysql_fetch_assoc($resp);
	//**************************************
	$query = "select * from  mtm_filter where parent=$row[parent] && prior > $row[prior] " ;
	$resp = mysql_query($query);
	if(mysql_num_rows($resp) > 0){
		echo "false";
	} else {
		$query = " INSERT INTO mtm_filter (parent, prior, fbg, cont, name, fstyle) 
		VALUES ( $row[parent], ".($row["prior"]+10)." , '#FFFFFF', 'Элемент №1', 'Название элемента',  'width:180px;')  ";
		//echo $query."\n";
		$resp = mysql_query($query);
		echo "ok";
	}
	//**************************************
}
//**************************************************
?>