<script language="JavaScript">
<?  echo "db_index=\"$tree_index\";\n "; ?>
//db_index = "1";
flg = (document.all) ? 0 : 1;
var obj, start_folder, end_folder;
droped=false;
function mousedown(ev) 
{
if(document.getElementById("tree_drag_folder").style.display!="none"){
	
	if (flg){ 
		obj = document.getElementById("tree_drag_folder");
		X=ev.x;
		Y=ev.y;
		//return false;
	}
	else{
		obj = event.srcElement.parentElement;
		X=event.offsetX;
		Y=event.offsetY;
	}
}}

function mousemove(ev) 
{
	if (obj){
		if (flg){
			obj.style.top = ev.clientY + window.scrollY-8;//ev.pageY-Y+"px";
			obj.style.left = ev.clientX + window.scrollX-10;
		}
		else{
			obj.style.pixelLeft = event.clientX-X + document.body.scrollLeft;
			obj.style.pixelTop = event.clientY-Y + document.body.scrollTop;
			return false;
		}
	}
}

function mouseup() 
{
	move_obj = document.getElementById("tree_drag_folder");
	if(move_obj.style.display!="none"){//document.getElementById("tdf_t").innerHTML="+0+";
		obj = document.getElementById("all_tree");
		mass = obj.getElementsByTagName("div");
		for(i=0; i<mass.length; i++){
			if(find_target_folder_by_name(mass[i].id)){
				rect = new Array();
				rect[0] = getAbsolutePos(mass[i]).y+1;
				rect[1] = getAbsolutePos(mass[i]).y+16;
				rect[2] = getAbsolutePos(mass[i]).x+1;
				rect[3] = getAbsolutePos(mass[i]).x+19;
				my_point = getAbsolutePos(move_obj).y+8;
				my_point_x = getAbsolutePos(move_obj).x+10;
				if(my_point>=rect[0] && my_point<=rect[1] && my_point_x>=rect[2] && my_point_x<=rect[3]){
					end_folder = mass[i].id;
					ef_obj = mass[i];
				}
			}
		}	
		move_obj.style.display="none";
		droped=true;
		obj = null;
		obj=false;
		if(start_folder==end_folder) return false;
		change_folder_parent();
	}
}

if (flg) 
{
  document.captureEvents(Event.MOUSEDOWN | Event.MOUSEMOVE | Event.MOUSEUP);
}

document.onmousedown = mousedown;
document.onmousemove = mousemove;
document.onmouseup = mouseup;

