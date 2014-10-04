<?
//ПРОГРАММА РАБОТАЕТ ТОЛЬКО С ФАЙЛАМИ JPG !!!
//© Интертехнология, г. Полтава. mailto: intert@rambler.ru
//Фон должен задаваться в формате RRR:GGG:BBB  в переменную $bgcolor=255:255:255 (белый фон)
$link = $_GET["link"];
$resize = $_GET["resize"];
$resize_x = $_GET["resize_x"];
$resize_y = $_GET["resize_y"];
if(!$link) exit(); //Если не задан путь к исходному файлу, то выход
if(!$resize && !$resize_x) exit(); // Усли не задан размер - тоже выход

$image = $link; //Переменная $image получает путь к исходному файлу

if(!preg_match('/^models_images/', $image) && !preg_match('/^loadimages/', $image) && !preg_match('/^sp_images/', $image) && !preg_match('/^marks/', $image))
$image = "loadimages/".$link;


//if($type == "limages")
//        $image = "limages/".$link;
//if($type == "nimages")
//        $image = "nimages/".$link;
//if($type == "cont_images")
//        $image = "cont_images/".$link;

//$subtitr = "images/gym_sn.png";
//if(eregi("marks/", $link)) $subtitr=false;

//---------------------------------------------------------
//Подготовка размеров нового изображения:
//$new_w = Ширина формируемого изображения
//$new_h = Высота формируемого изображения

//Так будет выглядеть изображение формата 4:3:
if($resize){
$new_w = $resize; // Определение ширины
$new_h = $resize/4*3; // Определение высоты
}
//Иначе так будет заданы переменные $resize_x и $resize_y
else{
$new_w = $resize_x; // Определение ширины
$new_h = $resize_y; // Определение высоты

}
//echo $new_w."x".$_new_h;
//---------------------------------------------------------

//---------------------------------------------------------
//Определение высоты и ширины изображения вставленного в рамку $new_w(ширина);$new_h(высота) - см. выше.
$image_in=imagecreatefromjpeg($image); //Создаем объект $image_in, в который будет помещено исходящее изображение
$img_w = imagesx($image_in);  //Ширина изображения
$img_h = imagesy($image_in); //Высота изображения
$max_w = $new_w; //Максимально допустимая ширина по оси Х
$max_h = $new_h; //Максимально допустимая высота по оси У
	//Формула разработанная Оксаной Кочубей (© Интертехнология)  по определению всех величин {--
	if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
		if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
			$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //Ширина изображения (в соответствии с рамкой)
			$img_h = $max_h;  //Высота изображения (в соответствии с ограничивающей рамкой)
		} else {
			$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //Высота изображения (в соответствии c рамкой)
			$img_w = $max_w;  //Ширина изображения (в соответствии с ограничивающей рамкой)
		}
	}
	//     --}
	// Отцентровывание изображения по осям Х и У
	$center_x = $max_w/2-$img_w/2;
	$center_y = $max_h/2-$img_h/2;

$image_out=imagecreatetruecolor($new_w,$new_h); //Создаем объект выходного изображения
if(!$bgcolor){
	$bg = imagecolorallocate($image_out, 255,255,255); //Определяем фон изображения:
}  else  {
	$bgcolor =  explode(":", $bgcolor);
	$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //Задаем фон изображения:
}

//Заливаем прямоугольник выходного изображения фоном:
imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
//Перемещаем в прямоугольник выходного изображения, изменяя размер, исходное изображение:
imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));


if($subtitr){
	$img_logo=imagecreatefrompng($subtitr); //Создаем объект изображения логотипа
	//Банальная процедура просчета размеров логотипа, перед наложением поверх изображения
	if($new_w>=600 && $new_h>=600) 
		$logo_w = 600;
	elseif($new_w>=600 && $new_h<600) 
		$logo_w = $new_h;
	else
		if($new_h>=$new_w) $logo_w = $new_w;
		else $logo_w = $new_h;
	//Отцентрирование изображения логотипа
	$center_x = 10; //$new_w/2 - $logo_w/2;
	$center_y = $new_h/2 - $logo_w/2;
	// Наложение логотипа на изображение:
	imagecopyresampled($image_out,$img_logo,$center_x,$center_y,0,0, $logo_w,$logo_w,imagesx($img_logo),imagesy($img_logo));
}

header("Content-type: image/jpeg");
imagejpeg($image_out, '', 90); //Выходное изображение с качеством 75% (дабы не перегружать объемами)
?>