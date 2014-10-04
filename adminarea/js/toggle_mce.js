function fc_togtiny(){
	if(tiny_init){
		tinyMCE.execCommand('mceToggleEditor',false,'folder_cont');
		fcont = tinyMCE.get('folder_cont').getContent();
		tinyMCE.execCommand('mceRemoveControl',true,'folder_cont');
		tiny_init = false;
		$("#folder_cont_leg").empty();
		$("#folder_cont_leg").append("<b>ќписание</b> Ч <a href=\"javascript:fc_togtiny()\">¬ключить редактор HTML</a>");
		document.getElementById("folder_cont").value = fcont;
	} else {
		$("#folder_cont_fl").css("background-color", "#FFFFFF");
		tinymce_init();
		tiny_init = true;
		$("#folder_cont_leg").empty();
		$("#folder_cont_leg").append("<b>ќписание</b> Ч <a href=\"javascript:fc_togtiny()\">ќтключить редактор HTML</a>");
	}
}