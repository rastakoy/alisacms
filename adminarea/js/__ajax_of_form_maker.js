//var __ajax_url = "__ajax_of_form_maker.php";
var delete_field = -1;
//******************************
function __aofm_removeEvent(prmKey){
	var str = "eventArray_"+prmKey+"['"+(document.getElementById("5_prm_"+prmKey).value)+"']";
	eval("delete "+str);
	document.getElementById("6_prm_"+prmKey).style.display = "none";
	document.getElementById("off_prm_"+prmKey).style.display = "none";
}
//******************************
function __aofm_setTextEvent(obj){
	prmKey = obj.id.replace(/^[0-9]{1,3}_prm_/, "");
	prm = obj.id.replace(/[0-9]{1,3}$/, "");
	if(obj.value!=""){
		objOff = document.getElementById("off_prm_"+prmKey);
		objOff.style.display = "";
		objOff.onclick = function(){
			__aofm_removeEvent(prmKey);
		}
		var str = "eventArray_"+prmKey+"['"+(document.getElementById("5_prm_"+prmKey).value)+"'] = '"+(obj.value)+"'";
		eval(str);
	}else{
		document.getElementById("off_prm_"+prmKey).style.display = "none";
		__aofm_removeEvent(prmKey);
	}
}
//******************************
function __aofm_getTextEvent(obj){
	prmKey = obj.id.replace(/^[0-9]{1,3}_prm_/, "");
	prm = obj.id.replace(/[0-9]{1,3}$/, "");
	//alert(prmKey+"::"+prm);
	if(eval("eventArray_"+prmKey+"['"+obj.value+"']")){
		document.getElementById("6_prm_"+prmKey).value = eval("eventArray_"+prmKey+"['"+obj.value+"']");
		objOff = document.getElementById("off_prm_"+prmKey);
		objOff.style.display = "";
		objOff.onclick = function(){
			__aofm_removeEvent(prmKey);
		}
	}else{
		document.getElementById("6_prm_"+prmKey).value = "";
		document.getElementById("off_prm_"+prmKey).style.display = "none";
	}
	if(obj.value!=""){
		document.getElementById("6_prm_"+prmKey).style.display = "";
	}else{
		document.getElementById("6_prm_"+prmKey).style.display = "none";
	}
}
//******************************
function get_template(tid){
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=get_template&tid="+tid,
		success: function(html) {
			//alert(html);
			$("#tmp_content").empty();
			$("#tmp_content").append(html);
			$( "#myitems_sortable" ).sortable();
			$( "#myitems_sortable" ).disableSelection();
			//*****
			$( ".div_myitemname" ).click(function () {
				var ids = $('#myitems_sortable').sortable('toArray');
				//alert(this.id);
				for(i=0; i<ids.length; i++){
					$( "#s"+ids[i] ).css("height", "22");
					$( "#ss"+ids[i] ).css("display", "none");
				}
				//vvar = 
				//alert(priors);
				$( "#s"+this.id ).css("display", "");
				$( this ).css("height", "100");
			});
		}
	});
}
//******************************
function save_code(){
	//alert(create_code());
	//alert(create_code());
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=save_template&tid="+document.getElementById("folder_item_type").value+"&code="+create_code(),
		success: function(html) {
			//alert(html);
			get_template(document.getElementById("folder_item_type").value);
		}
	});
}
//******************************
function create_code(){
	//alert("ok");
	var ids = $('#myitems_sortable').sortable('toArray');
	//alert(this.id);
	ret = "";
	//alert(ids);
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
			if($( "#0_"+ids[i] ).val()=="inputtext"){
				var prmKey = ids[i];
				prmKey = prmKey.replace(/prm_/, "");
				var prmArray = eval("eventArray_"+prmKey);
				var retPrm = "";
				for(var j in prmArray){
					if(prmArray[j]){
						retPrm += "===";
						break;
					}
				}
				for(var j in prmArray){
					if(prmArray[j]){
						retPrm += j+"="+prmArray[j]+";";
					}
				}
				retPrm = retPrm.replace(/;$/, "");
				//alert(retPrm);
				ret += retPrm;
			}
			//***********************
			if($( "#0_"+ids[i] ).val()=="selectfromitems"){
				ret +=  "===" + $( "#4_"+ids[i] ).val();
				ret +=  "===" + $( "#5_"+ids[i] ).val();
			}
			//***********************
			if($( "#0_"+ids[i] ).val()=="selectfromitems_many"){
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
function cancel_field(){
	var ids = $('#myitems_sortable').sortable('toArray');
	for(i=0; i<ids.length; i++){
		$( "#s"+ids[i] ).css("height", "22");
		$( "#ss"+ids[i] ).css("display", "none");
	}
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