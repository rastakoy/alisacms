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
			thisObj = document.getElementById(__vipmenuItems[j].target);
			//$("#"+thisObj.container).css("height", thisObj.mm_height+"px");
			//$("#"+thisObj.container).css("display", "");
			//thisObj.mm_mu = false;
			//thisObj.mm_pos = -this.mm_height;
			//$("#"+thisObj.subContainer).css("margin-top", "-300px");
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
						//$("#"+this.container).css("display", "");
						$("#"+this.container).css("display", "none");
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
		}
	}
});

//******************************