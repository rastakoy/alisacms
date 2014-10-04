<script><!--
cur_el=false;
//**************
document.onmousemove = function(e) {
   e = e || event;
   var o = e.target || e.srcElement;
   document.title = o.tagName+": id=>"+o.id+": name=>"+o.name;
   cur_el = o;
   
}
//**************
function replace_string(txt, cut_str, paste_str){ 
	ret_val = "";
	ssl = cut_str.length;
	//alert("cut_str = "+cut_str);
	for(i = 0; i < txt.length; i++){
		//if(cut_str == "Комплект поставки:")
			//alert("проверка в == "+ txt.substring(i, i+ssl));
		if(txt.substring(i, i+ssl) == cut_str){
			//alert("Совпадение "+ txt.substring(i, i+ssl));
			ret_val += paste_str; 
			i+=ssl-1;
		}
		else{
			ret_val += txt.substring(i, i+1);
		}
		//alert(ret_val);
	}
	return ret_val;
};
//**************
document.onkeyup = function(){
	alert((event.keyCode));
	//e = e || event;
	//var o = e.target || e.srcElement;
	//document.title = o.tagName;
   
   if(event.keyCode==84){ //t
   		obj = cur_el;
		for(i=0; i<10; i++){	
			if(obj.tagName != "TABLE"){
				obj = obj.parentNode;
			} else {
				obj = obj.parentNode;
				top.document.getElementById("item_cont").value += obj.innerHTML;
				//alert(obj.innerHTML);
				alert("Таблица установлена");
				break;
			}
			//alert(obj.tagName);
		}
   }
   if(event.keyCode==82){
   		cur_el = cur_el.parentNode.parentNode.parentNode;
		top.delete_row_csv(0);
		top.delete_row_csv(0);
		top.delete_cell_csv(0);
		top.delete_cell_csv(0);
		read_table2();
   }
    if(event.keyCode==81){ //q
		tt  =  document.getSelection();
		top.document.getElementById("name").value = tt;
		alert("Название установлено");
	}
	if(event.keyCode==70){
		//alert(cur_el.src);
		top.document.getElementById("specimg").value = cur_el.src;
		alert("Фото установлено\n"+cur_el.src);
	}
	if(event.keyCode==67){
		str =  document.getSelection();
		str = replace_string(str, "\n", "<br/>\n");
		str = replace_string(str, "\nкомплектация", "<br/>\n<b>Копмплектация</b>");
		str = replace_string(str, "Комплект поставки:", "<br/>\n<b>Комплект поставки</b>");
		str = replace_string(str, "Дополнительные характеристики", "<br/>\n<b>Дополнительные характеристики</b>");
		str = replace_string(str, "дополнительные характеристики", "<br/>\n<b>Дополнительные характеристики</b>");
		top.document.getElementById("mce_editor_0").contentWindow.document.body.innerHTML += str+"<br/>";
		//alert("Установка текста");
	}
	if(event.keyCode==88){
		top.document.getElementById("mce_editor_0").contentWindow.document.body.innerHTML ="";
		//alert("Установка текста");
	}
	if(event.keyCode==69){ //e
		if(cur_el.tagName == "IMG" || cur_el.tagName == "img"){
			//alert(cur_el.src);
			//top.document.getElementById('up_iframe').contentWindow.document.getElementById("myfileform").src = cur_el.src;
			//top.document.getElementById("myfileform").src = cur_el.src;
			//alert(top.document.getElementById('up_iframe').contentWindow.document.getElementById("myfileform").src);
			top.myup_SendFile(cur_el.src);		

		}
		//text_to_table();
		//top.document.getElementById("mce_editor_0").contentWindow.document.body.innerHTML ="";
		//alert("Установка текста");
	}
	if(event.keyCode==87){ //w
		convert_ttt();
		//top.document.getElementById("mce_editor_0").contentWindow.document.body.innerHTML ="";
		//alert("Установка текста");
	}
	//alert((event.keyCode)+":::"+cur_el.tagName);
}
//**************
function read_table(){
	fs = true;
	var table = cur_el;
	var trList= table.getElementsByTagName('tr');
	for (var i=0;i<trList.length;i++){
		top.mass_csv[i] = new Array();
		var tdList = trList[i].getElementsByTagName('td');
		for (j=0;j<tdList.length;j++) {
			top.mass_csv[i][j] = tdList[j].innerHTML;
			//if(fs) top.add_cell_csv();
			//document.getElementById("data_csv_"+i+"_"+j).value = "asd"; //
		}
		fs = false;
	} 	
	top.mass_csv[i] = new Array();
	top.mass_csv[i][0] = "Цена";
	top.mass_csv[i][1] = "Договорная";
	top.rows_csv = i+1;
	top.cells_csv = j;
	top.render_table_csv();
	alert("Таблица установлена");
}
//**************
function read_table2(){
	fs = true;
	var table = cur_el;
	var trList= table.getElementsByTagName('tr');
	for (var i=0;i<trList.length;i++){
		top.mass_csv[i] = new Array();
		var tdList = trList[i].getElementsByTagName('td');
		m_ins = "";
		for (j=0;j<tdList.length;j++) {
			if((i==0 && j==0) || (i==1 && j==0)){
				for(jj=tdList[j].innerHTML.length-1; jj>0; jj--){
					//alert(tdList[j].innerHTML.substring(jj, jj+1));
					if(tdList[j].innerHTML.substring(jj, jj+1) == ","){
						m_ins = tdList[j].innerHTML.substring(jj+1, tdList[j].innerHTML.length-1);
						m_ins = replace_string(m_ins, ":", "");
						//alert(m_ins);
					}
				}
			}
			
			top.mass_csv[i][j] = tdList[j].innerHTML;
			if((i==0 && j==1) || (i==1 && j==1)){
				top.mass_csv[i][j] += " "+m_ins;
			}
			//if(fs) top.add_cell_csv();
			//document.getElementById("data_csv_"+i+"_"+j).value = "asd"; //
		}
		fs = false;
	} 	
	top.mass_csv[i] = new Array();
	top.mass_csv[i][0] = "Цена";
	top.mass_csv[i][1] = "Договорная";
	top.rows_csv = i+1;
	top.cells_csv = j;
	top.render_table_csv();
	alert("Таблица установлена");
}
//**************
function text_to_table(){
	//alert("ttt");
	mass = new Array();
	//****
	txt  =  document.getSelection();
	
	cut_str = "\n";
	old_i = 0;
	count = 0;
	ret_val = "";
	ssl = cut_str.length;
	//alert(txt);
	for(i = 0; i < txt.length; i++){
		//alert(txt.substring(i, i+ssl));
		if(txt.substring(i, i+ssl) == cut_str){
			//alert(txt.substring(old_i, i));
			mass[count] = txt.substring(old_i, i);
			old_i=i;
			count++;
			i+=ssl-1;
		}
	}
	//alert(mass);
	ret = "<table width=\"100%\" border=\"1\">";
	for(i=0; i<mass.length; i++){
		ret+="<tr>";
		ret+="<td height=\"30\" id=\"ttt_"+i+"_0\" style=\"font-size: 13px;\">"+mass[i]+"</td>";
		ret+="<td id=\"ttt_"+i+"_1\" width=\"75\" style=\"font-size: 13px;\">&nbsp;</td>";
		ret+="</tr>";
	}
	ret+="</table>";
	ret+="<a href=\"javascript:ttt_hide()\">Закрыть</a>";
	document.getElementById("text_to_table").style.display = "";
	document.getElementById("text_to_table").innerHTML = ret;
	//alert(window.pageYOffset);
	document.getElementById("text_to_table").style.top = (window.pageYOffset) + "px";
	//return ret_val;
}
function ttt_hide(){
	document.getElementById("text_to_table").style.display = "none";
}
function  convert_ttt(){

	tt  =  document.getSelection();
	
	alert(cur_el.tagName);
	
	//alert(tt);
	//new_str = replace_string(cur_el.innerText, tt, "");
	//new_str = replace_string(new_str, "<BR>",  "");
	
	//alert("ci="+top.cur_item_id);
	//alert(top.document.getElementById("item_cont").value);
	top.document.getElementById("item_cont").value += tt;
	alert("Описание установлено");
	//cur_el.innerHTML = new_str;
	//p_el = cur_el.parentNode;
	//tt = replace_string(tt, ";", "");
	//p_el.childNodes[1].innerText = tt;
	
	
}
--></script>
<div id="grabber_help" ><b>Выделите текст и нажмите:</b><br/><br/>
q - название элемента :: 
w - описание элемента :: 
e - загрузка картинки (навести курсор)
</div>