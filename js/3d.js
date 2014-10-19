//stop();
//skey_mc.duplicateMovieClip("skey2_mc", 10);
//skey_mc._visible = false;
//skey2_mc._x+=50;
//start_move = true;
gr_xy = 0;
gr_yz = 0;
//speed = 5;
h_move = false;
v_move = false;
z_move = false;
start_move = true;
//import mx.managers.DepthManager;
max_points = 20;
kub = new Array();
kub[0] = new Array(0, 0, 0);
var rec_array = new Array();
hide_close = false;
show_close = false;
is_hide = false;
is_show = false;
//trace(kub);
//*******************
//point_mc0 = new MovieClip();
//point_mc._visible = false;
//point_mc._alpha = 0;
for (i=0; i<max_points; i++) {
	//trace("OK");
	//point_mc.duplicateMovieClip("point_mc"+i,i);
	point_mc = {}
	point_mc = this["point_mc"+i];
	point_mc.napr = 1;
	point_mc.radius = random(50)+25;
	point_mc.s_teta = Math.round(180 / max_points * (i+1));
	point_mc.teta = point_mc.s_teta*Math.PI/180;
	point_mc.s_phi = random(360);
	point_mc.old_phi = point_mc.s_phi;
	point_mc.new_phi = point_mc.s_phi;
	//point_mc.s_phi = random(10);
	point_mc.phi = point_mc.s_phi*Math.PI/180;
	//point_mc.teta = point_mc.s_teta;
	//point_mc.gotoAndStop(i);
	rec_array[i] = {index:i, psx:0, sphi:point_mc.s_phi, steta:point_mc.s_teta};
	point_mc.pxx = point_mc.radius*Math.sin(point_mc.teta)*Math.cos(point_mc.phi);
	point_mc.pyy = point_mc.radius*Math.sin(point_mc.teta)*Math.sin(point_mc.phi);
	point_mc.pzz = point_mc.radius*Math.cos(point_mc.teta);
	//point_mc._x = point_mc.pyy;
	//point_mc._y = point_mc.pzz;
	//**********
	pxx = point_mc.pxx;
	pyy = point_mc.pyy;
	pzz = point_mc.pzz;
	//trace("POSITION:   "+pxx+"::"+pyy+"::"+pzz);
	//**********
	point_mc.teta_x = Math.acos(pzz/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	point_mc.teta_y = Math.acos(pyy/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	point_mc.teta_z = Math.acos(pxx/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	//trace("TETA:   "+point_mc.teta_x+"::"+point_mc.teta_y+"::"+point_mc.teta_z);
	//**********
	point_mc.phi_z = Math.atan(pxx/pzz);
	point_mc.phi_y = Math.atan(pzz/pyy);
	point_mc.phi_x = Math.atan(pyy/pxx);
	//trace("ACOS phi_y:   "+Math.atan(pzz/pyy)+"::"+(pzz/pyy));
	//trace("PHI:   "+point_mc.phi_x+"::"+point_mc.phi_y+"::"+point_mc.phi_z);
	//**********
	point_mc.gr_z = point_mc.phi_z/(Math.PI/180);
	point_mc.gr_y = point_mc.phi_z/(Math.PI/180);
	point_mc.gr_x = point_mc.phi_x/(Math.PI/180);
	//if(!point_mc.teta_x)point_mc.teta_x = point_mc.teta;
	//**********
	if (pxx<0) {
		point_mc.gr_x += 180;
	}
	if (pzz<0) {
		point_mc.gr_z += 180;
	}
	//trace("gr_x"+point_mc.gr_x);
	//rec_array.push();
	//point_mc.phi = point_mc.s_phi;
}
//*******************
this.onEnterFrame = function() {
	//trace("OK-"+i);
	if(start_move){
		//gr_xy = random(40);
		//gr_yz = random(40);
		gr_xy = _xmouse/50;
		gr_yz = -_ymouse/50;
	} else {
		gr_xy = 0;
		gr_yz = 0;
		}
	for (i=0; i<max_points; i++) {
		
		//trace("OK-"+i+"::gr_xy="+gr_xy);
		point_mc = this["point_mc"+i];
			set_x();
			set_y();
		//**********
		if(is_hide){
			//if(point_mc._name!=hide_name){
				point_mc.radius -=20;
				//point_mc._xscale = radius-50;
				if(point_mc.radius<=0){
					point_mc.radius=0;
					point_mc._xscale = 1;
					point_mc._yscale = 1;
					hide_close = true;
				}
			//}
		}
		if(is_show){
			if(point_mc._name!=hide_name){
				//trace(point_mc._name);
				//point_mc.radius +=20;
				//if(point_mc.radius>=200){
					point_mc.radius=200;
					point_mc._xscale = 50;
					point_mc._yscale = 50;
					show_close = true;
				//}
			}
		}
		if(point_mc.radius!=0){
		point_mc._x = point_mc.pyy;
		point_mc._y = point_mc.pzz;
		scale = (pxx + point_mc.radius*3.5) * 100 / (point_mc.radius*4);
		if(point_mc._name == mouseover_clip)
			point_mc._alpha = 100;
		else 
			point_mc._alpha = (point_mc.pxx+point_mc.radius)*100/(point_mc.radius*2)+50;
		point_mc._xscale = scale;
		point_mc._yscale = scale;
		}//trace(i+"::pxx="+point_mc.pxx+"::pyy="+point_mc.pyy+"::pzz="+point_mc.pzz);
		//if(!point_mc.teta_x)point_mc.teta_x = point_mc.teta;
		//**********
		//**********     
		//«апись индексов в массив дл€ управлени€ глубиной
		az = point_mc.pxx;
		
		for (j=0; j<max_points; j++) {
			if (rec_array[j]["index"] == i) {
				rec_array[j]["psx"] = az;
			}
		}
	}
	//***************
	if(hide_close) {
		is_hide = false;
		//is_show = true;
	}
	if(show_close) {
		trace("show_close");
		is_hide    = false;
		is_show    = false;
		show_close = false;
		hide_name  = false;
		hide_close = false;
	}
	//–едактирование индексов дл€ управлени€ глубиной
	rec_array.sortOn(["psx"], Array.NUMERIC);
	//rec_array.reverse();
	sort = true;
	for (i=0; i<max_points; i++) {
		point_mc = this["point_mc"+rec_array[i]["index"]];
		if(point_mc.pxx < 0)
			point_mc.swapDepths(i);
		if(point_mc.pxx>0 && sort){
			//trace(point_mc.pxx);
			skey_mc.swapDepths(i);
			sort=false;
		}
		if(point_mc.pxx > 0)
			point_mc.swapDepths(i+1);
		if(point_mc._name == mouseover_clip){
				point_mc.swapDepths(max_points);
			}
	}
};
function set_x() {
	//**********
	//phi = (gr_xy+point_mc.s_phi)*Math.PI/180;
	//trace((point_mc.gr_x+gr_xy)+"::"+point_mc.gr_x+"::"+gr_xy);
	t_gr = point_mc.gr_x+gr_xy;
	if(t_gr>360) t_gr-=360;
	if(t_gr<-360) t_gr+=360;
	w_phi = (t_gr)*Math.PI/180;
	point_mc.pxx = point_mc.radius*Math.sin(point_mc.teta_x)*Math.cos(w_phi);
	point_mc.pyy = point_mc.radius*Math.sin(point_mc.teta_x)*Math.sin(w_phi);
	point_mc.pzz = point_mc.radius*Math.cos(point_mc.teta_x);
	//**********
	//********** –асчет новых координат, углов, разных параметров:
	pxx = point_mc.pxx;
	pyy = point_mc.pyy;
	pzz = point_mc.pzz;
	//trace("POSITION:   "+point_mc.pxx+"::"+point_mc.pyy+"::"+point_mc.pzz);
	//**********
	point_mc.teta_x = Math.acos(pzz/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	point_mc.teta_y = Math.acos(pyy/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	point_mc.teta_z = Math.acos(pxx/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	//trace("TETA:   "+point_mc.teta_x+"::"+point_mc.teta_y+"::"+point_mc.teta_z);
	//**********
	point_mc.phi_z = Math.atan(pxx/pzz);
	point_mc.phi_y = Math.atan(pzz/pyy);
	point_mc.phi_x = Math.atan(pyy/pxx);
	//trace("PHI:   "+point_mc.phi_x+"::"+point_mc.phi_y+"::"+point_mc.phi_z);
	//**********
	point_mc.gr_z = point_mc.phi_z/(Math.PI/180);
	point_mc.gr_y = point_mc.phi_y/(Math.PI/180);
	point_mc.gr_x = point_mc.phi_x/(Math.PI/180);
	if (pxx<0) {
		point_mc.gr_x += 180;
	}
	if (pzz<0) {
		point_mc.gr_z += 180;
	}
	//trace("GR_:   "+point_mc.gr_x+"::"+point_mc.gr_y+"::"+point_mc.gr_z);
}
function set_y() {
	//**********
	//phi = (gr_xy+point_mc.s_phi)*Math.PI/180;
	//trace((point_mc.gr_z+gr_yz)+"::"+point_mc.gr_z+"::"+gr_yz);
	t_gr = point_mc.gr_z+gr_yz;
	if(t_gr>360) t_gr-=360;
	if(t_gr<-360) t_gr+=360;
	w_phi = (t_gr)*Math.PI/180;
	point_mc.pxx = point_mc.radius*Math.sin(point_mc.teta_y)*Math.sin(w_phi);
	point_mc.pzz = point_mc.radius*Math.sin(point_mc.teta_y)*Math.cos(w_phi);
	point_mc.pyy = point_mc.radius*Math.cos(point_mc.teta_y);
	//**********
	//********** –асчет новых координат, углов, разных параметров:
	pxx = point_mc.pxx;
	pyy = point_mc.pyy;
	pzz = point_mc.pzz;
	//trace("POSITION:   "+point_mc.pxx+"::"+point_mc.pyy+"::"+point_mc.pzz);
	//**********
	point_mc.teta_x = Math.acos(pzz/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	point_mc.teta_y = Math.acos(pyy/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	point_mc.teta_z = Math.acos(pxx/Math.sqrt(pxx*pxx+pyy*pyy+pzz*pzz));
	//trace("TETA:   "+point_mc.teta_x+"::"+point_mc.teta_y+"::"+point_mc.teta_z);
	//**********
	point_mc.phi_z = Math.atan(pxx/pzz);
	point_mc.phi_y = Math.atan(pzz/pyy);
	point_mc.phi_x = Math.atan(pyy/pxx);
	//trace("PHI:   "+point_mc.phi_x+"::"+point_mc.phi_y+"::"+point_mc.phi_z);
	//**********
	point_mc.gr_z = point_mc.phi_z/(Math.PI/180);
	point_mc.gr_y = point_mc.phi_y/(Math.PI/180);
	point_mc.gr_x = point_mc.phi_x/(Math.PI/180);
	if (pxx<0) {
		point_mc.gr_x += 180;
	}
	if (pzz<0) {
		point_mc.gr_z += 180;
	}
	//trace("GR_:   "+point_mc.gr_x+"::"+point_mc.gr_y+"::"+point_mc.gr_z);
}
//**********************************

/*spcb_mc.onPress = function (){

	spcb_mc.useHandCursor = "";
	//trace("OK");
	start_move = true;
};
spcb_mc.onMouseUp = function (){
	//spcb_mc.useHandCursor = "";
	//trace("OK");
	start_move = false;
};*/