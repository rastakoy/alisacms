function addToFilter(shotname, pid, mfilter, fobj){
	if(fobj.checked)
		paction = "paction=addToFilter&sn="+shotname+"&pid="+pid+"&mfilter="+mfilter;
	else
		paction = "paction=addToFilter&sn="+shotname+"&pid="+pid+"&mfilter="+mfilter+"&del=1";
	//alert(paction);
	var __ajax_url = "filter/__ajax_simple_filter.php";
	$.ajax({
			type: "POST",
			url: __ajax_url,
			data: paction,
			success: function(html) {
				//alert(html);
				//alert(window.location.href);
				window.location.href=window.location.href;
				//document.getElementById('divinfo').innerHTML += "Произведено восстановление записи «"+html+"»<br/>\n"; //html;
			}
	});
}
//**************************************
