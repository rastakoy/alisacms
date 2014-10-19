var mbMass = {};
function __mb_loadMultyblock(mbName, mbCount){
	//alert(mbName);
	if(!mbMass[mbName]) mbMass[mbName] = {};
	if(!mbMass[mbName]["index"]) mbMass[mbName]["index"] = 0;
	pdata = "ajax=loadmultiblock_items&link="+root_request+"&mbName="+mbName+"&start="+mbMass[mbName]["index"]+"&count="+mbCount;
	//alert(pdata);
	$.ajax({
		type: "POST",
		scriptCharset: "UTF-8",
		url: "__ajax.php",
		data: pdata,
		success: function(html) {
			//alert(html);
			//if(alisa_cms) html = html.replace(/display:none;/gi, "display:;");
			if(mbMass[mbName]["index"]==0){
				$("#"+mbName).css("display","");
				$("#"+mbName).empty();
				$("#"+mbName).append(html);
				mbMass[mbName]["index"] = mbCount;
			} else {
				$("#"+mbName).append(html);
				mbMass[mbName]["index"] += mbCount*1;
			}
			objs = document.getElementById(mbName).children;
			for(var j=0; j<objs.length; j++){
				if(objs[j].style.display=="none")
					$(objs[j]).fadeIn(1000);
			}
		}
	});
}
//************************************