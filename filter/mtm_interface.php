<script>activate_filter=false;</script>
<? 
$__page_row = $current;
//$rpar = mysql_query("select * from items where id=$current[parent]");
//$__page_parent = mysql_fetch_assoc($rpar);
$__page_parent = $__page_row["parent"];
$my_filter = __mtm_has_mtm($__page_row["id"]);
if($my_filter && $__page_row["folder"]==1){ ?>
<div id="div_mtmfilter" style="display:block;"><div id="mtmfilter_cont" style="display:block"></div></div>
<script>activate_filter=<?  echo $my_filter; ?>;</script>
<script>filter_parid=<?  echo $__page_row["id"]; ?>;</script>
<script>filter_itemid=<?  echo $__page_row["id"]; ?>;</script>
<script>filter_folder="<?  echo __fp_create_folder_way("items", $__page_row["id"], 1); ?>";</script>
<script>
if(activate_filter){
	//******************************
	ppdata  =  "paction=getfilter&filter_itemid="+filter_itemid;
	ppdata += "&parid="+filter_parid+"&filter_show=1";
	//alert(ppdata);
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: ppdata,
		success: function(html) {
			//alert(html);
			$("#mtmfilter_cont").empty();
			$("#mtmfilter_cont").append(html);
			//ffa_off = false;
			//init_mtm_arrow();
			//$("#filter_arrow").css("display", "none");
		}
	});
}
</script>
<?  } ?>