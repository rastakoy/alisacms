//**************************************
function add_multiprice_block(pid){
	var object = document.getElementById("tablemultiprice").firstChild;
	var objw = object.children.length;
	inso = document.createElement("tr");
	inner = "<td width=\"100\" style=\"height:40px;\"><input type=\"text\" style=\"width:80px\" /></td>";
	inner += "<td width=\"100\"><input type=\"text\" style=\"width:80px\" /></td>";
	inner += "<td width=\"100\"><input type=\"text\" style=\"width:100%\" /></td>";
	inner += "<td width=\"100\" style=\"padding-left:10px;\"><div id=\"multiprice_img_"+pid+"_"+objw+"\"></div></td>";
	inner += "<td width=\"100\"><input type=\"text\" style=\"width:80px\" /></td>";
	inner += "<td>&nbsp;</td>";
	inso.innerHTML = inner;
	object.appendChild(inso);
	init_multiprice_img("multiprice_img_"+pid+"_"+objw, pid, objw);
}
//**************************************
function init_multiprice_img(bName,mParent,mIndex){
	var uploaderA = new qqbb.FileUploader({
		// pass the dom node (ex. $(selector)[0] for jQuery users)
		element: document.getElementById(bName),
		action: 'upf.php',
		params: {"ptype":"multipriceimg","parent":mParent,"prior":mIndex},
		onComplete: function(id, fileName, responseJSON){
			object = document.getElementById("tablemultiprice").firstChild.children[mIndex+1].children[3];
			var inner = "<img id=\"mtpi_"+responseJSON["newid"]+"_"+mIndex+"\" ";
			inner += "src=\"../userupload/"+fileName+"\" style=\"margin:2px;width:30px;height:30px;border: 1px solid #961B1F;\" align=\"absmiddle\" />";
			inner += "<img src=\"images/green/myitemname_popup/edit_item.gif\" style=\"margin-left: 3px;cursor:pointer;\" align=\"absmiddle\" ";
			inner += "onClick=\"show_edit_img_popup("+responseJSON["newid"]+", 'userupload')\"  />";
			inner += "<img src=\"images/green/myitemname_popup/delete_item.gif\" style=\"margin-left: 5px;cursor:pointer;\" align=\"absmiddle\" ";
			inner += "onClick=\"delete_filemanager_item("+responseJSON["newid"]+", 'Удалить иконку?', 'clear_multiprice_img("+mIndex+", "+responseJSON["newid"]+")')\"  />";
			object.innerHTML = inner;
			//alert(JSON.stringify(responseJSON));
			//userImages[responseJSON["newid"]] = fileName;
			//alert(JSON.stringify(userImages));
			//printImages();
		}
	});
}
//**************************************
function clear_multiprice_img(mpKey, mpId){
	//alert("ok2");
	object = document.getElementById("tablemultiprice").firstChild.children[mpKey+1].children[3];
	//alert(object);
	object.innerHTML = "<div id=\"multiprice_img_"+mpId+"_"+mpKey+"\"></div>";
	init_multiprice_img("multiprice_img_"+mpId+"_"+mpKey, mpId, mpKey);
}
//**************************************