function show_drag_folder(f_obj){
	if(!obj && document.getElementById("tree_drag_folder").style.display!=""){
		obj= null;
		obj=false;
	}
	if(!obj){
		//document.getElementById("tree_drag_folder").pixelLeft = 500;//event.clientX-X + 
		document.getElementById("tree_drag_folder").style.top=getAbsolutePos(f_obj).y-2;
		document.getElementById("tree_drag_folder").style.left=getAbsolutePos(f_obj).x-2;
		document.getElementById("tree_drag_folder").style.display="";
		start_folder=f_obj.id;
		sf_obj = f_obj;
	}
	//alert(obj);
}
function hide_drag_folder(){
	if(!flg)document.getElementById("tree_drag_folder").style.display="none";
	else{
		if(!obj)document.getElementById("tree_drag_folder").style.display="none";
	}
	obj=null;
	obj=false;
}
function find_target_folder_by_name(name){
	//alert(name.substring(0, 12));
	if(name.substring(0, 12)=="tree_folder_"){
		return true;
	}
	return false;
}
function getAbsolutePos(el)
	{
	var r = { x: el.offsetLeft, y: el.offsetTop }
	if (el.offsetParent)
		{
		var tmp = getAbsolutePos(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
		}
	return r;
	}
function change_folder_parent(){
	if(test_folder_for_child()){
		ef_obj.style.backgroundImage='url(tree/open_folder.gif)';
		start_folder = get_id_from_name(start_folder);
		end_folder = get_id_from_name(end_folder);
		//alert("start_folder:"+start_folder+":::end_folder:"+end_folder);
		window.open("?change_parent="+start_folder+"&new_parent="+end_folder, "_top");
	}
}
function test_folder_for_child(){
//alert(sf_obj.id);
start_id=get_id_from_name(sf_obj.id);
sff_obj = document.getElementById("is_open_"+db_index+"_"+start_id);
if(!sff_obj) return true;
t_mass = sff_obj.getElementsByTagName("div");
for(j=0; j<t_mass.length; j++){
	//alert(t_mass[j].id);
	if(find_target_folder_by_name(t_mass[j].id)){
		
		if(t_mass[j].id==ef_obj.id){
			alert("Родительский элемент нельзя сделать дочерним для него же...");
			return false;
		}
	}
}
return true;
}
function get_id_from_name(name){
	count=0;
	for(i=name.length-1; i!=-1; i--){
		//alert(name.substr(i, 1));
		if(name.substr(i, 1)=="_")
			return name.substr(i+1, count);
		count++;
	}
	return false;
}
function is_cursor_on_folder(){
	a_obj=document.getElementById("tree_drag_folder");
	
}
//function is_cursor_on_drag_folder(){
	//if(document.getElementById("tree_drag_folder").style.display=="none")
//}
</script>
<script>
<!--
<?
//echo __farmmed_rekursiya_show_items_for_js(0, $edit_mass, $edit, 0);
?>
/*function show_tree_item(item_id, parent){
	for(i=0; i<eval("tree_array_"+item_id).length; i++){
		//alert("tree_plus_"+eval("tree_array_"+item_id+"["+i+"]"));
		document.getElementById("tree_item_"+eval("tree_array_"+item_id+"["+i+"]")).style.display = "block";
	}
	document.getElementById("tree_plus_"+item_id).style.display = "none";
	document.getElementById("tree_minus_"+item_id).style.display = "block";
}
function hide_tree_item(item_id, parent){
	for(i=0; i<eval("tree_array_"+item_id).length; i++){
		//alert("tree_plus_"+eval("tree_array_"+item_id+"["+i+"]"));
		document.getElementById("tree_item_"+eval("tree_array_"+item_id+"["+i+"]")).style.display = "none";
	}
	document.getElementById("tree_plus_"+item_id).style.display = "block";
	document.getElementById("tree_minus_"+item_id).style.display = "none";
}
function tree_mouse_over(oElement){
	//document.getElementById("test").innerText = "Мышь на папке";
}*/
-->
</script>
<script>
var req;
var reqTimeout;
var temp = "";
var load_t = "";
 
function loadXMLDoc(url) {
    req = null;
    if (window.XMLHttpRequest) {
        try {
            req = new XMLHttpRequest();
        } catch (e){}
    } else if (window.ActiveXObject) {
        try {
            req = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e){
            try {
                req = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (e){}
        }
    }
 
    if (req) {
        req.onreadystatechange = processReqChange;
        req.open("GET", url, true);
        req.send(null);
        reqTimeout = setTimeout("req.abort();", 5000);
    } else {
        alert("Браузер не поддерживает AJAX");
    }
}
 
function processReqChange() {
    if (req.readyState == 4) {
        clearTimeout(reqTimeout);
        if (req.status == 200) {
			//alert(req.responseText);
			document.getElementById("is_open_"+db_index+"_"+all_id).innerHTML=req.responseText;
        } else {
            alert("Не удалось получить данные:\n" + req.statusText);
        }
    }  
}
 
function stat(n)
{
  switch (n) {
    case 0:
      return "не инициализирован";
    break;
 
    case 1: 
      return "загрузка...";
    break;
 
    case 2: 
      return "загружено";
    break;
 
    case 3: 
      return "в процессе...";
    break;
 
    case 4: 
      return "готово";
    break;
 
    default:
      return "неизвестное состояние";  
  }  
}
 
function requestdata(params)
{
  loadXMLDoc('__frame_2.php'+params);
}
</script>
<script>
<!--
function show_tree_item(db_index, item_id, count){
	//alert("is_open_"+db_index+"_"+item_id);
	//alert("is_open_"+db_index+"_"+item_id);
	document.getElementById("is_open_"+db_index+"_"+item_id).style.display = "block";
	all_id=item_id;
	requestdata("?tree_index="+db_index+"&parent="+item_id+"&count="+(count+1));
	inner = "<a href=\"javascript:hide_tree_item("+db_index+", "+item_id+", "+count+")\">";
	inner+= "<img src=\"tree/minus.jpg\" class=\"tree-img\"></a>";
	document.getElementById("tree_plus_"+db_index+"_"+item_id).innerHTML = inner;
}
function hide_tree_item(db_index, item_id, count){
	document.getElementById("is_open_"+db_index+"_"+item_id).style.display = "none";
	inner = "<a href=\"javascript:show_tree_item("+db_index+", "+item_id+", "+count+")\">";
	inner+= "<img src=\"tree/plus.jpg\" class=\"tree-img\"></a>";
	//alert(inner);
	document.getElementById("tree_plus_"+db_index+"_"+item_id).innerHTML = inner;

}
function tree_mouse_over(oElement){
	//document.getElementById("test").innerText = "Мышь на папке";
}
function change_load_text(){
	//alert(value);
}
function f_show_edit_folder(num){
	document.getElementById("show_edit_folder_"+num).style.display="";
}
function f_hide_edit_folder(num){
	document.getElementById("show_edit_folder_"+num).style.display="none";
}
-->
</script>
<form name="load_form">
</form>
   <div id="tree_drag_folder" name="tree_drag_folder" style="position:absolute;left:90;top:100;display:none; padding:2px;" >
      <img src="tree/folder_move.jpg" name="a">
   </div>