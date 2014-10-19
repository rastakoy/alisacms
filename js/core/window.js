//***************************************
//   ѕараметры
//   id: вписываем_id Ч (text) устанавливает окну атрибут id
//   modal: true/false Ч (bool) €вл€етс€ ли окно модальным
//   width: вписываем_ширину Ч (int) €вл€етс€ ли окно модальным
//   height: вписываем_высотуЧ (int) €вл€етс€ ли окно модальным
	  //*******************
//   Cобыти€/events
//   onClose:{...code...} Ч срабатывает при закрытии окна, если не задано, то устанавливает окну display:none
//   onFullScreen:{...code...} Ч срабатывает при смене размера окна
//***************************************
function __win_openWindow(winInit){
	//**********************************
	__winBoxObject = document.getElementById(winInit.id);
	//var mzIndex = getMaxZIndex();
	mzIndex=1000;
	if(!mzIndex) mzIndex=1000;
	//alert(mzIndex);
	if(!__winBoxObject) {
		var __winBoxObject = document.createElement("DIV");
		document.body.appendChild(__winBoxObject);
	}
	__winBoxObject.id = winInit.id;
	///***************************************
	if(winInit.modal){
		__winBgObject = document.getElementById(winInit.id+"_bg");
		if(!__winBgObject) {
			var __winBgObject = document.createElement("DIV");
			document.body.appendChild(__winBgObject);
		}
		__winBgObject.style.display="";
		__winBgObject.className = "__winBgObject-class";
		__winBgObject.id = winInit.id+"_bg";
		__winBgObject.style.zIndex = mzIndex*1+ 1;
		__winBgObject.innerHTML = "";
	}
	///***************************************
	if(winInit.after){
		__winAfterObject = document.getElementById(winInit.id+"_after");
		if(!__winAfterObject) {
			var __winAfterObject = document.createElement("DIV");
			document.body.appendChild(__winAfterObject);
		}
		__winAfterObject.style.display="";
		__winAfterObject.className = "__winAfterObject-class";
		__winAfterObject.id = winInit.id+"_after";
		__winAfterObject.style.zIndex = mzIndex*1 + 2;
		__winAfterObject.innerHTML = winInit.after.html;
	}
	///***************************************
	if(winInit.scrolling){
		//__winBoxObject.onmousewheel = __winBoxObject.onwheel = function() {
		//	document.title = cur_el.tagName;
		//};
		document.onmousewheel = document.onwheel = function() {
			//if(asdasd)
			//document.title = cur_el.tagName;
			//return false;
		};
		//scObj = document.getElementById(winInit.scrolling);
		//scObj.onmousewheel = scObj.onwheel = function() {
		//	return false;
		//};
	}
	///***************************************
	//$(".aui_control_block").css("z-index", "");
	//var rv = "";
	//myblock = document.getElementById(bid);
	//myblock.className = "aui_control_block";
	//rv += "<div class=\"aui_control_block_move\" style=\"width:"+(bcss.width-40)+"px\"></div>";
	//rv += "<span class=\"aui-icon-fullscreen fscreen\"></span>";
	//rv += "<span class=\"aui-icon-remove-circle close\"></span>";
	//rv += "<div class=\"aui_control_block_title\">"+btitle+"</div>";
	//rv += "<div class=\"aui_control_block_tabs\" style=\"display:none;\"></div>";
	//rv += "<div class=\"aui_control_block_buttons\"></div>";
	//rv += "<div class=\"aui_control_block_separator\"></div>";
	//rv += "<div class=\"aui_control_block_content\">"+bcontent+"</div>";
	//rv += "<div class=\"aui_control_block_content_dop\" style=\"display:none\"><div style=\"display:none\">test 1</div><div style=\"display:none\">test 2</div><div style=\"display:none\">test 3</div></div>";
	//rv += "<div class=\"aui_control_block_content_preview\" style=\"display:none;\">"+bcontent+"</div>";
	//rv += "<div class=\"aui_control_block_content_preview_sep\" style=\"display:none;\"></div>";
	//rv += "<div class=\"aui_control_block_separator\" style=\"margin-bottom:5px;\"></div>";
	//rv += "<div align=\"center\">";
	//rv += "<span class=\"aui_control_block_button cancel\">ќтмена</span>";
	//rv += "<span class=\"aui_control_block_button ok\">ќк</span>";
	//rv += "</div>";
	//rv += "<div style=\"margin-bottom:10px;float:none;clear:both;\"></div>";
	//$(myblock).css("display","");
	//$(myblock).css(bcss);
	//$(myblock).empty();
	//$(myblock).append(rv);
	//if(bid=="aui_Confirm"){
	//	$(myblock).css("left", document.body.clientWidth/2 - bcss.width/2 );
	//	$(myblock).css("top", document.body.clientHeight/3 - myblock.clientHeight/2 );
	//} else {
	//	if(getCookie("panel_"+bid+"_y"))  $(myblock).css("top", getCookie("panel_"+bid+"_y") );
	//	if(getCookie("panel_"+bid+"_x"))  $(myblock).css("left", getCookie("panel_"+bid+"_x") );
	//}
	//$( myblock ).draggable({ 
	//	handle: ".aui_control_block_move" ,
	//	start: function( event, ui ) {
	//		//alert("start");
	//	},
	//	stop: function( event, ui ) {
	//		m = __positions_getAbsolutePos(this);
	//		setCookie("panel_"+bid+"_x", m.x, "", "/");
	//		setCookie("panel_"+bid+"_y", m.y, "", "/");
	//	}
	//});
	//if(modal){
	//	$("#"+modal).css("display", "");
	//	$("#"+modal).css("position", "fixed");
	//	$("#"+modal).css("width", document.body.clientWidth);
	//	$("#"+modal).css("height", document.body.clientHeight);
	//}
	//$("#"+bid+" span.aui-icon-remove-circle").click(function (){
	//	$("#"+bid).css("display","none");
	//	$("#"+bid).css("z-index","none");
	//	$("#"+modal).css("display", "none");
	//	eval(callback);
	//});
	//$("#"+bid+" span.cancel").click(function (){
	//	$("#"+bid).css("display","none");
	//	$("#"+bid).css("z-index","none");
	//	$("#"+modal).css("display", "none");
	//	eval(callback);
	//});
	//$(myblock).mousedown(function(){
	//	$(".aui_control_block").css("z-index", "10");
	//	$(this).css("z-index","50");
	//})
		if(!winInit.css.width) winInit.css.width = 200;
		if(!winInit.css.height) winInit.css.height = 150;
		//**********************************
		//__winBoxObject = document.getElementById(winInit.id);
		//if(!__winBoxObject) {
		//	var __winBoxObject = document.createElement("DIV");
		//	document.body.appendChild(__winBoxObject);
		//}
		//**********************************
		__winBoxObject.style.display="";
		__winBoxObject.className = "__winBoxObject-class";
		__winBoxObject.style.zIndex = mzIndex*1 + 10;
		
		__winBoxObject.style.left = ((window.innerWidth-winInit.css.width) / 2) + "px";
		__winBoxObject.style.width = winInit.css.width + "px";
		
		if(winInit.css.height)
			__winBoxObject.style.height = winInit.css.height + "px";
		else
			__winBoxObject.style.height = (window.innerHeight-60) + "px";
		
		__winBoxObject.style.top = ((window.innerHeight-(window.innerHeight-60)) / 2)+"px";

		//Ѕлок after Ч left, top, width, height
		if(winInit.after){  
			__winAfterObject.style.top = ((window.innerHeight-(window.innerHeight-60)) / 2 + __winBoxObject.clientHeight - 10)+"px";
			__winAfterObject.style.left = ((window.innerWidth-__winBoxObject.clientWidth) / 2 +20)+"px";
			__winAfterObject.style.width = (__winBoxObject.clientWidth - 20)+"px";
		}
		
		inner = "<div class=\"__winBoxObject-move\" style=\"width:"+(winInit.css.width-40)+"px;\"></div>";
		inner += "<span class=\"aui-icon-fullscreen fscreen\"></span>";
		inner += "<span id=\""+winInit.id+"-close\" class=\"aui-icon-remove-circle close\"></span>";
		//inner = "<div id=\"__winBoxObject-topClose\"></div>";
		inner += "<div class=\"__winBoxObject-title\">"+winInit.title+"</div>";
		__winBoxObject.setTitle = function(mtitle){
			this.getElementsByClassName("__winBoxObject-title")[0].innerHTML = mtitle;
		}
		inner += "<div class=\"__winBoxObject-body\"></div>";
		
		if(winInit.buttons){
			inner += "<div class=\"__winBoxObject-buttons\" align=\"center\" >";
			inner += "<div style=\"width:200px;background-color:#FFCC33;\">";
			for( wbc in winInit.buttons){
				if(wbc == "wOk")
					inner += "<a id=\""+winInit.id+"_wOk\" class=\"__winBoxObject-button\">Ok</a>";
				if(wbc == "wCancel")
					inner += "<a id=\""+winInit.id+"_wCancel\" class=\"__winBoxObject-button\">ќтмена</a>";
				if(wbc == "wYes")
					inner += "<a id=\""+winInit.id+"_wYes\" class=\"__winBoxObject-button\">ƒа</a>";
				if(wbc == "wNo")
					inner += "<a id=\""+winInit.id+"_wNo\" class=\"__winBoxObject-button\">Ќет</a>";
				if(wbc == "wSave")
					inner += "<a id=\""+winInit.id+"_wSave\" class=\"__winBoxObject-button\">—охранить</a>";
				if(wbc == "wEnter")
					inner += "<a id=\""+winInit.id+"_wEnter\" class=\"__winBoxObject-button\">¬ойти</a>";
				if(wbc == "wRegister")
					inner += "<a id=\""+winInit.id+"_wRegister\" style=\"width:90px;\" class=\"__winBoxObject-button\">–егистраци€</a>";
			}
			inner += "</div><div style=\"float:none;clear:both;\"></div></div>";
		}
		__winBoxObject.innerHTML = inner;
		//***********************************
		$( __winBoxObject ).draggable({ 
			handle: ".__winBoxObject-move" ,
			start: function( event, ui ) {
				//alert("start");
			},
			stop: function( event, ui ) {
				m = __positions_getAbsolutePos(this);
				if(winInit.rememberPosition){
					setCookie(__winBoxObject.id+"_x", m.x, "", "/");
					setCookie(__winBoxObject.id+"_y", m.y, "", "/");
				}
			}
		});
		//***********************************
		if(winInit.onClose){
			__winBoxObject.children[2].onclick = winInit.onClose;
		} else {
			__winBoxObject.children[2].onclick = function(){
				if(winInit.modal) __winBgObject.style.display = "none";
				if(winInit.after) __winAfterObject.style.display="none";
				__winBoxObject.style.display = "none";
				__preloader_closeAllPreloaders();
				if(keyUpControls[__winBoxObject.id]) delete keyUpControls[__winBoxObject.id];
				if(winInit.scrolling == true){
					document.body.onmousewheel = document.body.onwheel = false;
				}
			}
		}
		//***********************************
		__winBoxObject.children[1].onclick = function(){
			//if(winInit.resizeable){
				var __winBoxObject = this.parentNode;
				tabscs = document.getElementById(winInit.id).getElementsByClassName("__winBoxObject-content");
				//__winBoxObject.createIcons();
				//*********************************************
				__winIconsObj = document.getElementById(__winBoxObject.id+"_icons");
				//var wIconObject = document.getElementById(__winBoxObject.id+"_icons");
				//if(!wIconObject){
				//	wIconObject = document.createElement("DIV");
				//	__winBoxObject.appendChild(wIconObject);
				//	wIconObject.className = "__winBoxObject-icons";
				//	wIconObject.style.display = "";
				//}
				//*********************************************
				if(__winBoxObject.fullscreen){
					//alert(__winBoxObject.fullScreen);
					__winBoxObject.fullscreen = 0;
					__winBoxObject.children[0].style.width = (__winBoxObject.fsWidth - 40)+"px";
					__winBoxObject.style.height = __winBoxObject.fsHeight;
					//__winBoxObject.style.top = ((window.innerHeight-(window.innerHeight-60)) / 2)+"px";
					if(winInit.rememberPosition){
						__winBoxObject.style.top = getCookie(__winBoxObject.id+"_y")+"px";
						__winBoxObject.style.left = getCookie(__winBoxObject.id+"_x")+"px";
					}
					//__winBoxObject.style.left = ((window.innerWidth-__winBoxObject.clientWidth) / 2) + "px";
					
					__winBoxObject.style.width = __winBoxObject.fsWidth;
					for(jtbs=0; jtbs<tabscs.length; jtbs++){
						tabscs[jtbs].style.height = (__winBoxObject.fsHeight-105)+"px";
						if(tabscs.length == 1) tabscs[jtbs].style.height = (__winBoxObject.fsHeight-80)+"px";
					}
					//if(__winIconsObject) {
					//	//alert(__winBoxObject.children[4].children[1].children[0].offsetHeight);
					//	fss = false;
					//	if(__winBoxObject.children[4].children[1].children[0].style.display=="none"){
					//		__winBoxObject.children[4].children[1].children[0].style.display="block";
					//		fss = true;
					//	}
					//	__winIconsObj.style.top = "-"+(__winBoxObject.children[4].children[1].children[0].offsetHeight+30)+"px";
					//	if(fss)	__winBoxObject.children[4].children[1].children[0].style.display="none";
					//}
					
				} else {
					if(winInit.resizeable){
						__winBoxObject.fullscreen = 1;
						__winBoxObject.fsWidth = __winBoxObject.clientWidth-20;
						__winBoxObject.fsHeight = __winBoxObject.clientHeight-20;
						__winBoxObject.children[0].style.width = (window.innerWidth-80-40)+"px";
						__winBoxObject.style.height = (window.innerHeight-40) + "px";
						__winBoxObject.style.top = ((window.innerHeight-(window.innerHeight-60)) / 2 - 20)+"px";
						__winBoxObject.style.width = (window.innerWidth-80) + "px";
						__winBoxObject.style.left = ((window.innerWidth-(window.innerWidth-80)) / 2 - 20)+"px";
						__winIconsObject = document.getElementById(__winBoxObject.id+"_icons");
						for(jtbs=0; jtbs<tabscs.length; jtbs++){
							tabscs[jtbs].style.height = (window.innerHeight-40-105)+"px";
							if(tabscs.length == 1) tabscs[jtbs].style.height = (window.innerHeight-40-80)+"px";
						}
						if(__winIconsObject) {
							__winBoxObject.style.left = ((window.innerWidth-(window.innerWidth-80)) / 2 )+"px";
							//alert(__winBoxObject.children[4].children[1].children[0].offsetHeight);
							fss = false;
							if(__winBoxObject.children[4].children[1].children[0].style.display=="none"){
								__winBoxObject.children[4].children[1].children[0].style.display="block";
								fss = true;
							}
							__winIconsObj.style.top = "-"+(__winBoxObject.children[4].children[1].children[0].offsetHeight+30)+"px";
							if(fss)	__winBoxObject.children[4].children[1].children[0].style.display="none";
						}
					}
				}
				if(winInit.onFullScreen) winInit.onFullScreen();
			//}
		}
		//***********************************
		__winBoxObject.fullScreen = function(myfs){
			//‘ункци€ не доделанна€. дл€ того, чтобы делать фулскрин сейчас: 
			//__winBoxObject.fullscreen = myfs;
			//__winBoxObject.children[1].onclick();
			alert(myfs);
		}
		//***********************************
		__winBoxObject.createIcons = function(icons, id){
			var ret = "";
			if(typeof icons == "object"){
				ret += "<div id=\""+id+"_iconsPanel\" style=\"display:none\">ASDFSDFS";
				
				ret += "</div>";
			}
			//alert("create icons");
			return ret;
		}
		//***************************************
		__winBoxObject.createTabsIcons = function(){
			for(var j in winInit.tabs){
				if(winInit.tabs[j]["icons"]){
					//alert(winInit.tabs[j]["icons"]);
					__winIconsObject = document.getElementById(winInit.id+"_icons");
					if(!__winIconsObject) {
						var __winIconsObject = document.createElement("DIV");
						__winBoxObject.appendChild(__winIconsObject);
					}
					__winIconsObject.id = winInit.id+"_icons";
					__winIconsObject.className = "__winBoxObject-icons";
					__winIconsObject.style.display = "";
					
					//alert(__winIconsObject.id);
					break;
				}
			}
		}
		//***********************************
		//f1 = document.getElementById('layer').getElementsByClassName('c1')
		
		//if(winInit.tabs){
		__winBoxObject.createTabs = function(myTabss){
			var myTabs = myTabss;
			//alert("creaste tabs");
			//alert(JSON.stringify(__jrc_object_HTML_tabs));
			//alert("Creator tabs: "+JSON.stringify(myTabs));
			__winBoxObject.windowTabs = myTabs;
			tabsObj = __winBoxObject.children[4];
			var tabsTitlesContainer = __winBoxObject.getElementsByClassName("__winBoxObject-tabs")[0];
			//alert( __winBoxObject.getElementsByClassName("__winBoxObject-tab").length)
			if(!tabsTitlesContainer) {
				var tabsTitlesContainer = document.createElement("DIV");
				tabsObj.appendChild(tabsTitlesContainer);
				tabsTitlesContainer.className = "__winBoxObject-tabs";
			}
			var tabsContsContainer = __winBoxObject.getElementsByClassName("__winBoxObject-contents")[0];
			if(!tabsContsContainer) {
				var tabsContsContainer = document.createElement("DIV");
				tabsObj.appendChild(tabsContsContainer);
				tabsContsContainer.className = "__winBoxObject-contents";
				if(winInit.css["background-color"]) $(tabsContsContainer).css("background-color", winInit.css["background-color"])
			}
			//alert(tabsTitlesContainer);
			//alert(tabsContsContainer);
			var arr_1 = tabsTitlesContainer.getElementsByClassName("__winBoxObject-tab");
			var arr_2 = tabsTitlesContainer.getElementsByClassName("__winBoxObject-tab-active");
			var tabsTitles = new Array()
			for (var j=0; j<arr_1.length; j++)
				tabsTitles[j]=arr_1[j];
			for (var jj=0; jj<arr_2.length; jj++)
				tabsTitles[j+jj] = arr_2[jj];
			//alert(tabsTitles.length);
			//var tabsTitles = tabsTitlesContainer.getElementsByClassName("__winBoxObject-tabs")[0];
			//tabTitles = tabsTitles.children
			//alert("tabsTitles="+tabsTitles);
			//tabsTitles = tabsTitlesContainer.getElementsByClassName("__winBoxObject-content");
			var htb = false;
			for(jj in myTabs){
				if(jj!="winBox" && jj!="removeTab") {
					htb = false;
					//tabsTitles = tabsTitlesContainer.getElementsByClassName("__winBoxObject-tabs");
					//alert("jj="+jj);
					for(var jg=0; jg<tabsTitles.length; jg++){
						if(  tabsTitles[jg].innerHTML == jj  ){
							//alert( tabsTitles[jg].innerHTML+"="+jj);
							htb = true;
						}
					}
					//alert(htb);
					if(!htb){
						var tabsTitle = document.createElement("a");
						tabsTitlesContainer.appendChild(tabsTitle);
						tabsTitle.className = "__winBoxObject-tab";
						tabsTitle.innerHTML = jj;
						
						tabsTitle.onclick = function(){
								
							__winBoxObject = document.getElementById(this.parentNode.parentNode.parentNode.id);
							__winIconsObject = document.getElementById(this.parentNode.parentNode.parentNode.id+"_icons");
							for(jjj=0; jjj<this.parentNode.parentNode.children[1].children.length; jjj++){
								//alert(this.parentNode.children[jjj].innerHTML);
								this.parentNode.children[jjj].className="__winBoxObject-tab";
								this.parentNode.parentNode.children[1].children[jjj].style.display="none";
							}
							this.parentNode.parentNode.children[1].children[$(this).index()].style.display="block";
							this.className = "__winBoxObject-tab-active";
							var icons = this.parentNode.parentNode.children[0].children[$(this).index()].icons;
							//alert();
							if(__winIconsObject){
								__winIconsObject.innerHTML = "";
								if(icons){
									for( var j in icons ) {
										var icon = document.createElement("IMG");
										__winIconsObject.appendChild(icon);
										icon.style.width = "16px";
										icon.style.height = "16px";
										icon.style.cursor = "pointer";
										icon.src = icons[j].src;
										icon.onclick = icons[j].onclick;
									}
								}
							}
								
						}
						//*********
						var tabsCont = document.createElement("span");
						tabsContsContainer.appendChild(tabsCont);
						tabsCont.className = "__winBoxObject-content";
						if(typeof myTabs[jj].content == "object")
							tabsCont.innerHTML = eval(myTabs[jj].content.key+"("+myTabs[jj].content.value+", tabsCont )");
						else
							tabsCont.innerHTML = myTabs[jj].content;
						tabsCont.id = myTabs[jj].id;
						//tabsCont.style.display = "none";
					}
				}
			}
			titlesFloater = document.getElementById(winInit.id+"_tabsfloater");
			if(!titlesFloater) {
				var titlesFloater = document.createElement("DIV");
				tabsTitlesContainer.appendChild(titlesFloater);
				titlesFloater.style.float = "none";
				titlesFloater.style.clear = "both";
			}
			
			tabs = tabsObj.children[0].getElementsByClassName("__winBoxObject-tab");
			if(tabs.length==1)  tabsObj.children[0].style.display = "none";
			tabsObj.children[1].firstChild.style.display = "block";
			tabsObj.children[0].firstChild.className = "__winBoxObject-tab-active";
			//for(var asd in myTabs)  alert(asd);
			__winBoxObject.tabs = myTabs;
			__winBoxObject.tabs.winBox = __winBoxObject;
			__winBoxObject.tabs.removeTab = function(index){
				var jc = 0;
				for( var j in this){
					//alert(j);
					if(index==jc) {
						delete this[j];
						break;
					}
					jc++;
				}
				if(this.winBox.children[4].children[0].children[jc]){
					this.winBox.children[4].children[0].children[jc].parentNode.removeChild(this.winBox.children[4].children[0].children[jc]);
					this.winBox.children[4].children[1].children[jc].parentNode.removeChild(this.winBox.children[4].children[1].children[jc]);
				}
				var no_display = true;
				//alert(this.winBox.children[4].children[0].children.length);
				for(var aj=0; aj<this.winBox.children[4].children[0].children.length; aj++){
					if(this.winBox.children[4].children[0].children[jc].style.display=="block")
						no_display = false;
				}
				if(no_display)
					this.winBox.children[4].children[0].children[0].onclick();
			}
			__winBoxObject.children[4].children[0].children[0].onclick();
			__winBoxObject.fullscreen = 1;
			__winBoxObject.children[1].onclick();
			//alert( __winBoxObject.getElementsByClassName("__winBoxObject-tab").length)
			
		}
		if(winInit.tabs){
			__winBoxObject.createTabsIcons();
			__winBoxObject.createTabs(winInit.tabs);
		}
		//***********************************
		if(winInit.buttons){
			if(winInit.buttons.wOk) document.getElementById(winInit.id+"_wOk").onclick = winInit.buttons.wOk;
			if(winInit.buttons.wCancel) document.getElementById(winInit.id+"_wCancel").onclick = winInit.buttons.wCancel;
			if(winInit.buttons.wYes) document.getElementById(winInit.id+"_wYes").onclick = winInit.buttons.wNo;
			if(winInit.buttons.wNo) document.getElementById(winInit.id+"_wNo").onclick = winInit.buttons.wNo;
			if(winInit.buttons.wSave) document.getElementById(winInit.id+"_wSave").onclick = winInit.buttons.wSave;
			if(winInit.buttons.wRegister) document.getElementById(winInit.id+"_wRegister").onclick = winInit.buttons.wRegister;
			if(winInit.buttons.wEnter) document.getElementById(winInit.id+"_wEnter").onclick = winInit.buttons.wEnter;
		}
		//***********************************
		__winBoxObject.closeWindow = function(){
			if(winInit.onClose){
				winInit.onClose();
			} else {
				if(winInit.modal) __winBgObject.style.display = "none";
				if(winInit.after) __winAfterObject.style.display="none";
				__winBoxObject.style.display = "none";
				__preloader_closeAllPreloaders();
			}
			if(keyUpControls[__winBoxObject.id]) delete keyUpControls[__winBoxObject.id];
		}
		//***********************************
		__winBoxObject.fsWidth = __winBoxObject.clientWidth-20;
		__winBoxObject.fsHeight = __winBoxObject.clientHeight-20;
		if(winInit.fullscreen==true) __winBoxObject.fullscreen = 1;
		__winBoxObject.fullscreen = !__winBoxObject.fullscreen;
		__winBoxObject.children[1].onclick();
		//***********************************
		
		//***********************************
		//__winBoxObject.addTab.winBox = __winBoxObject;
		__winBoxObject.addTab = function(addTabs){
			//alert(addTabs);
			this.children[4].children[0].children[this.children[4].children[0].children.length-1].parentNode.removeChild(this.children[4].children[0].children[this.children[4].children[0].children.length-1]);
			this.createTabs(addTabs);
		}
		//***********************************
		return __winBoxObject;
}
//**********************************
