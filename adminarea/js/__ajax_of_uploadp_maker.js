//var __ajax_url = "__ajax_of_form_maker.php";
var delete_field = -1;
//******************************
function __of_up_save_sfield(obj){
	sobj = obj.parentNode.parentNode;
	var foo = $(".ui-state-default-2");
	for(i=0; i<foo.length; i++){
		sfoo = foo[i];
		if(sfoo.id == sobj.id){
			paction = "paction=of_up_save_sfield&sfname="+obj.value+"&typeid="+$("#folder_item_type").val()+"&index="+i;
			//alert(paction);
			$.ajax({
				type: "POST",
				url: "__ajax_of_uploadp_maker.php",
				data: paction,
				success: function(html) {
					//alert(html);
					__of_up_get_template($("#folder_item_type").val());
					cur_tid = tid;
				}
			});
		}
	}
}
//******************************
function __of_up_delete_field(obj){
	sobj = obj.parentNode.parentNode;
	var foo = $(".ui-state-default-2");
	for(i=0; i<foo.length; i++){
		sfoo = foo[i];
		if(sfoo.id == sobj.id){
			paction = "paction=of_up_delete_field&typeid="+$("#folder_item_type").val()+"&index="+i;
			//alert(paction);
			$.ajax({
				type: "POST",
				url: "__ajax_of_uploadp_maker.php",
				data: paction,
				success: function(html) {
					//alert(html);
					__of_up_get_template($("#folder_item_type").val());
					cur_tid = tid;
				}
			});
		}
	}
}
//******************************
function __of_up_add_field(){
	if($("#folder_item_type").val()!=0){
		$.ajax({
			type: "POST",
			url: "__ajax_of_uploadp_maker.php",
			data: "paction=of_up_add_field&tid="+$("#folder_item_type").val(),
			success: function(html) {
				//alert(html);
				$("#tmp_content").css("display", "");
				$("#code_content").css("display", "none");
				$("#code_content_ta").val("");
				__of_up_get_template($("#folder_item_type").val());
			}
		});
	}
}
//******************************
function __of_up_add_code(obj){
	//alert(obj);
	sobj = obj.parentNode.parentNode;
	var foo = $(".ui-state-default-2");
	for(i=0; i<foo.length; i++){
		sfoo = foo[i];
		if(sfoo.id == sobj.id){
			paction = "paction=of_up_add_code&typeid="+$("#folder_item_type").val()+"&index="+i;
			//alert(paction);
			$.ajax({
				type: "POST",
				url: "__ajax_of_uploadp_maker.php",
				data: paction,
				success: function(html) {
					__of_up_get_template($("#folder_item_type").val());
					cur_tid = tid;
				}
			});
		}
	}
}
//******************************
var cur_tid = 0;
function __of_up_get_code(tid){
	$.ajax({
		type: "POST",
		url: "__ajax_of_uploadp_maker.php",
		data: "paction=of_up_get_str_to_code&tid="+tid,
		success: function(html) {
			//alert(html);
			$("#tmp_content").css("display", "none");
			$("#code_content").css("display", "");
			$("#code_content_ta").val(html);
			cur_tid = tid;
		}
	});
}
//******************************
function cancel_code(){
	$("#tmp_content").css("display", "");
	$("#code_content").css("display", "none");
}
//******************************
function save_code(){
	var codeval = document.getElementById("code_content_ta").value;
	codeval = codeval.replace(/&/gi , "~~~aspirand~~~");
	codeval = codeval.replace(/\+/gi , "~~~plus~~~");
	//alert(codeval);
	$.ajax({
		type: "POST",
		url: "__ajax_of_uploadp_maker.php",
		data: "paction=of_up_save_code&tid="+cur_tid+"&ofupcode="+codeval,
		success: function(html) {
			//alert(html);
			$("#tmp_content").css("display", "");
			$("#code_content").css("display", "none");
			cur_tid = 0;
		}
	});
}
//******************************
function __of_up_get_template(tid){
	$.ajax({
		type: "POST",
		url: "__ajax_of_uploadp_maker.php",
		data: "paction=of_up_get_template&tid="+tid,
		success: function(html) {
			//alert(html);
			$("#tmp_content").empty();
			$("#tmp_content").append(html);
			$( "#myitems_sortable" ).sortable();
			$( "#myitems_sortable" ).disableSelection();
		}
	});
}
//******************************
function create_code(){
	//alert("ok");
	var ids = $('#myitems_sortable').sortable('toArray');
	//alert(this.id);
	ret = "";
	for(i=0; i<ids.length; i++){
		if(i!=delete_field) {
			ret += $( "#0_"+ids[i] ).val() + "===";
			if($( "#1_"+ids[i] ).val()!=""){
				ret += $( "#1_"+ids[i] ).val() + "===";
				ret += $( "#1_"+ids[i] ).val() + "===";
			}
			if($( "#2_"+ids[i] ).val()!=""){
				ret += $( "#2_"+ids[i] ).val() + "===";
			}
			if($( "#3_"+ids[i] ).val()!=""){
				ret += $( "#3_"+ids[i] ).val();
			}
			//***********************
			if($( "#0_"+ids[i] ).val()=="selectfromitems"){
				ret +=  "===" + $( "#4_"+ids[i] ).val();
				ret +=  "===" + $( "#5_"+ids[i] ).val();
			}
			//***********************
			var obj = document.getElementById("f_"+ids[i]);
			lnk = site+"adminarea/images/green/icons/";
			imgs = obj.src.substring(lnk.length, lnk.length+12);
			if(imgs=="infilter.gif"){
				ret += "===alisa_activefilter";
			}
			//***********************
			if(i!=ids.length-1)
				ret += "\n";
			//alert($( "#0_"+ids[i] ).val() + " :: "+i+ " :: "+ $( "#1_"+ids[i] ).val());
		}
	}
	delete_field = -1;
	//alert(ret);
	return ret;
}
//******************************
function get_template_fields(tval){
	//alert("ok "+tval);
	if(tval == "inputtext"){
		$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=gettemplatefields&tid="+document.getElementById("folder_item_type").value+"&code="+create_code(),
		success: function(html) {
			alert(html);
		}
	});
	}
}
//******************************
function delete_fm_field(fid){
	var ids = $('#myitems_sortable').sortable('toArray');
	if (confirm("Удалить поле "+$( "#0_"+ids[fid] ).val()+"?")) {
		delete_field = fid;
		save_code();
	}
}
//******************************
function insert_inputcheckbox(){
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=save_template&tid="+document.getElementById("folder_item_type").value+"&code="+create_code()+"\ninputcheckbox===",
		success: function(html) {
			//alert(html);
			get_template(document.getElementById("folder_item_type").value);
		}
	});
}
//******************************
function add_type(){
	var html = "<div class=\"ui-state-default-3\" id=\"myitems_sortable\">";
	html += "<div class=\"div_myitemname\" style=\"height:100px;\" >";
	html += "Название рус.<input type=\"text\" id=\"newtype_rus\" ><br/>";
	html += "Название eng.<input type=\"text\" id=\"newtype_eng\" ><br/><br/>";
	html += "<a onclick=\"save_newtype();\" href=\"javascript:\">";
	html += "<img src=\"images/green/save.gif\" width=\"100\" height=\"18\" border=\"0\"></a> ";
	html += "<a href=\"javascript:cancel_newtype()\">";
	html += "<img src=\"images/green/cancel.gif\" width=\"100\" height=\"18\" border=\"0\"></a> ";
	html += "</div></div>";
	$("#tmp_content").empty();
	$("#tmp_content").append(html);
}
//******************************
function save_newtype(){
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=save_newtype&nrus="+$( "#newtype_rus").val()+"&neng="+$( "#newtype_eng").val(),
		success: function(html) {
			//alert(html);
			var obj = document.getElementById("folder_item_type");
			inner = "<option value=\""+html+"\" >"+$( "#newtype_rus").val()+"</option>";
			obj.innerHTML = obj.innerHTML+inner;
			obj.value = html;
			get_template(html);
			//get_template(document.getElementById("folder_item_type").value);
		}
	});
}
//******************************
function cancel_newtype(){
	get_template(document.getElementById("folder_item_type").value);
}
//******************************
function toggle_filter(tgid){
	lnk = site+"adminarea/images/green/icons/";
	var obj = document.getElementById(tgid);
	imgs = obj.src.substring(lnk.length, lnk.length+12);
	if(imgs=="infilter.gif"){
		obj.src = lnk + "infilter_no.gif";
	} else {
		obj.src = lnk + "infilter.gif";
	}
	save_code();
}
//******************************

//******************************

//******************************