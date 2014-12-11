function open_messanger(){
	var fast_cont_html = "tester";
	//*******************************
	a_obj = document.documentElement.getElementsByTagName('body')[0];
	wwidth = a_obj.scrollWidth;
	wheight = a_obj.scrollHeight;
	wwwidth = document.body.clientWidth;
	wwheight = document.body.clientHeight;
	//*******************************
	obj_m = document.getElementById("show_myitemblock_bg");
	obj_m.style.width = wwidth+"px";
	obj_m.style.height = wheight+"px";
	obj_m.style.display="";
	//*******************************
	obj_w = document.getElementById("show_myitemblock_cont");
	obj_w.innerHTML = "";
	obj_w.style.width = (wwidth-100)+"px";
	obj_w.style.height = (wwheight - 100)+"px";
	obj_w.style.top = (20+document.body.scrollTop)+"px";
	obj_w.style.left = (wwwidth/2-(wwidth-100)/2)+"px";
	obj_w.style.display="";
	//*******************************
	//<a href=\"javascript:start_insert_img()\" class=\"inc_tadiv_saver_imgs\">Тест</a>
	//document.getElementById("inc_tadiv_imgs").style.height = (wwheight-100-60+10)+"px";
	//tmce_width = wwidth-100-180;
	//tmce_height = wwheight-100-60;
	//tinymce_init();
	//document.getElementById("inc_tadiv").style.width = (wwidth-100-180)+"px";
	//*******************************
	ppdata = "paction=get_messanger_data";
	//alert(ppdata);
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: ppdata,
		success: function(html) {
			var inner = "<h1>Менеджер рассылки</h1>";
			inner += html +"<div align=\"center\" style=\"margin-top: 10px;\">";
			inner += "<a href=\"javascript:start_messanger()\" class=\"inc_tadiv_saver_imgs\">Рассылка</a>";
			inner += "<a id=\"drophere\" href=\"javascript:close_messanger()\" class=\"inc_tadiv_saver_imgs\">Отменить</a></div>";
			obj_w.innerHTML = inner;
			//alert(html);
			//obj_m.style.display="none";
			//obj_w.style.display="none";
		}
	});
}
//*************************************
function start_messanger(){
	obj = document.getElementById("selectMessanger");
	if(obj.value==""){
		alert("Выберите тему расслки");
	}else{
		//alert("Рассылка будет производиться по ID " + obj.value);
		ppdata = "paction=start_messanger&pid=" + obj.value;
		alert(ppdata);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: ppdata,
			success: function(html) {
				var inner = "<h1>Рассылка произведена</h1>";
				obj_w.innerHTML = inner;
				setTimeout("close_messanger()", 1000);
				//inner += html +"<div align=\"center\" style=\"margin-top: 10px;\">";
				//inner += "<a href=\"javascript:start_messanger()\" class=\"inc_tadiv_saver_imgs\">Рассылка</a>";
				//inner += "<a id=\"drophere\" href=\"javascript:close_messanger()\" class=\"inc_tadiv_saver_imgs\">Отменить</a></div>";
				
				//alert(html);
				//obj_m.style.display="none";
				//obj_w.style.display="none";
			}
		});
	}
}
//*************************************
function close_messanger(){
	obj_m.style.display="none";
	obj_w.style.display="none";
}
//*************************************