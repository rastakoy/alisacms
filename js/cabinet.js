var loader_max = 8;
var loader_width = 16;
var loader_pos = 0;
var loader_interval = 100;
var loader_tout = false;
//******************************
$(document).ready(function() {
	//start_loader("loaderblock");
	//setTimeout("stop_loader('loaderblock')", 500);
	//show_cabinet();
});
//******************************
function start_loader(loaderblock){
	//alert("loaderblock="+loaderblock);
	$("#"+loaderblock).css("width", "16px");
	$("#"+loaderblock).css("height", "16px");
	$("#"+loaderblock).css("display", "");
	$("#"+loaderblock).css("background-position", "-"+(loader_pos*loader_width)+"px 0px");
	//*****************************************************
	loader_pos++;
	if(loader_pos == loader_max) loader_pos = 0;
	loader_tout = setTimeout("start_loader('"+loaderblock+"')", loader_interval);
	//alert("OK");
}
//******************************
function stop_loader(loaderblock){
	clearInterval(loader_tout);
	$("#"+loaderblock).css("display", "none");
	//alert("loaderblock="+loaderblock);
	//show_cabinet();
}
//******************************
function close_cabinet(){
	//*******************************
	$("#cabinet_bg").css("display", "none");
	//*******************************
	$("#cabinet_content").css("display", "none");
	//*******************************
	$("#cabinet_title").css("display", "none");
	//*******************************
	$("#cabinet_title_close").css("display", "none");
	//*******************************
}
//******************************
//alert("ok");
function show_cabinet(){
	//alert("function show_cabinet()");
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	$("#cabinet_bg").css("width", wwidth+"px");
	$("#cabinet_bg").css("height", wheight+"px");
	$("#cabinet_bg").css("display", "");
	//*******************************
	$("#cabinet_content").css("top", (100+document.body.scrollTop)+"px");
	$("#cabinet_content").css("left", (wwwidth/2-400)+"px");
	$("#cabinet_content").css("display", "");
	//*******************************
	$("#cabinet_title").css("top", (60+document.body.scrollTop)+"px");
	$("#cabinet_title").css("left", (wwwidth/2-390)+"px");
	$("#cabinet_title").css("display", "");
	//*******************************
	$("#cabinet_title_close").css("top", (70+document.body.scrollTop)+"px");
	$("#cabinet_title_close").css("left", (wwwidth/2+345)+"px");
	$("#cabinet_title_close").css("display", "");
	//*******************************
	__cabinet_get_userlogin();
	//obj_w = document.getElementById("autor_win");
	//alert("Okey");
}
//***********************************************************
var my_check_login = false;
function __cabinet_check_login(logval){
	//alert(user_event);
	if(user_event == "register" || user_event == "edit") {
		start_loader("loaderblock_login");
		if(user_event == "edit")
			paction = "paction=cabinet_check_login&login="+$("#loaderblock_login_txt").val()+"&event="+user_event+"&uid="+user_id;
		else
			paction = "paction=cabinet_check_login&login="+$("#loaderblock_login_txt").val();
		//alert(paction);
		$.ajax({
			type: "POST",
			url: "__ajax_cabinet.php",
			data: paction,
			success: function(html) {
				stop_loader("loaderblock_login");
				//alert(html);
				if(html=="ok"){
					$("#loaderblock_login_txt").css("background-color", "#B7D9B7");
					my_check_login = $("#loaderblock_login_txt").val();
				}
				if(html=="no"){
					$("#loaderblock_login_txt").css("background-color", "#FF5B5B");
					my_check_login = false;
				}
			}
		});
	}
}
//***********************************************************
var my_pass_txt = false;
function __cabinet_check_pass(){
	if(user_event == "register") {
		if($("#loaderblock_pass_txt").val() == $("#loaderblock_checkpass_txt").val() && $("#loaderblock_pass_txt").val()!=""){
			$("#loaderblock_pass_txt").css("background-color", "#B7D9B7");
			$("#loaderblock_checkpass_txt").css("background-color", "#B7D9B7");
			my_pass_txt = $("#loaderblock_pass_txt").val();
		} else {
			$("#loaderblock_pass_txt").css("background-color", "#FF5B5B");
			$("#loaderblock_checkpass_txt").css("background-color", "#FF5B5B");
			my_pass_txt = false;
		}
	}
}
//***********************************************************
var my_check_email = false;
function __cabinet_check_email(email){
	//alert(email);
	if (    isValidEmail(email)     ||     email.match(/.+@i\.ua$/)    ){
		$("#loaderblock_email_txt").css("background-color", "#B7D9B7");
		my_check_email = $("#loaderblock_email_txt").val();
	} else {
		$("#loaderblock_email_txt").css("background-color", "#FF5B5B");
		my_check_email = false;
	}
}
//***********************************************************
function isValidEmail (p_email){
	//alert(p_email);
	if(  p_email.match(/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9-._]+){1,3}?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/gi)   )
		return true
	return false;
	t=p_email.indexOf('@');
	//alert("t="+t+":::"+p_email);
	if ((p_email.indexOf('.')==-1)||(t==-1)||(t < 1)||
	(t > p_email.length - 3) || (p_email.charAt(t - 1)=='.') || (p_email.charAt(t+1)=='.')){
    	//alert(t + ":::" + (p_email.length - 2) + ":::" + p_email.charAt(t - 1) + ":::" + p_email.charAt(t+1) );
		return false;
  	}
	//alert(t + ":::" + (p_email.length - 2) + ":::" + p_email.charAt(t - 1) + ":::" + p_email.charAt(t+1) );
	return true;
}
//***********************************************************
var my_check_fio = false;
function __cabinet_check_fio(){
	if ($("#loaderblock_checkfio_txt").val()==""){
		$("#loaderblock_checkfio_txt").css("background-color", "#FF5B5B");
		my_check_fio = false;
	} else {
		$("#loaderblock_checkfio_txt").css("background-color", "#B7D9B7");
		my_check_fio = $("#loaderblock_checkfio_txt").val();
	}
}
//***********************************************************
var old_ptxt = "";
var my_check_phone = false;
function __cabinet_check_phone(){
	//if($("#loaderblock_phone_txt").val() != old_ptxt){
		ptxt = $("#loaderblock_phone_txt").val();
		if(ptxt=="") $("#loaderblock_phone_txt").css("background-color", "");
		rval = "";
		if(!ctd(ptxt.substr(-1))) {
			rval = ptxt.substr(0, ptxt.length-1);
			$("#loaderblock_phone_txt").val(rval);
			return false;
		}
		for(i=0; i<ptxt.length; i++){
			//alert(ptxt[0]);
			if(i==0 && ptxt[0]!="(" ){
				rval = "("+ptxt[0];
			}
			if(i==0 && ptxt[0]=="(" ){
				rval = "(";
			}
			//**********************
			if(i>0 && i<4){
				rval += ptxt[i];
			}
			//**********************
			if(i==4 && ptxt[4]!=")"){
				rval += ") "+ptxt[4];
			}
			if(i==4 && ptxt[4]==")" ){
				rval += ") ";
			}
			//**********************
			if(i>5 && i<9){
				rval += ptxt[i];
			}
			//**********************
			if(i==9 && ptxt[9]!="-"){
				rval += "-"+ptxt[9];
			}
			if(i==9 && ptxt[9]=="-" ){
				rval += "-";
			}
			//**********************
			if(i>9 && i<12){
				rval += ptxt[i];
			}
			//**********************
			if(i==12 && ptxt[12]!="-"){
				rval += "-"+ptxt[12];
			}
			if(i==12 && ptxt[12]=="-" ){
				rval += "-";
			}
			//**********************
			if(i>12){
				rval += ptxt[i];
			}
			//**********************
		//}
		//$("#loaderblock_city_txt").val(rval);
		if(rval.length == 15){
			a=true;
			if(rval[0] != "(") a=false;
			if(!ctd(rval[1])) a=false;
			if(!ctd(rval[2])) a=false;
			if(!ctd(rval[3])) a=false;
			if(rval[4] != ")") a=false;
			if(rval[5] != " ") a=false;
			if(!ctd(rval[6])) a=false;
			if(!ctd(rval[7])) a=false;
			if(!ctd(rval[8])) a=false;
			if(rval[9] != "-") a=false;
			if(!ctd(rval[10])) a=false;
			if(!ctd(rval[11])) a=false;
			if(rval[12] != "-") a=false;
			if(!ctd(rval[13])) a=false;
			if(!ctd(rval[14])) a=false;
			if(a) {
				$("#loaderblock_phone_txt").css("background-color", "#B7D9B7");
				my_check_phone = rval;
			}
		} else {
			$("#loaderblock_phone_txt").css("background-color", "#FF5B5B");
			my_check_phone = false;
		}
		$("#loaderblock_phone_txt").val(rval);
	}
}
//***********************************************************
function ctd(lt){
	if(lt!="0" && lt!="1" && lt!="2" && lt!="3" && lt!="4" && lt!="5" && lt!="6" && lt!="7" && lt!="8" && lt!="9"){
		return false;
	}
	return true;
}
//***********************************************************
function close_sel_zone(){
	$("#cabinet_in_cont").css("display", "");
	$("#cabinet_select_zone").css("display", "none");
}
//***********************************************************
var cab_my_zone = 0;
function __cabinet_select_zone(){
	paction = "paction=cabinet_get_novaposhta&prov=novaposhta_states";
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			html = "<a href=\"javascript:close_sel_zone()\"><b>Вернуться</b></a><br/>"+html;
			$("#cabinet_select_zone").empty();
			$("#cabinet_select_zone").append(html);
			$("#cabinet_in_cont").css("display", "none");
			$("#cabinet_select_zone").css("display", "");
		}
	});
}
//***********************************************************
function __cabinet_add_zone(zid){
	paction = "paction=cabinet_add_zone&pid="+zid;
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			cab_my_zone = zid;
			inner = "<input name=\"userdostadress\" type=\"text\" id=\"userdostadress\" ";
			inner += " style=\"width:70%;\"  value=\""+html+"\" onchange=\"cab_my_zone = -100;\"  />";
			inner += " &nbsp; <a href=\"javascript:__cabinet_select_zone()\">Изменить...</a>";
			$("#divselzone").empty();
			$("#divselzone").append(inner);
			$("#cabinet_in_cont").css("display", "");
			$("#cabinet_select_zone").css("display", "none");
		}
	});
}
//***********************************************************
var my_chek_kaptcha = false;
function __cabinet_chek_kaptcha(kval){
	start_loader("loaderblock_digit");
	paction = "paction=cabinet_check_kaptcha&kval="+kval;
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			stop_loader("loaderblock_digit");
			if(html=="ok"){
				$("#userdigits").css("background-color", "#B7D9B7");
				my_chek_kaptcha = $("#userdigits").val();
			}
			if(html=="false"){
				$("#userdigits").css("background-color", "#FF5B5B");
				my_chek_kaptcha = false;
			}
		}
	});
}
//***********************************************************
function __cabinet_getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}
//***********************************************************
function __cabinet_clear(){
	$("#loaderblock_login_txt").val("");
	$("#loaderblock_pass_txt").val("");
	$("#loaderblock_checkpass_txt").val("");
	$("#loaderblock_email_txt").val("");
	$("#loaderblock_checkfio_txt").val("");
	$("#loaderblock_phone_txt").val("");
	cab_my_zone = 0;
	inner = "<a href=\"javascript:__cabinet_select_zone()\">Выбрать...</a>";
	$("#divselzone").empty();
	$("#divselzone").append(inner);
}
//***********************************************************
function __cabinet_reload_kaptcha(){
	inner = '<img src="homotest.php" width="88" height="31" align="absbottom" />';
	$("#sp_kaptcha").empty();
	$("#sp_kaptcha").append(inner);
	$("#userdigits").val("");
	$("#userdigits").css("background-color", "");
}
//***********************************************************
function __cabinet_user_register(){
	var get_message = true;
	if(user_event == "register"){
		if(!my_check_login && get_message){
			alert("Ошибка в имени пользователя");
			get_message = false;
		}
		//*******************
		if(!my_pass_txt && get_message){
			alert("Ошибка в полях паролей");
			get_message = false;
		}
		//*******************
		if(!my_check_email && get_message){
			alert("Ошибка в поле «E-mail»");
			get_message = false;
		}
		//*******************
		if(!my_check_fio && get_message){
			alert("Введите имя, мы должны знать, как к вам обращаться");
			get_message = false;
		}
		//*******************
		if(!my_check_phone && get_message){
			alert("Некорректный телефон");
			get_message = false;
		}
		//*******************
		if(cab_my_zone==0 && get_message){
			alert("Некорректный адрес доставки");
			get_message = false;
		}
		//*******************
		if(!my_chek_kaptcha && get_message){
			alert("Некорректные контрольные цифры");
			get_message = false;
		}
		//*******************
		if(get_message){
			paction = "paction=cabinet_user_register";
			paction += "&login="+my_check_login;
			paction += "&pass="+my_pass_txt;
			paction += "&email="+my_check_email;
			paction += "&fio="+my_check_fio;
			paction += "&phone="+my_check_phone;
			paction += "&zone="+cab_my_zone;
			paction += "&kaptcha="+my_chek_kaptcha;
			//alert(paction);
			$.ajax({
				type: "POST",
				url: "__ajax_cabinet.php",
				data: paction,
				success: function(html) {
					//alert(html);
					if(html == "ok"){
						//__cabinet_get_user_info();
						window.location.href = window.location.href;
					}
				}
			});
		}
	}
}
//***********************************************************
function __cabinet_get_user_info(){
	paction = "paction=cabinet_get_user_info";
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			$("#cabinet_content").empty();
			$("#cabinet_content").append(html);
		}
	});
}
//***********************************************************
function __cabinet_user_login(){
	paction = "paction=cabinet_login_user&reg_login="+$("#loaderblock_login_txt").val()+"&reg_pass="+$("#loaderblock_pass_txt").val();
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			if(html != "no"){
				$("#cabinet_in_cont").empty();
				$("#cabinet_in_cont").append(html);
				$("#cabinet_in_cont").css("text-align", "left");
				window.location.href = root_link + "cabinet/orders/";
			} else {
				$("#loaderblock_login_txt").css("background-color", "#FF5B5B");
				$("#loaderblock_pass_txt").css("background-color", "#FF5B5B");
			}
		}
	});
}
//***********************************************************
function __cabinet_get_userlogin(){
	paction = "paction=cabinet_get_userlogin&event="+user_event;
	//alert(paction);
	//user_event = "login";
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			if(html != "no"){
				$("#cabinet_content").empty();
				$("#cabinet_content").append(html);
				$("#cabinet_content").css("text-align", "left");
				$("#cabinet_content").css("display", "");
			} else {
				$("#loaderblock_login_txt").css("background-color", "#FF5B5B");
				$("#loaderblock_pass_txt").css("background-color", "#FF5B5B");
			}
			if(user_event == "edit"){
				__cabinet_check_login($("#loaderblock_login_txt").val());
				__cabinet_check_email($("#loaderblock_email_txt").val())
				__cabinet_check_fio();
				__cabinet_check_phone();
				edit_passwords = false;
			}
		}
	});
}
//***********************************************************
function __cabinet_exit(){
	document.location.href = document.location.href+"/[exit]";
}
//***********************************************************
function __cabinet_reg(){
	user_event = "register";
	__cabinet_get_userlogin();
}
//***********************************************************
function __cabinet_edit_user(muid){
	user_event = "edit";
	user_id = muid;
	__cabinet_get_userlogin();
}
//***********************************************************
function __cabinet_user_postedit(){
	var get_message = true;
	if(user_event == "edit"){
		if(!my_check_login && get_message){
			alert("Ошибка в имени пользователя");
			get_message = false;
		}
		//*******************
		if(!my_pass_txt && get_message && edit_passwords){
			alert("Ошибка в полях паролей");
			get_message = false;
		}
		//*******************
		if(!my_check_email && get_message){
			alert("Ошибка в поле «E-mail»");
			get_message = false;
		}
		//*******************
		if(!my_check_fio && get_message){
			alert("Введите имя, мы должны знать, как к вам обращаться");
			get_message = false;
		}
		//*******************
		if(!my_check_phone && get_message){
			alert("Некорректный телефон");
			get_message = false;
		}
		//*******************
		if(cab_my_zone==0 && get_message){
			alert("Некорректный адрес доставки");
			get_message = false;
		}
		//*******************
		if(get_message){
			paction = "paction=cabinet_user_editpost";
			paction += "&login="+my_check_login;
			paction += "&uid="+user_id;
			//paction += "&pass="+my_pass_txt;
			paction += "&email="+my_check_email;
			paction += "&fio="+my_check_fio;
			paction += "&phone="+my_check_phone;
			paction += "&zone="+cab_my_zone;
			paction += "&kaptcha="+my_chek_kaptcha;
			//alert(paction);
			$.ajax({
				type: "POST",
				url: "__ajax_cabinet.php",
				data: paction,
				success: function(html) {
					//alert(html);
					if(html == "ok"){
						__cabinet_get_user_info();
					}
				}
			});
		}
	}
}
//***********************************************************
function __cabinet_change_pass(){
	//alert("asd");
	$("#tr_pass_1").css("display", "");
	$("#tr_pass_2").css("display", "");
	$("#tr_pass_3").css("display", "");
	$("#tr_pass_4").css("display", "");
	$("#tr_pass_0").css("display", "none");
}
//***********************************************************
function __cabinet_remind_pass(){
	paction = "paction=cabinet_remind_pass";
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#cabinet_content").empty();
			$("#cabinet_content").append(html);
		}
	});
}
//***********************************************************
function __cabinet_user_postremind(){
	if(my_check_email) {
		paction = "paction=cabinet_user_postremind&email="+my_check_email;
		$.ajax({
			type: "POST",
			url: "__ajax_cabinet.php",
			data: paction,
			success: function(html) {
				alert(html);
				//$("#cabinet_content").empty();
				//$("#cabinet_content").append(html);
			}
		});
	} else {
		//alert("nook");
	}
}
//***********************************************************
function __cabinet_look_zak(pid){
	paction = "paction=cabinet_user_zakaz_info&pid="+pid;
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#cabinet_content").empty();
			$("#cabinet_content").append(html);
		}
	});
}
//***********************************************************
function __cabinet_fast_reg(){
	//alert("ok");
	my_check_email = false;
	my_check_fio = false;
	my_check_phone = false;
	cab_my_zone = 0;
	my_chek_kaptcha = false;
	//***************
	paction = "paction=cabinet_get_userlogin&event=fastinfo";
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			//alert(html);
			//document.getElementById("td_reccdata").style.display = "none";
			//document.getElementById("td_userdata").style.display = "";
			$("#td_reccdata").css("display", "none");
			$("#td_userdata").css("display", "");
			$("#td_userdata").empty();
			$("#td_userdata").append(html);
			
		}
	});
}
//***********************************************************
function __cabinet_fast_reg_back(){
	$("#td_reccdata").css("display", "");
	$("#td_userdata").css("display", "none");
}
//***********************************************************
function __cabinet_user_fastreg(){
	//alert("__cabinet_user_fastreg");
	var get_message = true;
	user_event = "fastreg";
	if(user_event == "fastreg"){
		if(!my_check_email && get_message){
			alert("Ошибка в поле «E-mail»");
			get_message = false;
		}
		//*******************
		if(!my_check_fio && get_message){
			alert("Введите имя, мы должны знать, как к вам обращаться");
			get_message = false;
		}
		//*******************
		if(!my_check_phone && get_message){
			alert("Некорректный телефон");
			get_message = false;
		}
		//*******************
		if(cab_my_zone==-100 && get_message){
			get_message = false;
			//alert($("#userdostadress").val());
			if($("#userdostadress").val()!=""){
				get_message = true;
				cab_my_zone = -100;
			} else {
				alert("Введите адрес доставки");
			}
		}
		//*******************
		if(!my_chek_kaptcha && get_message && $("#userdigits").id){
			alert("Некорректные контрольные цифры");
			get_message = false;
		}
		//*******************
		//alert("get_message="+get_message);
		if(get_message){
			paction = "paction=cabinet_user_fastreg";
			paction += "&email="+my_check_email;
			paction += "&fio="+my_check_fio;
			paction += "&phone="+my_check_phone;
			paction += "&zone="+cab_my_zone;
			paction += "&kaptcha="+my_chek_kaptcha;
			paction += "&usercomment="+$("#usercomment").val();
			paction += "&userpromo="+$("#userpromo").val();
			paction += "&userdostadress="+$("#userdostadress").val();
			paction += "&userId=";
			//alert(paction);
			$.ajax({
				type: "POST",
				url: "__ajax_cabinet.php",
				data: paction,
				success: function(html) {
					//alert(html)
					$("#basckerUser").empty();
					$("#basckerUser").append(html);
					$("#qttyItem_"+reccIndex).val("1");
					__pb_changeQtty(document.getElementById("qttyItem_"+reccIndex));
					setTimeout("document.getElementById('hmkatalog2').hide_menu()", 2000);
				}
			});
		}
	}
}
//***********************************************************
function __user_zakaz(){
	paction = "paction=user_start_zakaz";
	//alert(paction);
	$.ajax({
		type: "POST",
		url: "__ajax_cabinet.php",
		data: paction,
		success: function(html) {
			//alert(html);
			$("#td_reccdata").css("display", "none");
			$("#td_userdata").css("display", "");
			$("#td_userdata").empty();
			$("#td_userdata").append(html);
		}
	});
}
//***********************************************************

//***********************************************************

//***********************************************************