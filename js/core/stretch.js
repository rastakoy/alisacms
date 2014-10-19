$(document).ready(function(){
	if( typeof __stretch != "object" ) __stretch=false;
	if(__stretch){
		do_stretch();
		setTimeout("do_stretch()", 30);
	}
});
//******************************************
function do_stretch(){
	//alert(JSON.stringify(__stretch));
		window.onresize = function(){
			for(var mj in __stretch){
				mjo = document.getElementById(mj);
				mjoVals = explode("-", __stretch[mj]);
				//*************
				pl = mjo.style.paddingLeft.replace(/px$/, '')*1;
				pr = mjo.style.paddingRight.replace(/px$/, '')*1;
				ml = mjo.style.marginLeft.replace(/px$/, '')*1;
				mr = mjo.style.marginRight.replace(/px$/, '')*1;
				otst = pl+pr+ml+ml    +  20;
				//*************
				if(mjoVals[0].match(/%$/)){
					minw = mjoVals[0].replace(/px.*/, '')*1;
					minp = mjoVals[0].replace(/(^[0-9]*px:|%$)/gi, '')*1;
					maxw = mjoVals[1].replace(/px.*/, '')*1;
					maxp = mjoVals[1].replace(/(^[0-9]*px:|%$)/gi, '')*1;
					//alert("minw="+minw+"  minp="+minp);
					//alert("maxw="+maxw+"  maxp="+maxp);
					sto = maxw-minw;
					cur = mjo.parentNode.offsetWidth-otst - minw;
					//cur = x%
					//sto = 100%
					mypercent = cur*100/sto;
					sto_p = maxp - minp;
					//cur_p = mypercent
					//sto_p = 100%
					cur_p = sto_p*mypercent/100;
					exit_p = minp + cur_p;
					//document.title = exit_p;
					finalWidth = exit_p * (mjo.parentNode.offsetWidth-otst) / 100;
					mjo.style.width = finalWidth;
				} else {
					minw = mjoVals[0].replace(/px$/, '')*1;
					maxw = mjoVals[1].replace(/px$/, '')*1;
					//alert(minw + "::"+maxw)
					//document.title = window.innerWidth;
					
					if(mjo.parentNode.offsetWidth-otst  > minw && mjo.parentNode.offsetWidth-otst  < maxw){
						//alert(mjo.style.paddingLeft +":"+ mjo.style.paddingLeft +":"+ mjo.style.marginLeft +":"+ mjo.style.marginRight);
						mjo.style.width = mjo.parentNode.offsetWidth - otst;
						if(mjoVals[2]){
							var ww = Math.round(mjo.parentNode.offsetWidth - otst);
							var step = mjoVals[2].replace(/px$/, "");
							var myww;
							for(var wj=0; wj<ww; wj+=step*1){
								myww = wj;
							}
							if(mjoVals[3]) myww += mjoVals[3].replace(/px$/, "")*1;
							mjo.style.width = myww;
							
							//alert(ww+"-"+step+"-"+myww);
						}
					}
					if(mjo.parentNode.offsetWidth-otst  <= minw){
						  mjo.style.width = minw;
					}
					if(mjo.parentNode.offsetWidth-otst  >= maxw){
						  mjo.style.width = maxw;
					}
				}
			}
		}
		for(var mj in __stretch){
			mjo = document.getElementById(mj);
			mjoVals = explode("-", __stretch[mj]);
			pl = mjo.style.paddingLeft.replace(/px$/, '')*1;
			pr = mjo.style.paddingRight.replace(/px$/, '')*1;
			ml = mjo.style.marginLeft.replace(/px$/, '')*1;
			mr = mjo.style.marginRight.replace(/px$/, '')*1;
			otst = pl+pr+ml+ml    +  20;
			if(mjoVals[0].match(/%$/)){
					minw = mjoVals[0].replace(/px.*/, '')*1;
					minp = mjoVals[0].replace(/(^[0-9]*px:|%$)/gi, '')*1;
					maxw = mjoVals[1].replace(/px.*/, '')*1;
					maxp = mjoVals[1].replace(/(^[0-9]*px:|%$)/gi, '')*1;
					sto = maxw-minw;
					cur = mjo.parentNode.offsetWidth-otst - minw;
					mypercent = cur*100/sto;
					sto_p = maxp - minp;
					cur_p = sto_p*mypercent/100;
					exit_p = minp + cur_p;
					finalWidth = exit_p * (mjo.parentNode.offsetWidth-otst) / 100;
					mjo.style.width = finalWidth;
			} else {
				minw = mjoVals[0].replace(/px$/, '')*1;
				maxw = mjoVals[1].replace(/px$/, '')*1;
				//alert(minw + "::"+maxw)
				//document.title = window.innerWidth;
				
				if(mjo.parentNode.offsetWidth-otst  > minw && mjo.parentNode.offsetWidth-otst  < maxw){
					//alert(mjo.style.paddingLeft +":"+ mjo.style.paddingLeft +":"+ mjo.style.marginLeft +":"+ mjo.style.marginRight);
					mjo.style.width = mjo.parentNode.offsetWidth - otst;
					if(mjoVals[2]){
						var ww = Math.round(mjo.parentNode.offsetWidth - otst);
						var step = mjoVals[2].replace(/px$/, "");
						var myww;
						for(var wj=0; wj<ww; wj+=step*1){
							myww = wj;
						}
						if(mjoVals[3]) myww += mjoVals[3].replace(/px$/, "")*1;
						mjo.style.width = myww;
						//alert(ww+"-"+step+"-"+myww);
					}
				}
				if(mjo.parentNode.offsetWidth-otst  <= minw){
					  mjo.style.width = minw;
				}
				if(mjo.parentNode.offsetWidth-otst  >= maxw){
					  mjo.style.width = maxw;
				}
			}
		}	
}