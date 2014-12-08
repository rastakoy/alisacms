<!--<form name="itemformname" method="post" action="">-->
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
      <td colspan="2" class="td_itemedit_bbgtop" 
	  style="height:50px; font-size: 16px;"><strong><? echo $row["name"]; ?> (ред.)</strong></td>
    </tr>
<!------------------------------------------------------------>
<?
$resp_par2 = mysql_query("select * from items where id=$row[parent]");
$row_par2 = mysql_fetch_assoc($resp_par2);
$parent_mass = $row_par2;

//print_r($parent_mass);

if($parent_mass["cfg_file"]!=""){
	$cfg_mass = __lc_find_data_from_loadconfig($parent_mass["cfg_file"], "../config/".$parent_mass["cfg_file"].".cfg", 1);
	$cfg_mass = explode(",", $cfg_mass);
	foreach($cfg_mass as $key=>$val){
		$mass = __lc_find_data_from_loadconfig("$val", "../config/".$parent_mass["cfg_file"].".cfg", 1);  
		$mass = explode("=", $mass);
		// print_r($mass);
		$mass[2]=trim($mass[2]);
		if($mass[2]=="select"){
			//echo "<br/>edit_mass=".$edit_mass["$mass[3]"];
			$data = __lc_get_select_constructor($mass, $row["$mass[3]"]);
			echo $data;
		}
		if($mass[2]=="list"){
			//echo "<br/>edit_mass=".$edit_mass["$mass[3]"];
			$data = __lc_get_list_constructor($mass, $row["$mass[3]"]);
			//$data = __lc_get_list_array($mass, $row["$mass[3]"]);
			//echo $data;
		}
	}
}

//Multiitem
$MI = get_item_multiitem($pid, "true");
if($MI) $MI = explode(",", $MI);
//print_r($MI);

