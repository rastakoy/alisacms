var mm_height = 0;
var mmOpenClick = false;
$(document).ready(function(){
	if(typeof __vipmenuItems != "undefined"){
		//alert(JSON.stringify(__vipmenuItems));
		for(var j in __vipmenuItems){
			document.getElementById(__vipmenuItems[j].target).target = __vipmenuItems[j].target;
			document.getElementById(__vipmenuItems[j].target).container = __vipmenuItems[j].container;
			document.getElementById(__vipmenuItems[j].target).subContainer = __vipmenuItems[j].subContainer;
			document.getElementById(__vipmenuItems[j].target).posleft = __vipmenuItems[j].left;
			document.getElementById(__vipmenuItems[j].target).mm_steps = 15;
			document.getElementById(__vipmenuItems[j].target).mm_interval = 15;
			document.getElementById(__vipmenuItems[j].target).mm_pos = 0;
			document.getElementById(__vipmenuItems[j].target).mm_height = 0;
			document.getElementById(__vipmenuItems[j].target).mm_speed = 0;
			document.getElementById(__vipmenuItems[j].target).mm_md = false;
			document.getElementById(__vipmenuItems[j].target).mm_mu = false;
			document.getElementById(__vipmenuItems[j].target).mm_tout=false;
			document.getElementById(__vipmenuItems[j].target).mmOpenClick=false;
			document.getElementById(__vipmenuItems[j].target).status = "hide";
			//******************************
			document.getElementById(__vipmenuItems[j].target).show_menu = function(){
				this.status = "show";
				for(var j in __vipmenuItems)		document.getElementById(__vipmenuItems[j].container).style.zIndex = 100;
				document.getElementById(this.container).style.zIndex = 101;
				//alert(document.getElementById(this.container).style.zIndex);
				document.getElementById(this.container).style.display = "block";
				this.mm_height = document.getElementById(this.subContainer).clientHeight+6;
				//p = $( "#"+this.target );
				//p = __positions_getAbsolutePos(document.getElementById(this.target));
				//posso = p.position();
				pos = 0;
				//document.title =  posso.x*1+"::"+this.posleft*1;
				document.getElementById(this.container).style.left = pos*1+this.posleft*1;
				this.mm_pos = - (this.mm_height);
				this.mm_md = true;
				this.mm_speed = this.mm_height / this.mm_steps;
				//****************************
				this.move_menu_down();
			}
			//******************************
			document.getElementById(__vipmenuItems[j].target).move_menu_down = function(){
				if(this.mm_md && !this.mm_mu){
					//alert(this.mm_pos);
					if(this.mm_tout) clearInterval(this.mm_tout);
					//document.title = this.mm_pos;
					if(this.mm_pos >= 0) {
						$("#"+this.container).css("overflow", "");
						$("#"+this.subContainer).css("margin-top", "0px");
						//$("#vipdiv").css("height", mm_height+"px");
						this.mm_md = false;
						this.mm_pos = 0;
						//document.title = "ok";
					} else {
						$("#"+this.container).css("height", (this.mm_height+this.mm_pos)+"px");
						$("#"+this.subContainer).css("margin-top", this.mm_pos+"px");
						this.mm_pos += this.mm_speed;
						//alert(this.mm_pos);
						this.mm_tout = setTimeout("document.getElementById('"+this.target+"').move_menu_down()", this.mm_interval);
					}
				}
			}
			//******************************
			document.getElementById(__vipmenuItems[j].target).hide_menu = function(){
				this.status = "hide";
				this.mm_mu = true;
				$("#"+this.container).css("overflow", "hidden");
				this.move_menu_up();
			}
			//******************************
			document.getElementById(__vipmenuItems[j].target).move_menu_up = function(){
				if(this.mm_mu){
					if(this.mm_tout) clearInterval(this.mm_tout);
					//alert(mm_pos+"::"+mm_height);
					if(this.mm_pos < -this.mm_height) {
						$("#"+this.container).css("height", this.mm_height+"px");
						$("#"+this.container).css("display", "");
						this.mm_mu = false;
						this.mm_pos = -this.mm_height;
					} else {
						this.mm_pos -= this.mm_speed;
						$("#"+this.container).css("height", (this.mm_height+this.mm_pos)+"px");
						$("#"+this.subContainer).css("margin-top", this.mm_pos+"px");
						this.mm_tout = setTimeout("document.getElementById('"+this.target+"').move_menu_up()", this.mm_interval);
					}
				}
			}
			//******************************
			//document.getElementById(__vipmenuItems[j].target).onmouseover = function(){
			//	//if(!this.mm_mu)
			//		this.show_menu();
			//}
			//******************************
			//document.getElementById(__vipmenuItems[j].target).onmouseout = function(){
			//	//if(!this.mm_md)
			//	//this.mm_md = false;
			//		this.hide_menu();
			//}
			//******************************
			if( __vipmenuItems[j].event.event.match(/over/) ){
				$("#"+__vipmenuItems[j].target).hover(function() {
					this.show_menu();
				}, function() {
					this.hide_menu();
				});
			}
			//******************************
			if( __vipmenuItems[j].event.event.match(/click/) ){
				//alert("click "+JSON.stringify(__vipmenuItems[j]));
				var vtarg = "";
				if( __vipmenuItems[j].event.targetId ){
					document.getElementById(__vipmenuItems[j].event.targetId).onclick = function() {
						if( this.parentNode.mmOpenClick ){
							this.parentNode.hide_menu();
							this.parentNode.mmOpenClick = false;
						} else {
							this.parentNode.show_menu();
							this.parentNode.mmOpenClick = true;
						}
					}
				} else{
					document.getElementById(__vipmenuItems[j].target).onclick = function() {
						if( this.mmOpenClick ){
							 this.hide_menu();
							 this.mmOpenClick = false;
						} else {
							this.show_menu();
							this.mmOpenClick = true;
						}
					}
				}
			}
			//******************************
		//******************************
		//	//******************************
		//	vpmobjw = document.getElementById(__vipmenuItems[j].target);
		//	//vpmobjw.target = target;
		//	vpmobjw.mm_steps = 15;
		//	vpmobjw.mm_interval = 15;
		//	vpmobjw.mm_pos = 0;
		//	vpmobjw.mm_height = 0;
		//	vpmobjw.mm_speed = 0;
		//	vpmobjw.mm_md = false;
		//	vpmobjw.mm_mu = false;
		//	vpmobjw.mm_tout=false;
		//	//****************************
		//	container = __vipmenuItems[j].container;
		//	subContainer = __vipmenuItems[j].subContainer;
		//	//****************************
		//	vpmobjw.myelem = container;
		//	myobj = document.getElementById(vpmobjw.myelem).parentNode;
		//	//$(vpmobjw.obj).css("width", (vpmobjw.obj.offsetWidth-41)+"px");
		//	$("#"+vpmobjw.myelem).css("display", "block");
		//	//$("#"+vpmobjw.myelem).css("top", "60px");
		//	vpmobjw.objh = document.getElementById(subContainer);
		//	vpmobjw.mm_height = vpmobjw.objh.clientHeight+6;
		//	//$(vpmobjw.objh).css("margin-top", -myobj.clientHeight+"px");
		//	//$(vpmobjw.objh).css("margin-top", "300px");
		//	vpmobjw.mm_pos = -vpmobjw.mm_height;
		//	vpmobjw.mm_md = true;
		//	vpmobjw.mm_speed = vpmobjw.mm_height / vpmobjw.mm_steps;
		//	//****************************
		//	vpmobjw.move_menu_down = function(){
		//		//alert(vpmobjw.id);
		//		if(vpmobjw.mm_md){
		//			if(vpmobjw.mm_tout) clearInterval(vpmobjw.mm_tout);
		//			if(vpmobjw.mm_pos > 0) {
		//				$(vpmobjw.objh).css("margin-top", "0px");
		//				$(vpmobjw.myelem).css("overflow", "visible");
		//				//$("#vipdiv").css("height", mm_height+"px");
		//				mm_md = false;
		//				mm_pos = 0;
		//			} else {
		//				$(vpmobjw.myelem).css("height", (vpmobjw.mm_height+vpmobjw.mm_pos)+"px");
		//				$(vpmobjw.objh).css("margin-top", vpmobjw.mm_pos+"px");
		//				vpmobjw.mm_pos += vpmobjw.mm_speed;
		//				//alert(target.move_menu_down());
		//				vpmobjw.mm_tout = setTimeout("document.getElementById('"+__vipmenuItems[j].target+"').move_menu_down()", vpmobjw.mm_interval);
		//			}
		//		}
		//	}
		//	//****************************
		//	vpmobjw.move_menu_down();
		//	//****************************
		//	
		//	
		//	vpmobjw.show_menu = function (vpmobjw, container, subContainer, target ){
		//		//alert(this.id);
		//		//var vpmobjw = vpmobjw;
		//		//alert(vpmobjw.id);
		//		//******************************
		//		vpmobjw.hide_menu = function(){
		//			vpmobjw.mm_mu = true;
		//			$(vpmobjw.myelem).css("overflow", "hidden");
		//			//vpmobjw.move_menu_up();
		//		}
		//		//****************************
		//		vpmobjw.move_menu_up = function(){
		//			if(vpmobjw.mm_mu){
		//				if(vpmobjw.mm_tout) clearInterval(vpmobjw.mm_tout);
		//				//alert(mm_pos+"::"+mm_height);
		//				if(vpmobjw.mm_pos < -vpmobjw.mm_height) {
		//					$("#vipdiv").css("height", vpmobjw.mm_height+"px");
		//					$("#vipdiv").css("display", "");
		//					vpmobjw.mm_mu = false;
		//					vpmobjw.mm_pos = -vpmobjw.mm_height;
		//				} else {
		//					vpmobjw.mm_pos -= vpmobjw.mm_speed;
		//					$("#vipdiv").css("height", (vpmobjw.mm_height+vpmobjw.mm_pos)+"px");
		//					$("#vipimg").css("margin-top", vpmobjw.mm_pos+"px");
		//					vpmobjw.mm_tout = setTimeout("document.getElementById('"+vpmobjw.target+"').move_menu_up()", vpmobjw.mm_interval);
		//				}
		//			}
		//		}
		//		//****************************
		//		
		//		//****************************
		//		
		//	}
		//	//********************************
		//	//$("#"+__vipmenuItems[j].target).hover(function() {
		//		//$("#vipdiv").css("display", "block");
		//	vpmobjw.onmouseover = function(){
		//		//alert("over");
		//		vpmobjw.show_menu(this, __vipmenuItems[j].container, __vipmenuItems[j].subContainer, __vipmenuItems[j].target);
		//	}
		//	//}, function() {
		//	//	//$("#vipdiv").css("display", "none");
		//	//	vpmobjw.hide_menu();
		//	//	//$("#vipdiv").css("display", "none");
		//	//});
		}
	}
	//$(".hmkatalog").hover(function() {
	//	//$("#vipdiv").css("display", "block");
	//	show_menu(vpmobjw, "vipdiv", "vipimg", "hmkatalog");
	//}, function() {
	//	//$("#vipdiv").css("display", "none");
	//	vpmobjw.hide_menu();
	//	//$("#vipdiv").css("display", "none");
	//});
	//$("#vipimg li").hover(function() {
	//	//vpmobjw.className = "vip_preloader";
	//	omass = vpmobjw.getElementsByTagName("a");
	//	//alert(omass.length);
	//	if(omass.length>1){
	//		posa = __positions_getAbsolutePos(vpmobjw);
	//		$(".sub_vipdiv").css("top", -22+"px");
	//		$(".sub_vipdiv").css("left", (175)+"px");
	//		$("#"+vpmobjw.id+" .sub_vipdiv").fadeIn(200);
	//	}
	//	//$("#vipdiv").css("display", "block");
	//	//show_menu(vpmobjw);
	//}, function() {
	//	vpmobjw.className = "";
	//	$("#"+vpmobjw.id+" .sub_vipdiv").fadeOut(100);
	//	$("#sub_vipdiv").css("display", "none");
	//	//$("#vipdiv").css("display", "none");
	//	//hide_menu(vpmobjw);
	//	//$("#vipdiv").css("display", "none");
	//});
});

//******************************