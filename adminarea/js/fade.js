/*
wwww.tigir.com - 29.06.2006

Source: http://www.tigir.com/js/fade.js

���������� fade.js �� ������ "����������� ��������� ������ (fade-�������)" - http://www.tigir.com/fade.htm
*/
function fade(sElemId, sRule, bBackward)
{
	if (!document.getElementById(sElemId)) return;//���� ��� �������� � �������� id �������
	
	var aRuleList = sRule.split(/\s*,\s*/);//sRule ����� ���� ������� ������ ����������� �������, ��������� ������ �� ������
	
	//��������� ������� ��� ������� ������� ��������
	for (var j	= 0; j < aRuleList.length; j++)
	{
		sRule = aRuleList[j];
		
		if (!fade.aRules[sRule]) continue;//���� ������� �� ���� ����������, �� ���������� � ���������� �������
		
		//�������������� ������ �������� �����
		var i=0;
		
		if (!fade.aProc[sElemId])//���� � �������� � �������� id ��� �� ���������� �������, �� ������� ������ ��������� � ���������� ������ ��������
		{
			fade.aProc[sElemId] = {};
		}
		else if (fade.aProc[sElemId][sRule]) //���� � �������� ��� ����������� ������� sRule, �� ���������� ��������� ����������� �������� � ������������� ���
		{
			i = fade.aProc[sElemId][sRule].i;
			clearInterval(fade.aProc[sElemId][sRule].tId);
		}
		
		//���� ���� �������� ����� ���������� � ������������� ������� � ���������� �����, ��� ���� �������� ����� ��������� � ������������� ������ �������� �� �������, ������ ������ �� �����
		if ((i==0 && bBackward) || (i==fade.aRules[sRule][3] && !bBackward)) continue;
		
		//�������������� ������� ������� � �������� ������� ������� �������� � ������ ���������
		fade.aProc[sElemId][sRule] = {'i':i, 'tId':setInterval('fade.run("'+sElemId+'","'+sRule+'")', fade.aRules[sRule][4]),'bBackward':Boolean(bBackward)};
	}
}

fade.aProc = {};//������ ����������� ���������
fade.aRules = {};//�������������� ������ � ������������� ���������, ����������� ������� fade.addRule  

//������ ����� ��������� ����� �����, ����������� �������� fade
fade.run = function(sElemId, sRule)
{
	//��� ������ ��� �������� ������ ������� �� �������� fade.aRules
	
    fade.aProc[sElemId][sRule].i += fade.aProc[sElemId][sRule].bBackward?-1:1;//�������� ������ �������������� �����
 	var finishPercent = fade.aProc[sElemId][sRule].i/fade.aRules[sRule][3]; //������� ���������� ��������� ����� � ������� ������������� �����;  ���������� �� 0 (�� ������� 0) �� 1 (1 = 100%)
	var startPercent = 1 - finishPercent; //������� ���������� ���������� ����� � ������� ������������� �����; ���������� �� 1 �� 0 (1 = 100%)
	
	var aRGBStart = fade.aRules[sRule][0];
	var aRGBFinish = fade.aRules[sRule][1];
	
	//��������� �������� ��������, ��������, ������ �������������� �����
    document.getElementById(sElemId).style[fade.aRules[sRule][2]] = 'rgb('+ 
	Math.floor( aRGBStart['r'] * startPercent + aRGBFinish['r'] * finishPercent ) + ','+
	Math.floor( aRGBStart['g'] * startPercent + aRGBFinish['g'] * finishPercent ) + ','+
	Math.floor( aRGBStart['b'] * startPercent + aRGBFinish['b'] * finishPercent ) +')';
	
	// ���� ��� ��������� ��� ������������� ����� �� ������������� �������
	if ( fade.aProc[sElemId][sRule].i == fade.aRules[sRule][3] || fade.aProc[sElemId][sRule].i ==0) clearInterval(fade.aProc[sElemId][sRule].tId); 
}

fade.back = function (sElemId, sRule){fade(sElemId, sRule, true);};

fade.addRule = function (sRuleName, sFadeStartColor, sFadeFinishColor, sCSSProp, nMiddleColors, nDelay)
{
	fade.aRules[sRuleName] = [fade.splitRGB(sFadeStartColor), fade.splitRGB(sFadeFinishColor), fade.ccs2js(sCSSProp), nMiddleColors || 50, nDelay || 1];
};

//������� ��� �������� ������������������ ����� �� �������� ��������, �������� � ������ � ���� �������, ��������, #FF0 � ['r':255, 'g':255, 'b':0]
fade.splitRGB = function (color){var rgb = color.replace(/[# ]/g,"").replace(/^(.)(.)(.)$/,'$1$1$2$2$3$3').match(/.{2}/g); for (var i=0;  i<3; i++) rgb[i] = parseInt(rgb[i], 16); return {'r':rgb[0],'g':rgb[1],'b':rgb[2]};};
//������� ��� �������������� CSS �������� �������� � �������������� ��� Javascript ��������, ��������, border-color � borderColor
fade.ccs2js = function (prop){var i; while ((i=prop.indexOf("-"))!=-1) prop = prop.substr(0, i) + prop.substr(i+1,1).toUpperCase() + prop.substr(i+2); return prop;};

//���� ��������� IE5 �� �����, �� ����� fade.ccs2js �������� �� ����� ������� �������
//fade.ccs2js = function(cssProperty){return cssProperty.replace(/\-(.)/g,function(){return arguments[1].toUpperCase();});};