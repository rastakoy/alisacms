var my_upload_file = "";
var asd = "test test";
top.myuploadfile = "";
mup_file_upload_timeout = false;
//*****************************************
function __of_mup_start_convert(){
	var check_item_off_val = "";
	var price_coff_val = "0";
	if(document.getElementById("check_item_off").checked)
		check_item_off_val = 1;
	if(document.getElementById("price_coff").checked)
		price_coff_val = $("#price_coff").val();
	paction = "paction=of_mup_start_convert&provider="+$("#folder_item_type").val()+"&check_item_off="+check_item_off_val+"&price_coff="+price_coff_val;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: "__ajax_of_uploadp_maker.php",
		data: paction,
		success: function(html) {
			alert(html);
			//$("#divcontent").empty();
			//$("#divcontent").append(html);
			//$("#item_off_panel").css("display", "");
			//$("#price_coff_panel").css("display", "");
			//$("#price_load_panel").css("display", "");
			//$("#file_panel").css("display", "none");
		}
	});
}
//*****************************************
function __of_mup_get_provider_select(gfs_val){
	if(gfs_val !=0){
		inhtml = '<iframe frameborder="0" scrolling="no" width="150" height="30" src="manage_uploadp_file.php" ></iframe>';
		top.myuploadfile = "";
		__of_mup_test_file_upload();
		$("#file_panel").css("display", "");
		$("#file_panel").empty();
		$("#file_panel").append(inhtml);
		
	} else {
		$("#file_panel").css("display", "none");
		$("#item_off_panel").css("display", "none");
		$("#price_coff_panel").css("display", "none");
		$("#price_load_panel").css("display", "none");
		$("#dollar_panel").css("display", "none");
		clearInterval(of_mup_file_upload);
		top.myuploadfile = "";
	}
}
//*****************************************
function __of_mup_file_upload(upfilename){//mf_name
	//alert(upfilename);
	upfilename = upfilename.replace(/\\/gi , "~~~slah~~~");
	paction = "paction=of_mu_load_file&provider="+$("#folder_item_type").val()+"&fillename="+upfilename;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: "__ajax_of_uploadp_maker.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#divcontent").empty();
			$("#divcontent").append(html);
			$("#item_off_panel").css("display", "");
			$("#price_coff_panel").css("display", "");
			$("#price_load_panel").css("display", "");
			$("#dollar_panel").css("display", "");
			$("#file_panel").css("display", "none");
		}
	});
}
//*****************************************
function __of_mup_test_file_upload(){//mf_name
	if(top.myuploadfile!=""){
		//alert(top.myuploadfile);
		__of_mup_file_upload(top.myuploadfile);
		clearInterval(mup_file_upload);
	} else {
		mup_file_upload = setTimeout("__of_mup_test_file_upload()", 1000);
	}
}
//*****************************************
