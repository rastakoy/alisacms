// JavaScript Document

var cur_bg_image;

function motion_move_down(sElemId, nBack, nBgImage){
	//alert("OK");
	var elem = document.getElementById(sElemId);
	document.getElementById(sElemId).parentNode.style.display = "";
	var proc = motion_move_down.aProc[sElemId];
	//alert(proc);
	if(!motion_move_down.aProc[sElemId]) nPosition = -300;
	else nPosition = motion_move_down.aProc[sElemId].nPosition;
	
	if(!motion_move_down.aProc[sElemId]){
		document.getElementById(sElemId).style.backgroundImage = "url(menu_images/" + nBgImage + ")";
	} else {
		if(motion_move_down.aProc[sElemId].nBgImageAdded)
			document.getElementById(sElemId).style.backgroundImage = "url(menu_images/" + nBgImage + ")";
	}
	
	if (motion_move_down.aProc[sElemId]) {clearInterval(motion_move_down.aProc[sElemId].tId);}
	motion_move_down.aProc[sElemId] = {'nBgImageAdded':false, 'nBgImage':nBgImage, 'nBack':nBack, 'nPosition':nPosition, 
	'tId':setInterval('motion_move_down.run("'+sElemId+'")', 20)}; 
	

}

motion_move_down.back = function(sElemId){motion_move_down(sElemId,true,motion_move_down.aProc[sElemId].nBgImage);};

motion_move_down.addBg = function(sElemId, nBgImage){
	motion_move_down.aProc[sElemId].nBgImageAdded = true;
	motion_move_down(sElemId,motion_move_down.aProc[sElemId].nBack,nBgImage);
};

motion_move_down.run = function(sElemId){
	var proc = motion_move_down.aProc[sElemId];
	if(proc.nBack){
		if (proc.nPosition>-300) proc.nPosition -= 20;
		document.getElementById(sElemId).parentNode.style.zIndex = 90;
	}  else  {
		if (proc.nPosition<0) proc.nPosition += 20;
		document.getElementById(sElemId).parentNode.style.zIndex = 100;
	}
	//document.title = motion_move_down.aProc[sElemId].nBgImage;
	document.getElementById(sElemId).style.margin = proc.nPosition + "px  0px  0px  0px";
	if (proc.nPosition>=0 || proc.nPosition<=-300) {
		if(proc.nPosition<=-300) document.getElementById(sElemId).parentNode.style.display = "none";
		clearInterval(motion_move_down.aProc[sElemId].tId);
	}
}

motion_move_down.aProc = {};

//*********************************************
function mdo(elemid){
	document.getElementById(elemid).style.display = "none";
}
function c_modul(elemid, mColor, mBgImage){
	meno = document.getElementById(elemid).parentNode;
	motion_move_down.addBg(meno.id, mBgImage);
	tmpmass = meno.getElementsByTagName("div");
	//alert(tmpmass[1].className);
	for(i=0; i<tmpmass.length; i++){
		//alert(tmpmass[i].className);
		if(tmpmass[i].className == "div_submenu_more") 
			tmpmass[i].style.display = "none";
		else
			tmpmass[i].className = "div_submenu";
		//alert(tmpmass[i].id);
		
		tmpmass[i].childNodes[0].style.color = mColor;
		if(tmpmass[i].id == elemid){
			tmpmass[i-1].className = "div_submenu_active";
			tmpmass[i-1].childNodes[0].style.color = "#FFFFFF";
			if(mColor == "#FFFFFF")  tmpmass[i-1].childNodes[0].style.color = "#999999";
			
		} 
	}
	//alert(document.getElementById(elemid).id);
	document.getElementById(elemid).style.display = "";
	//alert(meno.id);
	//meno.style.backgroundImage = "url(images/" + mBgImage + ")";
}