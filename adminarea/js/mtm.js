var mtm_fast_mtm = false;
function init_mtm(){
	$(".dmtm_div_1").hover(function() {
			mindex = this.id.replace("dmtm_0_","");
			$("#dmtm_1_"+mindex).css("display", "");
			pos = __positions_getAbsolutePos(document.getElementById("mtm_0_"+mindex));
			//alert(pos.y);
			//$("#dmtm_1_"+mindex).css("top", pos.y-$("#dmtm_1_"+mindex).innerHeight()-15-document.body.scrollTop);
			tmph = pos.y-$("#dmtm_1_"+mindex).innerHeight();
			//alert(tmph);
			if(!mtm_fast_mtm)
				$("#dmtm_1_"+mindex).css("top", -400-18);
			else
				$("#dmtm_1_"+mindex).css("height", 350-18);
			//__positions_getAbsolutePos(el);
		}, function() {
			//asdasdasd
			$("#dmtm_1_"+mindex).css("display", "none");
	});
}
//******************************
function set_mtm(lev1, lev2, mtmid, mtmso){
	paction = "paction=set_mtm&id="+mtmid+"&lev1="+lev1+"&lev2="+lev2;
	if(!mtmso.checked){
		if(lev2 == -1) {
			paction += "&del_lev1="+lev1;
			uucm = document.getElementById("dmtm_1_"+mindex);
			ucm = uucm.getElementsByTagName("input");
			for(i=0; i<ucm.length; i++){
				aucm = ucm[i];
				aucm.checked=0;
			}
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//alert(html);
					//$("#inc_tadiv").empty();
					//$("#inc_tadiv").append(html);
					
				}
			});
		} else {
			paction += "&del_lev2="+lev2;
		}
	}
	acb = false;
	//alert(paction);
	if(lev2!=-1){
		acb = document.getElementById("fcb_0_"+lev1);
		if(!acb.checked){
			ttpaction = "paction=set_mtm&id="+mtmid+"&lev1="+lev1+"&lev2=-1";
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: ttpaction,
				success: function(html) {
					acb.checked = true;
					set_mtm(lev1, lev2, mtmid, mtmso);
				}
			});
		} else {
			$.ajax({
				type: "POST",
				url: __ajax_url,
				data: paction,
				success: function(html) {
					//alert(html);
					//$("#inc_tadiv").empty();
					//$("#inc_tadiv").append(html);
					
				}
			});
		}
	}
	if(lev2==-1 && mtmso.checked){
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				//$("#inc_tadiv").empty();
				//$("#inc_tadiv").append(html);
				
			}
		});		
	}
}

//******************************
function __mtm_fast_mtm(pid){
		paction = "paction=mtm_fast_mtm&id="+pid;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				$("#inc_tadiv").empty();
				$("#inc_tadiv").append(html);
				mtm_fast_mtm = true;
			}
		});		
}