function click_mtm(mobj, pid){
	if(mobj.checked){
		ind = mobj.id.replace(/smlw-/gi , "");
		//ind = ind.replace(/smw-/gi , "");
		add_mtm(ind, pid);
	} else {
		ind = mobj.id.replace(/smlw-/gi , "");
		//ind = ind.replace(/smw-/gi , "");
		remove_mtm(ind, pid);
	}
}
//*********************
function add_mtm(spid, pid){
	ppdata = "paction=getfilter&addfilter="+spid+"&parid="+pid;
	//alert(ppdata);
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: ppdata,
		success: function(html) {
			ffa_off = false;
			//alert(html);
			//init_mtm_arrow();
			filter_start();
			//$("#filter_arrow").empty();
			//$("#filter_arrow").append(html);
			//$("#filter_arrow").css("display", "");
			//window.location.href = filter_folder;
			}
	});
}
//*********************
function remove_mtm(spid, pid){
	ppdata = "paction=getfilter&clearfilter="+spid+"&parid="+pid;
	//alert(ppdata);
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: ppdata,
		success: function(html) {
			$("#filter_arrow").empty();
			$("#filter_arrow").append(html);
			if(html==""){
				//$("#filter_arrow").css("display", "none");
			}
			filter_start();
			//alert(html);
			//window.location.href = filter_folder;
		}
	});
}
//***************************************
function clear_filter(){
		ppdata = "paction=getfilter&filter_clear=1";
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				window.location.href = filter_folder;
			}
		});
}
//***************************************
function init_mtm_arrow(){
	obj_mtm_fc = document.getElementById("filter_cont");
	$("#filter_arrow").css("position", "absolute");
	obj_mtm_fc.onmousemove = function(em) {
		em = em || event;
		var o = em.target || em.srcElement;
		if(em.y) { 
			cur_my = em.y;  
			cur_mx = em.x; 
		} else { 
			cur_my = em.pageY - document.body.scrollTop;  
			cur_mx = em.pageX - document.body.scrollLeft; 
		}
		ammx = cur_mx+ document.body.scrollLeft;
		ammy = cur_my+document.body.scrollTop;//-document.getElementById("filter_cont").scrollHeight;
		$("#filter_arrow").css("top", ammy-20);
		pos = __positions_getAbsolutePos(obj_mtm_fc);
		wwwidth = document.body.clientWidth;
		//$("#filter_arrow").css("left", wwwidth/2-300);
		$("#filter_arrow").css("left", 160);
	}
	//***********
	$("#filter_arrow").hide();
	$("#filter_cont").hover(function() {
		//if(document.getElementById("filter_arrow").innerHTML!="") 
			$("#filter_arrow").fadeIn();
	}, function() {
		$("#filter_arrow").fadeOut();
	});
	//***********
	ffa_off=false;
	if(ffa_off){
		$("#filter_arrow").fadeIn();
	}
	//$("#filter_arrow").css("top", mmy-140);
	//pos = __positions_getAbsolutePos(obj_mtm_fc);
	//wwwidth = document.body.clientWidth;
	//$("#filter_arrow").css("left", wwwidth/2-300);
	//$("#filter_arrow").css("left", 200);
	$("#filter_arrow").css("display", "");
	ffa_off=true;
	//alert("arrow_init");
}
//***************************************
function filter_start(){
		ppdata = "paction=getfilter&filter_start=1&filter_itemid="+filter_itemid+"&parid="+filter_parid+"&pid="+activate_filter;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				//alert(html);
				window.location.href = filter_folder;
			}
		});
}
//***************************************
var mymin  = "";
var mymax = "";
var valmin = "";
var valmax = "";
var valreload = "0";
function get_price_ranges(){
		ppdata  =  "paction=getfilter_price_ranges&filter_itemid="+filter_itemid;
		ppdata  +=  "&valmin="+valmin+"&valmax="+valmax+"&valreload="+valreload;
		//alert(ppdata);
		$.ajax({
			type: "POST",
			url: "__ajax.php",
			data: ppdata,
			success: function(html) {
				valreload = "0";
				//alert(html);
				eval(html);
					$(function() {
						$( "#slider-range" ).slider({
						  range: true,
						  min: Math.round(mymin)-1,
						  max: Math.round(mymax)+1,
						  values: myvalues,
						  slide: function( event, ui ) {
							$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
						  },
						  stop: function( event, ui ) {
							valmin = $( "#slider-range" ).slider( "values", 0 );
							valmax = $( "#slider-range" ).slider( "values", 1 );
							valreload = "1";
							get_price_ranges();
							//alert("min="+$( "#slider-range" ).slider( "values", 0 ));
							//alert("max="+$( "#slider-range" ).slider( "values", 1 ));
						  }
						});
						$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
						  " - $" + $( "#slider-range" ).slider( "values", 1 ) );
					});
			}
		});
}
//***************************************
function start_mtm_filter(){
	//******************************
	ppdata  =  "paction=getfilter&filter_itemid="+filter_itemid;
	ppdata += "&parid="+filter_parid+"&filter_show=1";
	//alert(ppdata);
	$.ajax({
		type: "POST",
		url: "__ajax.php",
		data: ppdata,
		success: function(html) {
			//alert(html);
			$("#filter_cont").empty();
			$("#filter_cont").append(html);
			$(function() {
    			$( "#div_filter" ).accordion({
					collapsible: true
				});
  			});
			if(!filter_optselected)
				$( "#div_filter" ).accordion({ active: 2 });
			//setTimeout("$( \"#div_filter\" ).css(\"display\", \"\")", 1000);
			//$( "#df_name" ).accordion( "option", "collapsible", true );
			//ffa_off = false;
			init_mtm_arrow();
			get_price_ranges();
		}
	});
}