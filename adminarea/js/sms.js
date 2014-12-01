function showSMSWindow(orderId){
	__modal("smsWindow", {
		"width":"500",
		"height":"200",
		"clickableBg":true,
		"closeButton": true,
		"effect":"fade"
	});
	smso = document.getElementById("smsWindow");
	var inner = "<b>Отправка sms-сообщения</b>";
	inner += "<table border=0 cellspacing=0 cellpadding=0 width=100% style=\"margin-top:20px\">";
	inner += "<tr>";
	inner += "<td width=\"150\" height=\"35\">Тип смс</td><td>";
	inner += "<select onChange=\"smsGroup(this.value)\">";
	inner += "<option value=\"0\"></option>";
	inner += "<option value=\"1\">Cчет</option>";
	inner += "<option value=\"2\">СМС-ТТН</option>";
	inner += "<option value=\"3\">Текст</option>";
	inner += "</select></td>";
	inner += "</tr>";
	
	inner += "<tr id=\"sms_1\" style=\"display:none;\" >";
		inner += "<td width=\"150\" height=\"35\">Введите сумму</td>";
		inner += "<td><input type=\"text\" id=\"tsms_1\" onKeyUp=\"prewSMS_1()\"></td>";
	inner += "</tr>";
	inner += "<tr id=\"smsP_1\" style=\"display:none;\" >";
		inner += "<td colspan=\"2\" height=\"35\" id=\"prewSms_1\">Оплата ПриватБанк Дренгаль О.В. №5168-7572-1345-0499, UAH, Спасибо. Лента и Декор</td>";
	inner += "</tr>";
	inner += "<tr id=\"smsB_1\" style=\"display:none;\" >";
		inner += "<td colspan=\"2\" height=\"35\"><button onClick=\"sendSMS_1("+orderId+")\">Отправить SMS</button></td>";
	inner += "</tr>";
	
	inner += "<tr id=\"sms_2\" style=\"display:none;\" >";
		inner += "<td width=\"150\" height=\"35\">Введите номер ТТН</td>";
		inner += "<td><input type=\"text\" id=\"tsms_2\" onKeyUp=\"prewSMS_2()\"></td>";
	inner += "</tr>";
	inner += "<tr id=\"smsP_2\" style=\"display:none;\" >";
		inner += "<td colspan=\"2\" height=\"35\" id=\"prewSms_2\">Номер накладной ТТН: № ___. Товар отправлен. Лента и Декор </td>";
	inner += "</tr>";
	inner += "<tr id=\"smsB_2\" style=\"display:none;\" >";
		inner += "<td colspan=\"2\" height=\"35\"><button onClick=\"sendSMS_2("+orderId+")\">Отправить SMS</button></td>";
	inner += "</tr>";
	
	inner += "<tr id=\"sms_3\" style=\"display:none;\" >";
		inner += "<td width=\"150\" height=\"35\">Введите текст сообщения</td>";
		inner += "<td><textarea id=\"tsms_3\" onKeyUp=\"prewSMS_3()\"></textarea></td>";
	inner += "</tr>";
	inner += "<tr id=\"smsP_3\" style=\"display:none;\" >";
		inner += "<td colspan=\"2\" height=\"35\" id=\"prewSms_3\">_______. Лента и Декор </td>";
	inner += "</tr>";
	inner += "<tr id=\"smsB_3\" style=\"display:none;\" >";
		inner += "<td colspan=\"2\" height=\"35\"><button onClick=\"sendSMS_3("+orderId+")\">Отправить SMS</button></td>";
	inner += "</tr>";
	
	inner += "</table>";
	smso.innerHTML = inner;
	
}
//***********************************************
function smsGroup(gIndex){
	document.getElementById("sms_1").style.display = "none";
	document.getElementById("smsP_1").style.display = "none";
	document.getElementById("smsB_1").style.display = "none";
	//************
	document.getElementById("sms_2").style.display = "none";
	document.getElementById("smsP_2").style.display = "none";
	document.getElementById("smsB_2").style.display = "none";
	//************
	document.getElementById("sms_3").style.display = "none";
	document.getElementById("smsP_3").style.display = "none";
	document.getElementById("smsB_3").style.display = "none";
	//************
	if(gIndex>0){
		document.getElementById("sms_"+gIndex).style.display = "";
		document.getElementById("smsP_"+gIndex).style.display = "";
		document.getElementById("smsB_"+gIndex).style.display = "";
	}
}
//***********************************************
function prewSMS_1(){
	var ret = "Оплата ПриватБанк Дренгаль О.В. №5168-7572-1345-0499, ";
	ret += document.getElementById("tsms_1").value;
	ret += " UAH, Спасибо. Лента и Декор";
	document.getElementById("prewSms_1").innerHTML = ret;
}
//***********************************************
function sendSMS_1(orderId){
	var ret = "Оплата ПриватБанк Дренгаль О.В. №5168-7572-1345-0499, ";
	ret += document.getElementById("tsms_1").value;
	ret += " UAH, Спасибо. Лента и Декор";
	var paction = "paction=ao_sendSMS&orderId="+orderId+"&text="+ret;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			document.getElementById("smsWindow").close();
			//if(confirm("Отправить SMS с ТТН этому пользователю?")){
			//	__ao_sendSMS();
			//}
		}
	});
}
//***********************************************
function prewSMS_2(){
	var ret = "Номер накладной ТТН: № ";
	ret += document.getElementById("tsms_2").value;
	ret += ". Товар отправлен. Лента и Декор";
	document.getElementById("prewSms_2").innerHTML = ret;
}
//***********************************************
function sendSMS_2(orderId){
	var ret = "Номер накладной ТТН: № ";
	ret += document.getElementById("tsms_2").value;
	ret += ". Товар отправлен. Лента и Декор";
	var paction = "paction=ao_sendSMS&orderId="+orderId+"&text="+ret;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			document.getElementById("smsWindow").close();
			//if(confirm("Отправить SMS с ТТН этому пользователю?")){
			//	__ao_sendSMS();
			//}
		}
	});
}
//***********************************************
function prewSMS_3(){
	var ret = document.getElementById("tsms_3").value;
	ret += ". Лента и Декор";
	document.getElementById("prewSms_3").innerHTML = ret;
}
//***********************************************
function sendSMS_3(orderId){
	var ret = document.getElementById("tsms_3").value;
	ret += ". Лента и Декор";
	var paction = "paction=ao_sendSMS&orderId="+orderId+"&text="+ret;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			alert(html);
			document.getElementById("smsWindow").close();
			//if(confirm("Отправить SMS с ТТН этому пользователю?")){
			//	__ao_sendSMS();
			//}
		}
	});
}
//***********************************************