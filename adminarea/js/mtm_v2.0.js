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
//******************************
function mtm_show_next_level(mycurlevel){
	if(to_right){
		counter = $(".mtm_v2_level");
		next_level = mycurlevel + 1;
		if(counter.length > next_level){
			mtm_move_level_left(next_level);
			mtm_move_pos = 0 - next_level*mtm_move_width+mtm_move_width;
		}
	} else {
		to_right = true;
	}
}
//******************************
function mtm_hide_level(smkey, smlevel, smid, smobj, smlevel_way){
	load_prev_mtm(smkey, smlevel, smid, smobj, smlevel_way);
	//mtm_move_pos = -mycurlevel*mtm_move_width;
	//alert(mtm_move_pos);
}
//******************************
var mtm_move_interval 	= 15;
var mtm_move_speed 		= 30;
var mtm_move_pos	 		= 150;
var mtm_move_width 		= 400;
var mtm_move_padd 		= 5;
var mtm_ml_timer			= false;
var mtm_mr_timer			= false;
//******************************
function mtm_move_level_left(mymovelevel){
	if(mtm_move_pos < 0 - mymovelevel*mtm_move_width){
		clearInterval(mtm_ml_timer);
		lpad=-mymovelevel*mtm_move_width+mtm_move_padd*mymovelevel;
		$("#mtm_level_"+mymovelevel).css("left", lpad+"px");
		tpad=mtm_move_padd*mymovelevel;
	} else {
		clearInterval(mtm_ml_timer);
		mtm_move_pos -= mtm_move_speed;
		$("#mtm_level_"+mymovelevel).css("left", mtm_move_pos+"px");
		mtm_ml_timer = setTimeout("mtm_move_level_left("+mymovelevel+")", mtm_move_interval);
	}
}
//******************************
function mtm_move_level_right(mymovelevel){
	r_pos = -mymovelevel*mtm_move_width+mtm_move_width;
	if(mtm_move_pos > r_pos){
		clearInterval(mtm_mr_timer);
		$("#mtm_level_"+mymovelevel).css("left", r_pos+"px");
	} else {
		clearInterval(mtm_mr_timer);
		mtm_move_pos += mtm_move_speed;
		$("#mtm_level_"+mymovelevel).css("left", mtm_move_pos+"px");
		mtm_mr_timer = setTimeout("mtm_move_level_right("+mymovelevel+")", mtm_move_interval);
	}
}
//******************************

//******************************
var to_right = true;
function set_mtm(smkey, smlevel, smid, smobj, smlevel_way){
	//alert("sid="+smobj.id);
	paction = "paction=mtm_set_mtm&smkey="+smkey+"&smlevel="+smlevel+"&smid="+smid+"&smlevel_way="+smlevel_way;
	to_right = false;
	if(smobj.checked){
		//alert(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				to_right = true;
				load_mtm(smkey, smlevel+1, smid, smobj, smlevel_way);
			}
		});
	} else {
		paction = "paction=mtm_unset_mtm&smkey="+smkey+"&smlevel="+smlevel+"&smid="+smid+"&smlevel_way="+smlevel_way;
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				to_right = true;
			}
		});
	}
}
//******************************
//function load_mtm(smkey, smlevel, smid, smlevel_way){
function load_mtm(smkey, smlevel, smid, smobj, smlevel_way){
	if(to_right){
		paction = "paction=mtm_generate_level&smid="+smid+"&smlevel_way="+smlevel_way+"&smkey="+smkey;
		//alert(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				$("#mtm_level_"+smlevel).empty();
				$("#mtm_level_"+smlevel).append(html);
				mtm_show_next_level(smlevel-1);
			}
		});
	}
}
//******************************
function load_prev_mtm(smkey, smlevel, smid, smobj, smlevel_way){
	//alert("smkey="+smkey);
	//alert("smlevel="+smlevel_way);
	//alert("smid="+smid);
	//alert("smobj="+smobj);
	//alert("smlevel_way="+smlevel_way);
	//****************************************************
	cc=0;
	//alert("smlevel="+smlevel_way);
	if(to_right){
		paction = "paction=mtm_generate_level&smid="+smid+"&smlevel_way="+smlevel_way+"&smkey="+smkey;
		//alert(paction);
		$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				$("#mtm_level_"+smlevel).empty();
				$("#mtm_level_"+smlevel).append(html);
				mtm_move_level_right(smlevel+1);
			}
		});
	}
}
//******************************
function save_mtm_name(){
	paction = "paction=mtm_set_fname&fid="+all_mtm_level_id+"&fname="+$("#mtm_fname").val();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			$("#mtm_ftitle_"+all_mtm_level_id).empty();
			$("#mtm_ftitle_"+all_mtm_level_id).append(html);
			//alert(html);
		}
	});
}
//******************************
function save_mtm_style(){
	paction = "paction=mtm_set_fstyle&fid="+all_mtm_level_id+"&fstyle="+$("#mtm_fstyle").val();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//$("#mtm_ftitle_"+all_mtm_level_id).empty();
			//$("#mtm_ftitle_"+all_mtm_level_id).append(html);
			//alert(html);
		}
	});
}
//******************************
function save_mtm_bg(){
	paction = "paction=mtm_set_fbg&fid="+all_mtm_level_id+"&fbg="+$("#mtm_fbg").val();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//$("#mtm_ftitle_"+all_mtm_level_id).empty();
			//$("#mtm_ftitle_"+all_mtm_level_id).append(html);
			alert(html);
		}
	});
}
//******************************
function save_mtm_cont(){
	paction = "paction=mtm_set_cont&fid="+all_mtm_level_id+"&cont="+$("#mtm_cont").val();
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//$("#mtm_ftitle_"+all_mtm_level_id).empty();
			//$("#mtm_ftitle_"+all_mtm_level_id).append(html);
			alert(html);
		}
	});
}
//******************************
function mtm_del_level(){
	paction = "paction=mtm_del_level&fid="+all_mtm_level_id;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			cancel_fast_cont(close_mtm_id);
			//$("#mtm_ftitle_"+all_mtm_level_id).empty();
			//$("#mtm_ftitle_"+all_mtm_level_id).append(html);
			//alert(html);
		}
	});
}
//******************************
function mtm_add_level(){
	paction = "paction=mtm_add_level&fid="+all_mtm_level_id;
	$.ajax({
		type: "POST",
		url: __ajax_url,
		data: paction,
		success: function(html) {
			//alert(html);
			if(html == "ok"){
				alert("ok");
				cancel_fast_cont(close_mtm_id);
			} if(html == "false"){
				alert("У этого уровня есть подуровень!");
			}
		}
	});
}















