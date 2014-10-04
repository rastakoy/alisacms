//***************************************
function __positions_getAbsolutePos(el)
{
var r = { x: el.offsetLeft, y: el.offsetTop }
	if (el.offsetParent){
		var tmp = __positions_getAbsolutePos(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
}
//***************************************