//alert(verify);
var options = {
  types: ['(cities)'],
  componentRestrictions: {country: 'ua'}
};

var city = '';
var input = false;
var verify = false;
var citiesLoaded = false;

function loadCitys(obj) {
	if(!citiesLoaded){
		input = obj;
		verify = document.getElementById("_formid_verified_city");
		options = {
		  types: ['(cities)'],
		  componentRestrictions: {country: 'ua'}
		};
		if(!verify) {
			var verify = document.createElement("INPUT");
			document.body.appendChild(verify);
			verify.id = "_formid_verified_city";
			verify.type = "hidden";
			verify.style.display = "none";
			//verify.style.display = "none";
		}
		verify.style.display = "none";
		setTimeout(function(){load__()}, 1000);
		autocomplete = new google.maps.places.Autocomplete(input, options);
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			input.blur();
			setTimeout(function(){replaceAndVerifyCity()}, 200);
		});
	}
}


function replaceAndVerifyCity(){
	place = autocomplete.getPlace();
	if(place && place['address_components']){
		input.value = place['address_components'][0].long_name + ', ' + place['address_components'][2].long_name;
		city = place['address_components'][0].long_name + ', ' + place['address_components'][2].long_name;
		verify.value = '1';
	}
}

function unverifyCity(){
	verify.value = '0';
	if(input.value.replace(/(^\s+|\s+$)/g,'') == ""){
		//input.style.border = "3px solid red";
	}else if(input.value != city){
		//input.style.border = "3px solid yellow";
	}
}

function getAbsolutePosition(el){
	var r = { x: el.offsetLeft, y: el.offsetTop };
	if (el.offsetParent){
		var tmp = getAbsolutePosition(el.offsetParent);
		r.x += tmp.x;
		r.y += tmp.y;
	}
	return r;
}

function load__(){
	var pos = input.value.length;
	input.focus();
	input.setSelectionRange(pos, pos);
	pac = document.querySelector('.pac-container');
	p = getAbsolutePosition(input);
	pac.style.width = input.clientWidth + "px";
	pac.style.left = p.x + "px";
	pac.style.top = p.y + input.clientHeignt + "px";
	pac.style.position = "absolute";
	pac.style.display = "";
	citiesLoaded = true;
}