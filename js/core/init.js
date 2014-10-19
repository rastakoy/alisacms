var __ajax_url = "__ajax.php";
var __getJSON_ajax_url = "/adminarea/__ajax_user_interface.php";
//******************************
function getJSON(gets, mycallback){
	var ajson = $.getJSON( __getJSON_ajax_url, gets );
	ajson.done(function(data) {
		//alert("data="+data);
		if(data != "undefined"){
			if(mycallback) {
				if(mycallback=="stringify"){
					alert(JSON.stringify(data));
				} else if(mycallback=="return") {
					//eval(mycallback+"(data)");
				} else if(mycallback=="reload") {
					document.location.href = document.location.href;
				} else {
					eval(mycallback+"(data)");
				}
			}
		} else  {
			//myGridShowDialog("Произошла ошибка", "При передаче данных возникла ошибка!<br/>"+data);
		}
    });
    ajson.fail(function(statusObj,errInfo) {
        alert(statusObj.statusText+"\n"+errInfo);
    });
}
//******************************
$(document).ready(function(){
		//alert(JSON.stringify(arrOnLoad));
		var fid = "form_0";
		var objs = $("#"+fid+" input, #"+fid+" select, #"+fid+" textarea");
		if(objs.length!=0) {
			for(var j in objs) {
				if(send_objs) {
					if(send_objs[j]) {
						if(send_objs[j][0]){
							if(send_objs[j][0]["inputProperties_type"] == "Дата")  {
								$(objs[j]).datepicker();
							}
							if(send_objs[j][0]["inputProperties_type"] == "Автозаполнение")  {
								//alert(send_objs[j][0]["connectionField"]);
								//alert(JSON.stringify(send_objs));
								__ff_input_autocomplit(objs[j], send_objs[j][0]["connectionField"]);
							}
							if(send_objs[j][0]["content"] != "" && send_objs[j][0]["type"] != "submit"){
								//alert(send_objs[j][0]["content"]);
								//alert(JSON.stringify(send_objs[j][0]));
								send_objs[j][0]["type"];
								$(objs[j]).each(function() {
									var default_value = send_objs[j][0]["content"];
									$(this).css('color', '#555'); // this could be in the style sheet instead
									$(this).focus(function() {
										if(this.value == default_value) {
											this.value = "";
											$(this).css('color', '');
										}
									});
									$(this).focusout(function() {
										if(this.value == default_value || this.value == "") {
											this.value = default_value;
											$(this).css('color', '#555');
										}
									});
								});
							}
						}
					}
				}
			}
		}
		//************************************************************************************
		jQuery(function($){
		$.datepicker.regional['ru'] = {
			closeText: 'Закрыть',
			prevText: '&#x3C;Пред',
			nextText: 'След&#x3E;',
			currentText: 'Сегодня',
			monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
			'Июл','Авг','Сен','Окт','Ноя','Дек'],
			dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
			dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
			dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
			weekHeader: 'Нед',
			dateFormat: 'dd.mm.yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''};
			$.datepicker.setDefaults($.datepicker.regional['ru']);
		});
		//************************************************************************************
		//if(document.getElementById("userfile")){
		//	var uploader = new qq.FileUploader({
		//		// pass the dom node (ex. $(selector)[0] for jQuery users)
		//		element: document.getElementById("userfile"),
		//		action: 'upload_files.php',
		//		params: {parent: 123},
		//		onComplete: function(id, fileName, responseJSON){
		//			alert(id, fileName, responseJSON);
		//		}
		//	});
		//}
		//************************************************************************************
		$("#miniadmin").click(function(){
			ppdata = "paction=chui&ui=1";
			$.ajax({
				type: "POST",
				url: alisa_link,
				data: ppdata,
				success: function(html) {
					document.location.href= document.location.href;
				}
			});	
		});
		//************************************************************************************
});