//******************************
function show_idc(idc_id){
	//alert(idc_id);
	my_width = $("#div_myitemname_"+idc_id).width();
	$("#idc_"+idc_id).css("display", "");
	$("#idc_"+idc_id).animate({
		width: my_width+10,
		opacity: 1
		}, 300 
	);
}
//******************************
function hide_idc(idc_id){
	$("#idc_"+idc_id).animate({
		width: "0px",
		opacity: 0
		}, 300, "", function (){
			$("#idc_"+idc_id).css("display", "none");
		} 
	);
}
//******************************
function show_items_warning(iw_id){
	//alert("show");
	iw_pos = __images_getAbsolutePos(document.getElementById("imgwarning_"+iw_id));
	$("#items_nodatafield_"+iw_id).css("left", (iw_pos.x-162)+"px");
	$("#items_nodatafield_"+iw_id).css("top", (iw_pos.y-$("#items_nodatafield_"+iw_id).height())+"px");
	$("#items_nodatafield_"+iw_id).fadeIn();
}
//******************************
function hide_items_warning(iw_id){
	$("#items_nodatafield_"+iw_id).fadeOut();
}
//******************************
function show_rests(restsId){
	//alert("show");
	iw_pos = __images_getAbsolutePos(document.getElementById("imgrests_"+restsId));
	$("#items_rests_"+restsId).css("left", (iw_pos.x-162)+"px");
	$("#items_rests_"+restsId).css("top", (iw_pos.y-$("#items_rests_"+restsId).height())+"px");
	$("#items_rests_"+restsId).fadeIn();
}
//******************************
function hide_rests(restsId){
	$("#items_rests_"+restsId).fadeOut();
}
//******************************

//******************************