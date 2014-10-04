/*
wwww.tigir.com - 29.06.2006

Source: http://www.tigir.com/js/fade.js

Библиотека fade.js из статьи "Постепенное изменение цветов (fade-эффекты)" - http://www.tigir.com/fade.htm
*/
function fade(sElemId, sRule, bBackward)
{
	if (!document.getElementById(sElemId)) return;//если нет элемента с заданным id выходим
	
	var aRuleList = sRule.split(/\s*,\s*/);//sRule может быть списком правил разделенных запятой, разбивает строку на массив
	
	//Запускаем фейдинг для каждого правила отдельно
	for (var j	= 0; j < aRuleList.length; j++)
	{
		sRule = aRuleList[j];
		
		if (!fade.aRules[sRule]) continue;//если правило не было определено, то переходиим к следующему правилу
		
		//инициализируем индекс текущего цвета
		var i=0;
		
		if (!fade.aProc[sElemId])//если к элементу с заданным id ещё не применялся фейдинг, то готовим список процессов к добавлению нового элемента
		{
			fade.aProc[sElemId] = {};
		}
		else if (fade.aProc[sElemId][sRule]) //если к элементу уже применялось правило sRule, то запоминаем состояние предыдущего процесса и останавливаем его
		{
			i = fade.aProc[sElemId][sRule].i;
			clearInterval(fade.aProc[sElemId][sRule].tId);
		}
		
		//Если цвет элемента равен начальному и запрашивается возврат к начальному цвету, или цвет элемента равен конечному и запрашивается запуск фейдинга то выходим, делать ничего не нужно
		if ((i==0 && bBackward) || (i==fade.aRules[sRule][3] && !bBackward)) continue;
		
		//инициализируем процесс запуска и помещаем текущий процесс фейдинга в список процессов
		fade.aProc[sElemId][sRule] = {'i':i, 'tId':setInterval('fade.run("'+sElemId+'","'+sRule+'")', fade.aRules[sRule][4]),'bBackward':Boolean(bBackward)};
	}
}

fade.aProc = {};//массив выполняемых процессов
fade.aRules = {};//ассоциативного массив с определенными правилами, заполняется методом fade.addRule  

//Данный метод выполняет смену цвета, запускается функцией fade
fade.run = function(sElemId, sRule)
{
	//все нужные для фейдинга данный берутся из свойства fade.aRules
	
    fade.aProc[sElemId][sRule].i += fade.aProc[sElemId][sRule].bBackward?-1:1;//изменяем индекс промежуточного цвета
 	var finishPercent = fade.aProc[sElemId][sRule].i/fade.aRules[sRule][3]; //процент содержания конечного цвета в текущем промежуточном цвете;  изменяется от 0 (не включая 0) до 1 (1 = 100%)
	var startPercent = 1 - finishPercent; //процент содержания начального цвета в текущем промежуточном цвете; изменяется от 1 до 0 (1 = 100%)
	
	var aRGBStart = fade.aRules[sRule][0];
	var aRGBFinish = fade.aRules[sRule][1];
	
	//вычисляем значения красного, зеленого, синего промежуточного цвета
    document.getElementById(sElemId).style[fade.aRules[sRule][2]] = 'rgb('+ 
	Math.floor( aRGBStart['r'] * startPercent + aRGBFinish['r'] * finishPercent ) + ','+
	Math.floor( aRGBStart['g'] * startPercent + aRGBFinish['g'] * finishPercent ) + ','+
	Math.floor( aRGBStart['b'] * startPercent + aRGBFinish['b'] * finishPercent ) +')';
	
	// если уже перебраны все промежуточные цвета то останавливаем процесс
	if ( fade.aProc[sElemId][sRule].i == fade.aRules[sRule][3] || fade.aProc[sElemId][sRule].i ==0) clearInterval(fade.aProc[sElemId][sRule].tId); 
}

fade.back = function (sElemId, sRule){fade(sElemId, sRule, true);};

fade.addRule = function (sRuleName, sFadeStartColor, sFadeFinishColor, sCSSProp, nMiddleColors, nDelay)
{
	fade.aRules[sRuleName] = [fade.splitRGB(sFadeStartColor), fade.splitRGB(sFadeFinishColor), fade.ccs2js(sCSSProp), nMiddleColors || 50, nDelay || 1];
};

//функция для разбивки шестнадцатиричного цвета на значения красного, зеленого и синего в виде массива, например, #FF0 в ['r':255, 'g':255, 'b':0]
fade.splitRGB = function (color){var rgb = color.replace(/[# ]/g,"").replace(/^(.)(.)(.)$/,'$1$1$2$2$3$3').match(/.{2}/g); for (var i=0;  i<3; i++) rgb[i] = parseInt(rgb[i], 16); return {'r':rgb[0],'g':rgb[1],'b':rgb[2]};};
//функция для преобразования CSS названия свойства в соответсвующее ему Javascript свойство, например, border-color в borderColor
fade.ccs2js = function (prop){var i; while ((i=prop.indexOf("-"))!=-1) prop = prop.substr(0, i) + prop.substr(i+1,1).toUpperCase() + prop.substr(i+2); return prop;};

//Если поддержка IE5 не нужна, то можно fade.ccs2js заменить на более изящное решение
//fade.ccs2js = function(cssProperty){return cssProperty.replace(/\-(.)/g,function(){return arguments[1].toUpperCase();});};