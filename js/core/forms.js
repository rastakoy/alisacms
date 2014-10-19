var oldKeyDownValue;
function __ff_controlTextType(vId, vType){
	if(vType=="Числовой"){
		$("#"+vId).keydown(function(event, obj){
			//alert(this)//oldKeyDownValue
		});
		$("#"+vId).keyup(function(event, obj){
			if(this.value.match(/^[0-9]+$/)) {
				//alert("ok")
			} else {
				$("#"+vId).notify("Вводить только цифры",{autoHideDelay : 1100});
				return false;
			}
		})
	}
}
//************************************************************************************
function checkForm(fObj){
	//alert("#"+fObj.id+" input, #"+fObj.id+" select");
	var objs = $("#"+fObj.id+" input, #"+fObj.id+" select");
	var ret=true;
	//alert(JSON.stringify(send_objs));
	for( var j=0; j<objs.length; j++){
		//if(  objs[j].id  ){
			if(  send_objs[j]  ){
			//for(  var jj in send_objs  ){
				//alert(arrOnLoad[jj][2]);
				if(send_objs[j][0]["inputProperties_check"]=="Да"){
					if(objs[j].value=="" || objs[j].value==send_objs[j][0]["content"]) {
						$(objs[j]).notify("Необходимо заполнить поле",{autoHideDelay : 1100});
						//alert("a");
						//alert(JSON.stringify(arrOnLoad[jj]));
						ret = false;
						break;
					}
				}
			}
		//}
	}
	//return false;
	if(ret) this.submit();
	//alert(objsNew.length);
}
//************************************************************************************
var curAcmplGObj = false;
var curAcmplObj = false;
var curAcmplObjIndex = -1;
function __ff_input_autocomplit(fObj, fField ){
	fObj.autocomplete = "off";
	$(fObj).keyup(function(event, obj){
		//alert( fObj.id );
		gets = {
			"ajax":"loadautocomplete",
			"field":fField,
			"content":fObj.value,
			"link":document.location.href.replace(RegExp(root_link, "gi"), "")
		}
		curAcmplObj = fObj;
		//alert(JSON.stringify(gets));
		if(event.which!=40 && event.which!=38 && event.which!=13 && event.which!=27) {
			curAcmplObjIndex = -1;
			getJSON(gets, "__ff_show_autocomplete");
		}
		if(event.which==40 || event.which==38){
			var a = document.getElementById("autocmplField");
			if(!a && event.which!=13 && event.which!=27) getJSON(gets, "__ff_show_autocomplete");
			if(a){
				//
			}
		}
	})	;
	$(fObj).focusout(function(){
		var a = document.getElementById("autocmplField");
		if(a) a.parentNode.removeChild(a);
	});
	$(fObj).focus(function(){
		curAcmplGObj = this;
	})
	$(fObj).keydown(function(event, obj){
		var a = document.getElementById("autocmplField");
		if(a) {
			if(event.which==40){
				aobjs = $("#autocmplField a");
				for(var j=0; j<aobjs.length; j++ ) {
					aobjs[j].className = "";
				}
				curAcmplObjIndex++;
				if(curAcmplObjIndex==aobjs.length) curAcmplObjIndex=aobjs.length-1;
				aobjs[curAcmplObjIndex].className = "active";
			}
			if(event.which==38){
				aobjs = $("#autocmplField a");
				for(var j=0; j<aobjs.length; j++ ) {
					aobjs[j].className = "";
				}
				curAcmplObjIndex--;
				if(curAcmplObjIndex<0) curAcmplObjIndex=0;
				aobjs[curAcmplObjIndex].className = "active";
			}
			if(event.which==13){
				aobjs = $("#autocmplField a");
				curAcmplGObj.value = aobjs[curAcmplObjIndex].innerHTML;
				var a = document.getElementById("autocmplField");
				if(a) a.parentNode.removeChild(a);
				curAcmplObjIndex = -1;
				return false;
			}
			if(event.which==27){
				var a = document.getElementById("autocmplField");
				if(a) a.parentNode.removeChild(a);
				curAcmplObjIndex = -1;
				return false;
			}
		}
	});
}
//************************************************************************************
function __ff_show_autocomplete( data ){
	//alert(JSON.stringify(data));
	inner = "";
	for(var j in data)
		inner += "<a href=\"javascript:\">"+data[j]["name"]+"</a>";
	a = document.getElementById("autocmplField");
	if(a){
		a.innerHTML = inner;
	} else {
		var newDiv = document.createElement('div')
		newDiv.className = 'my-class'
		newDiv.id = 'autocmplField'
		newDiv.innerHTML = inner;
		
		//asd = document.getElementsByTagName('BODY')[0];
		curAcmplObj.parentNode.appendChild(newDiv);
		var mcss = {
			"width":curAcmplObj.clientWidth-5
		}
		$(newDiv).css(mcss);
	}
	$("#autocmplField a").mousedown(function(){
		curAcmplGObj.value = this.innerHTML;
	});
	$("#autocmplField a").mouseover(function(){
		aobjs = $("#autocmplField a");
		for(var j=0; j<aobjs.length; j++ )
			aobjs[j].className = "";
		curAcmplObjIndex = $(this).index();
		aobjs[curAcmplObjIndex].className = "active";
		//alert("s");
	});
	//alert(document.getElementById("autocmplField").innerHTML);
	//alert(aco.innerHtml);
	//var elem  =   document.createElement('table');

}
//************************************************************************************
//function __ff_check_login(loginObject){
//	//alert(loginObject.value);
//	if(loginObject.value.match(/^[0-9a-zA-Zа-яА-Я_-]+$/)) {
//		return "ok";
//	} else {
//		$(loginObject).notify("Цифры, буквы, знак«_»",{autoHideDelay : 1300});
//		return false;
//	}
//}
//************************************************************************************
function __ff_check_login(loginObject, byKey){
	//alert(loginObject.value);
	//alert(byKey);
	if(byKey=="email"){
		loginObject.value = loginObject.value.replace(/ /, '');
		loginObject.value = loginObject.value.replace(/^\s*/, '');
		loginObject.value = loginObject.value.replace(/\s*$/, '');
		loginObject.value = loginObject.value.toLowerCase();
		//alert("("+loginObject.value+")");
		if(__ff_check_email(loginObject.value)){
			return "ok";
		} else {
			$(loginObject).notify("Неверный почтовый адрес",{autoHideDelay : 1300});
			return false;
		}
	} else {
		if(loginObject.value.match(/^[0-9a-zA-Zа-яА-Я_-]+$/)) {
			return "ok";
		} else {
			$(loginObject).notify("Цифры, буквы, знак«_»",{autoHideDelay : 1300});
			return false;
		}
	}
}
//************************************************************************************
function __ff_check_register(fObjs, byKey){
	if(!byKey || byKey=="undefined") byKey = "";
	if(__ff_check_login(document.getElementById(fObjs.login.id), byKey)!="ok") {
		return false;
	}
	if(document.getElementById(fObjs.password.id).value=="") {
		$("#"+fObjs.password.id).notify("Введите пароль",{autoHideDelay : 1300});
		return false;
	}
	var paction = "ajax=checkuser";
	paction += "&reg_login="+document.getElementById(fObjs.login.id).value;
	paction += "&reg_pass="+document.getElementById(fObjs.password.id).value;
	preloaderInit={  target:{ "qwert":"dsa"  }  };
	__preloader_open(preloaderInit);
	keyUpControls["test_win"]["pause"] = "pause";
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: paction,
		success: function(html) {
			//alert(html);
			__preloader_closeAllPreloaders();
			if(html=="yes") document.location.href = document.location.href;
			else aAlert("Неверный логин/пароль", "delete keyUpControls['test_win']['pause']");
		}
	});
	//alert(paction);
}
//************************************************************************************
var keyUpControls = {};
window.onkeyup=function(emo){
	for( kc in keyUpControls){
		for( jc in keyUpControls[kc]){
			if( jc == emo.keyCode ){
				if(!keyUpControls[kc]["pause"]){
					keyUpControls[kc][jc]();
				}
			}
		}
	}
};
//************************************************************************************
function __ff_check_email(email){
	if(email.match(/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9-_.]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/))
		return true;
	else
		return false;
}
//************************************************************************************