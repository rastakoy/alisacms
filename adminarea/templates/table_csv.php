<?
//echo "pid=$pid";
$query = "select * from files_csv where id=$pid  ";
$resp = mysql_query($query);
$row = mysql_fetch_assoc($resp);

$mass_csv = $csv_class->parse("../csv/".$row["link"]);

//print_r($mass_csv);
?>
<input type="hidden" style="width:100%" name="textarea_csv_0" id="textarea_csv_0"/>
<input type="hidden" name="cells_csv" id="cells_csv">
<div id="table_csv"></div>
<script>
<!--
var csv_has = 0;
function init_old_csv(){
	//alert("init old csv");
	<?
	if($row["link"]!=""){
		$max_rows = 0;
		$max_cells = 0;
		foreach($mass_csv as $key=>$val){
			echo "mass_csv[".$key."]=new Array();\n";
			foreach($val as $k=>$v){
				$v = preg_replace("/&/", "*", $v);
				echo "mass_csv[".$key."][".$k."]=\"".HTMLSpecialChars(trim(preg_replace('/"/', "''", $v)))."\";\n";
				if($k+1>$max_cells) $max_cells = $k+1;
			}
			if($key+1>$max_rows) $max_rows = $key+1;
			echo "//******\n";
		}
		echo "rows_csv = $max_rows;\n";
		echo "cells_csv = $max_cells;\n";
	}
	?>
	render_table_csv();
}	
//******************
<?
if($row["link"]!=""){
	echo "init_old_csv();\n";
	echo "csv_has = $row[id];\n";
	echo "on_edit_cell_csv();\n";
} else {
	echo  "init_new_csv();\n";
	echo  "on_edit_cell_csv();\n";
}
?>
-->
</script>