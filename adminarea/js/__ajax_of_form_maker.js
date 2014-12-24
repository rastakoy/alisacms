//var __ajax_url = "__ajax_of_form_maker.php";
var delete_field = -1;
//******************************
function __aofm_getItemTeplate(prmKey, tId, value){
	var paction = "paction=get_field_template&tid="+tId+"&prmkey="+prmKey+"&value="+value;
	//alert(paction);
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#tmp_content").empty();
			$("#tmp_content").append(html);
			$("#DBManager").css("display","none");
		}
	});
}
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
			$("#DBManager").css("display","none");
			$( "#myitems_sortable" ).sortable();
			$( "#myitems_sortable" ).disableSelection();
			//*****
			$( ".div_myitemname" ).click(function () {
				__aofm_getItemTeplate(this.id.replace(/^sprm_/, ''), tid);
			});
		}
	});
}
//******************************
function save_code(index){
	var dId = document.getElementById("tmp_content").firstChild.id;
	var num = dId.replace(/sprm_/, "");
	//alert(create_code_2(dId, num));
	var paction = "paction=save_template_2&tid="+document.getElementById("folder_item_type").value;
	paction += "&index="+index+"&code="+create_code_2(dId, num);
	//alert('paction='+paction);
	//return false;
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: paction,
		success: function(html) {
			//alert(html);
			get_template(document.getElementById("folder_item_type").value);
		}
	});
}
//******************************
function create_code_2(dId, num){
	//alert(dId+"::"+num);
	var index = document.getElementById('0_prm_'+num).value;
	var ret = "";
	if(index == "inputtext"){
		ret += document.getElementById('0_prm_'+num).value+"===";
		ret += document.getElementById('1_prm_'+num).value+"===";
		ret += document.getElementById('1_prm_'+num).value+"===";
		ret += document.getElementById('2_prm_'+num).value+"===";
		ret += document.getElementById('3_prm_'+num).value;
	}
	//*****************
	if(index == "pricedigit"){
		ret += document.getElementById('0_prm_'+num).value+"===";
	}
	//*****************
	if(index == "saveblock"){
		ret += document.getElementById('0_prm_'+num).value+"===";
	}
	//*****************
	if(index == "parent"){
		ret += document.getElementById('0_prm_'+num).value+"===";
	}
	//*****************
	if(index == "images"){
		ret += document.getElementById('0_prm_'+num).value+"===";
	}
	//*****************
	if(index == "coder"){
		ret += document.getElementById('0_prm_'+num).value+"===";
	}
	//*****************
	if(index == "textarea"){
		ret += document.getElementById('0_prm_'+num).value+"===";
	}
	//*****************
	if(index == "selectfromitems"){
		ret += document.getElementById('0_prm_'+num).value+"===";
		ret += document.getElementById('1_prm_'+num).value+"===";
		ret += document.getElementById('1_prm_'+num).value+"===";
		ret += document.getElementById('2_prm_'+num).value+"===";
		ret += document.getElementById('3_prm_'+num).value+"===";
		ret += document.getElementById('4_prm_'+num).value+"===";
		ret += document.getElementById('5_prm_'+num).value+"===";
	}
	//*****************
	if(index == "inputcheckbox"){
		ret += document.getElementById('0_prm_'+num).value+"===";
		ret += document.getElementById('1_prm_'+num).value+"===";
		ret += document.getElementById('1_prm_'+num).value+"===";
		ret += document.getElementById('2_prm_'+num).value;
	}
	//*****************
	//alert(ret);
	return ret;
}
//******************************
function create_code(){
	//alert("ok");
	var ids = $('#tmp_content').sortable('toArray');
	//alert(this.id);
	ret = "";
	//alert('OK '+ids.length);
	//alert(JSON.stringify(ids));
	//return false;
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
				//alert(eval("typeof  eventArray_"+prmKey));
				if(eval("typeof eventArray_"+prmKey+"!='undefined'")){
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
function get_template_fields(tval, key, index){
	alert("ok "+tval+" :: "+key+" :: "+index);
	//if(tval == "inputtext"){
	//	$.ajax({
	//	type: "POST",
	//	url: "__ajax_of_form_maker.php",
	//	data: "paction=gettemplatefields&tid="+document.getElementById("folder_item_type").value+"&code="+create_code(),
	//	success: function(html) {
	//		alert(html);
	//	}
	//});
	//}
}
//******************************
function delete_fm_field(key, id){
	//alert(key+"::"+id);
	if (confirm("Удалить это поле \""+$( "#0_prm_"+key ).val()+"\"?")) {
		$.ajax({
			type: "POST",
			url: "__ajax_of_form_maker.php",
			data: "paction=delete_item_from_teplate&key="+key+"&id="+id,
			success: function(html) {
				//alert(html);
				get_template(document.getElementById("folder_item_type").value);
			}
		});
	}
}
//******************************
function __aofm_addItemToTeplate(type){
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=add_item_to_teplate&tid="+document.getElementById("folder_item_type").value+"&type="+type,
		success: function(html) {
			//alert(html);
			get_template(document.getElementById("folder_item_type").value);
		}
	});
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
function cancel_field(tid){
	get_template(tid);
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
	$("#DBManager").css("display","none");
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
function __aofm_editDatabase(){
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: "paction=get_database",
		success: function(html) {
			//alert(html);
			$("#tmp_content").empty();
			$("#tmp_content").append(html);
			$("#DBManager").css("display","");
			
			//get_template(document.getElementById("folder_item_type").value);
		}
	});
}
//******************************
function __aofm_addToDatabase(){
	var inner = "<div style=\"background-color:#FFFFFF;padding:10px;\"><h2>Добавить поле в базу</h2>";
	inner += "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	
	inner += "<tr><td height=\"40\" width=\"250\">Название (латинское)</td><td>";
	inner += "<input id=\"newField_0\" type=\"text\" style=\"height:30px;width:250px;\" /></td></tr>";
	
	inner += "<tr><td height=\"40\" width=\"250\">Тип</td><td>";
	inner += "<select id=\"newField_1\" style=\"height:30px;width:250px;\">";
	inner += "<option value=\"text\">текст</option><option value=\"int\">число</option>";
	inner += "<option value=\"double\">число с запятой</option><select>";
	inner += "</td></tr>";
	
	inner += "<tr><td height=\"40\" width=\"250\">Длина</td><td>";
	inner += "<input id=\"newField_2\" type=\"number\" min=\"1\" max=\"255\" value=\"1\" style=\"height:30px;width:250px;\" /></td></tr>";
	
	inner += "<tr><td height=\"40\" width=\"250\">Значение по умолчанию</td><td>";
	inner += "<input id=\"newField_3\" type=\"text\" style=\"height:30px;width:250px;\" value=\"0\" /></td></tr>";
	
	inner += "<tr><td height=\"40\" width=\"250\">&nbsp;</td><td>";
	inner += "<button onClick=\"__aofm_addFlieldToDatabase()\">Сохранить</button>&nbsp;&nbsp;";
	inner += "<button onClick=\"__aofm_editDatabase()\">Отменить</button></td></tr>";
	
	inner += "</table>";
	inner += "</div>";
	$("#tmp_content").empty();
	$("#tmp_content").append(inner);
	$("#DBManager").css("display","");
}
//******************************
function __aofm_addFlieldToDatabase(){
	var paction = "paction=add_field_to_database";
	paction += "&name="+$("#newField_0").val();
	paction += "&type="+$("#newField_1").val();
	paction += "&length="+$("#newField_2").val();
	paction += "&default="+$("#newField_3").val();
	//alert(paction);
	$.ajax({
		type: "POST",
		url: "__ajax_of_form_maker.php",
		data: paction,
		success: function(html) {
			if(html.match(/Произошла ошибка/gi)){
				alert(html);
			}else{
				__aofm_editDatabase();
			}
			$("#DBManager").css("display","");
		}
	});
}
//******************************
function __aofm_deleteFlieldFromDatabase(name){
	if (confirm("Удалить это поле \""+name+"\"?")) {
		var paction = "paction=delete_field_from_database";
		paction += "&name="+name;
		//alert(paction);
		$.ajax({
			type: "POST",
			url: "__ajax_of_form_maker.php",
			data: paction,
			success: function(html) {
				if(html.match(/Произошла ошибка/gi)){
					alert(html);
				}else{
					__aofm_editDatabase();
				}
				$("#DBManager").css("display","");
			}
		});
	}
}
//******************************