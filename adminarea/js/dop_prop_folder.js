function show_dop_prop_folder(){
	sdpfo = document.getElementById("folder_dop_prop");
	if(sdpfo.style.display == "none"){
		sdpfo.style.display = "";
	} else {
		sdpfo.style.display = "none"
	}
}
//**********************************************
function active_filter(afobj, afid){
	if(afobj.checked){
		__ajax_mtm_get_filter(afid);
	} else {
		//alert("off");	
	}
}