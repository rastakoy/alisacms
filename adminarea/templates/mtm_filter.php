<?
$resp = mysql_query("select * from items where id=$pid");
$row = mysql_fetch_assoc($resp);
?>

<?
function show_mtm($parent, $frow){
	$ret = "";
	$next=false;
	$ret .= "<select name=\"folder_filter\" id=\"folder_filter\" class=\"folder_select\" style=\"margin-bottom: 10px;\">";
	$query = " select * from mtm_filter where parent=$parent ";
	$resp = mysql_query($query);
	while($row = mysql_fetch_assoc($resp)){
		$ret .= "<option value=\"$row[id]\"  ";
		if($row["id"] == $frow["mtm"])  { 
			$ret .= "selected"; 
			$next=$row["id"]; 
			$next_row = $row;
		}
		$ret .= ">$row[name]</option>";
	}
	$ret .= "</select>";
	return $ret;
}
//***********************************************************
echo show_mtm("0", $row);
?>