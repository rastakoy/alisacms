//******************************
function explode( delimiter, string ) { // Split a string by string
    var emptyArray = { 0: '' };
    if ( arguments.length != 2
        || typeof arguments[0] == 'undefined'
        || typeof arguments[1] == 'undefined' )
    {
        return null;
    }
    if ( delimiter === ''
        || delimiter === false
        || delimiter === null )
    {
        return false;
    }
    if ( typeof delimiter == 'function'
        || typeof delimiter == 'object'
        || typeof string == 'function'
        || typeof string == 'object' )
    {
        return emptyArray;
    }
    if ( delimiter === true ) {
        delimiter = '1';
    }
    return string.toString().split ( delimiter.toString() );
}
//******************************
function objsGetDomIndex(elem){
	if(elem)
		if(elem.parentNode)
			if(elem.parentNode.children)
				for(var j=0; j<elem.parentNode.children.length; j++)
					if(elem.parentNode.children[j]==elem)
						return j;
	
	return false;
}
//******************************
var ffmaxzindexCof=1000;
var ffmaxzindex=0;
function getMaxZIndex() {
	//var a = document.getElementsByTagName("*"); 
	//var maxz = 0;
	//for (i = a.length - 1; i >= 0; i--) {
	//	curz = parseInt($("#test_win").css("zIndex"), 10);
	//	if(curz>maxz) maxz=curz;
	//}
	//alert(parseInt($("#test_win").css("zIndex"), 10)  );
	
	if(browserDetectJS()=="Firefox"){
		mret = ffmaxzindex;
		ffmaxzindex++;
		return mret*1+ffmaxzindexCof*1;
	}
	
	var a = document.getElementsByTagName("*"), 
         i, maxZ = 0, z,
         getZIndex = window.getComputedStyle ? function (el) {return +getComputedStyle(el).zIndex; } : function (el) {return +el.currentStyle.zIndex; };
    for (i = a.length - 1; i >= 0; i--) {
         z = getZIndex(a[i]);
         if (z > maxZ) {
             maxZ = z;
         }
    }
    return maxZ;
	//alert(maxz);
	//return maxz;
}
//******************************
function browserDetectJS() {
var  browser = new Array();
//Opera
    if (window.opera) {
        browser[0] = "Opera";
        browser[1] = window.opera.version();
    }
        else 
//Chrome    
        if (window.chrome) {
            browser[0] = "Chrome";
        }
            else
//Firefox
            if (window.sidebar) {
                browser[0] = "Firefox";
            }
                else
//Safari 
                    if ((!window.external)&&(browser[0]!=="Opera")) {
                        browser[0] = "Safari";
                    }
                        else
//IE
                        if (window.ActiveXObject) {
                            browser[0] = "MSIE";
                            if (window.navigator.userProfile) browser[1] = "6"
                                else 
                                    if (window.Storage) browser[1] = "8"
                                        else 
                                            if ((!window.Storage)&&(!window.navigator.userProfile)) browser[1] = "7"
                                                else browser[1] = "Unknown";
                        }
     
    if (!browser) return(false)
        else return(browser);
}
//******************************
function myRound(a,b) {
	b=b || 0;
	return Math.round(a*Math.pow(10,b))/Math.pow(10,b);
}
//******************************
function toPriceText(val, valut) {
	if(!valut) valut = "грн.";
	val = val.toString().replace(/\./, ",");
	mm = explode(",", val);
	if(mm.length>1){
		if(mm[1].length==1) val = val + "0 "+valut;
		if(mm[1].length==2) val = val + " "+valut;
	} else {
		val = val+",00 "+valut;
	}
	return val;
}
//******************************
function replace_spec_simbols(spectxt){
	ret = spectxt;
	ret = ret.replace(/&sup2;/gi , "<sup>2</sup>");
	ret = ret.replace(/&sup3;/gi , "<sup>3</sup>");
	ret = ret.replace(/&deg;/gi , "<sup>o</sup>");
	ret = ret.replace(/&/gi , "~~~aspirand~~~");
	ret = ret.replace(/\+/gi , "~~~plus~~~");
	//ret = ret.replace(/&frac12;/gi , "1/2"); 
	return ret;
}
//******************************