//onCloseTest:function(f){var g=this;g.editor=f;g.onOpen=new a(g);g.onClose=new a(g);g.params={};g.features={}}


var cur_el = false;
var mousemove_bg_prev  = false;
var mm_start = false;
document.onmousemove = function(em) {
  if(mm_start) {
	  em = em || event;
	   var o = em.target || em.srcElement;
	   if(em.y) { 
			cur_my = em.y;  
			cur_mx = em.x; 
			
		} else { 
			if(document.body){
				cur_my = em.pageY - document.body.scrollTop;  
				cur_mx = em.pageX - document.body.scrollLeft;
			}
		}
		if(document.body){
			mmx = cur_mx+ document.body.scrollLeft;
			mmy = cur_my+document.body.scrollTop;
		}
	   //document.title = "x="+cur_mx+"::y="+cur_my;
	   //document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
	   //document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
	   cur_el = o;
	   if(mousemove_bg_prev){
				mousemove_bg_prev = false;
				$("#start_ui").css("display", "");
				$("#black_bg").css("display", "");
				document.title="moving "+crt;
				crt++;
			}
  }
  mm_start = true;
}
//**
document.onmouseup = function(e) {
	e = e || event;
	var o = e.target || e.srcElement;
	//document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
	if(close_sort || cur_el.id=="asort") {
		show_asort();
	}
	if(cur_el.id=="showtypes_1") {
		 showtypepost(1);
	}
	if(cur_el.id=="showtypes_2") {
		showtypepost(2);
	}
}

//*********************************
var close_sort=false;
function show_asort(){
	//alert("ok");
	ds_el = document.getElementById("div_sort_items");
	if(ds_el.style.display == ""){
		ds_el.style.display = "none";
		close_sort=false;
	} else {
		pos_el = document.getElementById("asort");
		as_pos = __images_getAbsolutePos(pos_el);
		ds_el.style.left=(as_pos.x-10)+"px";
		ds_el.style.top=(as_pos.y+20)+"px";
		ds_el.style.display = "";
		close_sort=true;
	}
}
//*********************************
var news_interval;
var bgcount=1;
var bgcountmax=7;
//*********************************
//fadeOpacity.addRule('oR1', .0, 1, 20);
//if (bro_ie)	{
//	fadeOpacity.addRule('oR1', .0, 1);
//}
//*********************************
function change_himg(){
	bgcount++;
	if(bgcount==bgcountmax) bgcount=1;
	fadeOpacity.back("chimg");
	//setInterval('change_himg()' , 10000);
}
//*********************************
//fadeOpacity("chimg", 'oR1');
//setTimeout('change_himg()', 6000);