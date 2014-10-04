<?
//Данный файл предназначен для разбора CSV-файлов,
//созданных в среде MSExcel.
class csvToArray {
// -------------------------------------------------------------------
//Переменные среды класса
// -------------------------------------------------------------------

// -------------------------------------------------------------------
//Функция превращает текстовый файл csv в массив
//lines, где элементом массива является линия
// -------------------------------------------------------------------
function parse($filename){
	$lines = file ($filename); //Преобразование  строк файла в массив
	foreach ($lines as $line_num => $line) // Запуск цикла разборки массива линий
		$return_array[$line_num] = $this->parse_line($line, 0, array()); // Возвращение массива данных строки посредством функции
	return $return_array; //Возвращение  полностью собранного массива
}
// -------------------------------------------------------------------
//Функция рекурсивная, преобразует строку в массив
// -------------------------------------------------------------------
function parse_line($line, $item_start, $items){ 
	$tmp_array = $this->get_item($item_start, $line); // Загрузка в массив данных, возвращенных функцией (тоже в виде массива)
	array_push ($items,  $tmp_array[1]); //Добавление в массив $items данных в виде ячейки массива $tmp_array
	$item_end = $tmp_array[0]; //Номер разделителя в конце ячейки
	
	if($item_end == strlen($line)) //Условие: равен ли последний разделитель (он же конец строки) концу строки, если да:
		return $items; // Возвратить массив
	else //если нет:
		return $this->parse_line($line, $item_end, $items); //Возвратить эту же функцию, но с другими значениями
}

// -------------------------------------------------------------------
//Функция возвращает значение ячейки из файла СиЭсВи
// -------------------------------------------------------------------
function get_item($item_start, $line){
	$ret_val = false;
	
	if(substr($line, $item_start, 1) == "\""){
		$kav_count = 0;
		$at = false;
		for($i=$item_start; $i<strlen($line); $i++){
			if(substr($line, $i, 1) == "\""){
				$kav_count++;
				$at = true;
			}
			if(substr($line, $i, 2) == "\";"  &&  $this->test_for_chet($kav_count))
				return array($i+2, preg_replace("/\"\"/", "\"", substr($line, $item_start+1, $i-$item_start-1)));
		}
		if($at){
			return array(strlen($line), preg_replace("/\"\"/", "\"",  substr($line, $item_start+1, strlen($line)-$item_start-3)));
		}
	}
	//*******************************
	else{
		for($i=$item_start; $i<strlen($line); $i++){
			if(substr($line, $i, 1) == ";"  ||   $i==strlen($line) - 1){
				if ($i == strlen($line)-1 && substr($line ,$i, 1) != ";")
					return array($i+1, preg_replace("/\"\"/", "\"", substr($line, $item_start, $i-$item_start)));
				else
					return array($i+1, substr($line, $item_start, $i-$item_start));
			}
		}
	}
	return $ret_val;
}

// -------------------------------------------------------------------
//Функция проверяет, является ли число четным
// -------------------------------------------------------------------
function test_for_chet($num){
	$test = $num/2;
	for($i=0; $i<strlen($test); $i++)
		if(substr($test, $i, 1) == ","  || substr($test, $i, 1) == ".")
			return  false;
	return true;
}
// -------------------------------------------------------------------
//Конец класса
// -------------------------------------------------------------------
}
?>