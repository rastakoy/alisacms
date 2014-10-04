<script>
<!--
<?
echo __farmmed_rekursiya_show_items_for_js_v3(0, $edit_mass, $edit, 0);
?>
function show_tree_item(item_id, parent){
	for(i=0; i<eval("tree_array_"+item_id).length; i++){
		//alert("tree_plus_"+eval("tree_array_"+item_id+"["+i+"]"));
		document.getElementById("tree_item_"+eval("tree_array_"+item_id+"["+i+"]")).style.display = "block";
	}
	document.getElementById("tree_plus_"+item_id).style.display = "none";
	document.getElementById("tree_minus_"+item_id).style.display = "block";
}
function hide_tree_item(item_id, parent){
	for(i=0; i<eval("tree_array_"+item_id).length; i++){
		//alert("tree_plus_"+eval("tree_array_"+item_id+"["+i+"]"));
		document.getElementById("tree_item_"+eval("tree_array_"+item_id+"["+i+"]")).style.display = "none";
	}
	document.getElementById("tree_plus_"+item_id).style.display = "block";
	document.getElementById("tree_minus_"+item_id).style.display = "none";
}
function tree_mouse_over(oElement){
	//document.getElementById("test").innerText = "Мышь на папке";
}
-->
</script>