function get_outer_help(){
	paction =  "paction=outerhelp";
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			efobj = document.getElementById("edit_content");
			efobj.style.display = "";
			efobj.innerHTML = html;
			get_outer_help_ajax();
		}
	});
}
//********************************************************
function get_outer_help_ajax(){
	paction =  "paction=outerhelp_json";
	//alert(__ajax_url);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			the_object = eval( "(" + html + ")" );
			$( "#helptitles_cont").empty();
			$( "#helptitles_cont").append(construct_tree(the_object, ""));
			$( "#helptitles" ).css("display", "");
			$( "#helptitles" ).draggable({
				handle: "#helpcontent_title",
				drag: function(event, ui) {	
				}
			});
			//$( "#helpcontent" ).draggable( "option", "grid", [ 50, 20 ] );
			$( "#helpcontent" ).draggable( "option", "containment", "body" );
		}
	});
}
//********************************************************
function construct_tree(tobj, parlnk){
	var mylnk = parlnk;
	var ret = "<ul>";
	for (var key in tobj) {
		ret += "<li>";
		if(tobj[key]["folder"]==0){
			ret += "<a href=\"javascript:show_help('"+mylnk+tobj[key]["href_name"]+"')\">"+tobj[key]["name"]+"</a>";
		} else {
			ret += "<b>"+tobj[key]["name"]+"</b>";
		}
		//alert();
		if(tobj[key]["folder"]==1){
			if(tobj[key]["folder"].length > 0){
				ret += 	construct_tree(tobj[key]["foldercont"], mylnk+tobj[key]["href_name"]+"/");
			}
		}
		ret += "</li>\n";
	}
	ret += "</ul>";
	return ret;
}
//********************************************************
function help_sver_menu_toggle(imgsvobj){
	if(imgsvobj.src == site+"adminarea/images/green/myitemname_popup/help_sver.gif") {
		nsrc = imgsvobj.src.replace(  /\.gif$/, "_neg.gif"  );
		imgsvobj.src = nsrc;
		$("#helptitles_cont").css("display", "none");
	} else {
		nsrc = imgsvobj.src.replace(  /\_neg.gif$/, ".gif"  );
		imgsvobj.src = nsrc;
		$("#helptitles_cont").css("display", "");
	}
	
}
//********************************************************
function show_help(helplnk){
	paction =  "paction=outerhelplnk&helplnk="+helplnk;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			$("#edit_content").css("display", "none");
			$("#help_content").css("display", "");
			$("#help_content").empty();
			$("#help_content").append(html);
		}
	});
}
//********************************************************
function close_help_titles(){
	$("#helptitles").css("display", "none");
	close_help_content();
}
//********************************************************
function close_help_content(){
	//alert("ok");
	$("#edit_content").css("display", "");
	$("#help_content").css("display", "none");
}
//********************************************************