$query_types = "select * from itemstypes where id=$item_type";
//echo $query_types;
$resptypes = mysql_query($query_types);
$row_ty = mysql_fetch_assoc($resptypes);
//echo "<pre>"; print_r($row_ty); echo "</pre>";
$mass = explode("\n", $row_ty["pairs"]);
//echo "form start";
foreach($mass as $key=>$val){
	if($val!=""){
		$tmass = explode("===", $val);
		//echo "<pre>"; print_r($tmass); echo "</pre>";
		if($tmass[0]=="inputtext"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="inputtext" && $tmass[1]==$miv[1])
						echo __ff_create_inputtext( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
				}
			} else {
				echo __ff_create_inputtext( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
			}
		}
		if($tmass[0]=="number"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="number" && $tmass[1]==$miv[1])
						echo __ff_create_number( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
				}
			} else {
				echo __ff_create_number( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
			}
		}
		if($tmass[0]=="double"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="double" && $tmass[1]==$miv[1])
						echo __ff_create_number( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
				}
			} else {
				echo __ff_create_number( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
			}
		}
		if($tmass[0]=="pricedigit"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="pricedigit")
						echo __ff_create_pricedigit( $row );
				}
			} else {
				echo __ff_create_pricedigit( $row );
			}
		}
		//if($tmass[0]=="multiprice"){
		//	echo __ff_create_multiprice( $row );
		//}
		if($tmass[0]=="parent" && !$MI){
			echo __ff_create_selectparents( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		if($tmass[0]=="datepicker"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="datepicker")
						echo __ff_create_datepicker( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
				}
			} else {
				echo __ff_create_datepicker( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
			}
		}
		if($tmass[0]=="hidden"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="hidden" && $miv[1]==$tmass[1])
						echo __ff_create_datepicker( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
				}
			} else {
				echo __ff_create_hidden( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
			}
		}
		if($tmass[0]=="images"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="images")
						echo __ff_create_images( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
				}
			} else {
				echo __ff_create_images( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
			}
		}
		if($tmass[0]=="textarea"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="textarea")
						echo __ff_create_textarea( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
				}
			} else {
				echo __ff_create_textarea( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4] );
			}
		}
		//if($tmass[0]=="selectgaltype"){
		//	echo __ff_create_selectgaltype( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		//}
		if($tmass[0]=="saveblock"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="saveblock")
						echo __ff_create_saveblock( $row );
				}
			} else {
				echo __ff_create_saveblock( $row );
			}
		}
		if($tmass[0]=="usercomments" && !$MI){
			echo __ff_create_ucblock( $row );
		}
		if($tmass[0]=="inputcheckbox"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="inputcheckbox" && $miv[1]==$tmass[1])
						echo __ff_create_inputcheckbox( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
				}
			} else {
				echo __ff_create_inputcheckbox( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
			}
		}
		if($tmass[0]=="selectrectofolder" && !$MI){
			echo __ff_create_rec_to_folder( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		if($tmass[0]=="selectoutmark"){
			echo __ff_create_outmark( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		if($tmass[0]=="selectassocfile"){
			echo __ff_create_selectassocfile( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		if($tmass[0]=="artikul"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="artikul")
						echo __ff_create_artikul( $row, $tmass[1] );
				}
			} else {
				echo __ff_create_artikul( $row, $tmass[1] );
			}
		}
		if($tmass[0]=="selectmanytomany"){
			//echo __ff_create_selectmanytomany( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		if($tmass[0]=="selectfromitems"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="selectfromitems" && $miv[1]==$tmass[1])
						echo __ff_create_selectfromitems( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
				}
			} else {
				echo __ff_create_selectfromitems( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
			}
		}
		if($tmass[0]=="selectfromitems_many"){
			//print_r($row);
			echo __ff_create_selectfromitems_many( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		if($tmass[0]=="grabber" && !$MI){
			echo __ff_create_grabber( $row );
		}
		if($tmass[0]=="color"){
			echo __ff_create_color( $row );
		}
		if($tmass[0]=="coder"){
			if($MI){
				foreach($MI as $mik=>$miv){
					$miv = explode("===", $miv);
					if($miv[0]=="coder")
						echo __ff_create_coder( $row, $tmass[1] );
				}
			} else {
				echo __ff_create_coder( $row, $tmass[1] );
			}
		}
		if($tmass[0]=="semp" && !$MI){
			echo __ff_create_semp( $row, $tmass[1], $tmass[2], $tmass[3], $tmass[4], $tmass[5] );
		}
		//print_r($tmass); echo "<br/>";
	}
}

$my_filter = __mtm_has_mtm($row["id"]);
$my_filter = false;
if($my_filter){
	echo "\n<tr><td colspan=\"2\" align=\"left\" style=\"height:60px; line-height:28px;\">";
	//**************************************************
	$query_filter = "select * from items where id=$my_filter   ";
	//echo $query_filter;
	$resp_filt = mysql_query($query_filter);
	$row_filt = mysql_fetch_assoc($resp_filt);
	//print_r($row_filt);
	
	$fresp_nn = mysql_query("select * from mtm_filter where id=$row_filt[mtm] ");
	$frow_nn = mysql_fetch_assoc($fresp_nn);
	
	$fresp = mysql_query("select * from mtm_filter where parent=$row_filt[mtm] order by prior asc limit 0,1  ");
	$frow = mysql_fetch_assoc($fresp);
	$mass = explode("\n", $frow["cont"]);
	
	//$mtm_mass = $row["mtm_cont"];
	$mtm_temp = explode("\n", $row["mtm_cont"]);
	foreach($mtm_temp as $key=>$val){
		$tmp = explode("->", $val);
		$tmp[0] = preg_replace(  "/:/", "", trim($tmp[0])  );
		$tmp[1] = explode(",", $tmp[1]);
		foreach($tmp[1] as $k=>$v){
			//echo "v=$v<br/>";
			$v = explode("-", $v);
			$tmp[1][$k] = $v[1];
		}
		//print_r($tmp);
		$mtm_mass[$tmp[0]] = $tmp[1];
	}
	
	//echo $row["mtm_cont"];
	//print_r($mtm_mass);
	
	echo "<b>Настройка фильтра «$frow_nn[name]»:</b><br/>";
	foreach($mass as $key=>$val){
		//echo "::$val--".$mtm_mass[$val]."::";
		echo "<div id=\"dmtm_0_$key\" class=\"dmtm_div_1\"><span id=\"mtm_0_$key\" class=\"mtm_span_1\">
		<input id=\"fcb_0_$key\" type=\"checkbox\" style=\"float:;\" onClick=\"set_mtm($key, -1, $row[id], this)\" ";
		if(count($mtm_mass[$key]) > 0)  echo " checked ";
		echo "  /> $val </span>
			<div  id=\"dmtm_1_$key\" class=\"dmtm_div_2\" style=\"display:none;\">";
			//********************
			$fresp = mysql_query("select * from mtm_filter where parent=$row_filt[mtm] order by prior asc limit 1,1  ");
			$frow = mysql_fetch_assoc($fresp);
			$mass2 = explode("\n", $frow["cont"]);
			//print_r($mass2);
			foreach($mass2 as $key2=>$val2){
				//$val2 = explode("-", $val2);
				//$val2 = $val2[1];
				echo "<input type=\"checkbox\" style=\"float:;\"   onClick=\"set_mtm($key, $key2, $row[id], this)\"  ";
				if(count($mtm_mass[$key]) > 0) {
					foreach($mtm_mass[$key] as $k=>$v)  
						if($v==$key2 && $v!="") echo " checked ";
				}
				echo "  /> $val2 <br/>";
			}
			//********************
		echo"</div>
		</div>";
	}
	//print_r($frow);
	
	
	//$resp = mysql_query("select * from  ");
	echo "";
	echo "";
	//**************************************************
	echo "</td></tr>\n";
}			

?>
<!------------------------------------------------------------>
  </table>
  
<? if($my_filter) { ?>
<script>
//********
init_mtm();
</script>
<?  } ?>

<!--</form>-->


<?  require("__context_menu.php"); ?>