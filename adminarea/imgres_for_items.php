<?
//��������� �������� ������ � ������� JPG !!!
//� ���������������, �. �������. mailto: intert@rambler.ru
//��� ������ ���������� � ������� RRR:GGG:BBB  � ���������� $bgcolor=255:255:255 (����� ���)
$link = $_GET["link"];
$resize = $_GET["resize"];
$resize_x = $_GET["resize_x"];
$resize_y = $_GET["resize_y"];
if(!$link) exit(); //���� �� ����� ���� � ��������� �����, �� �����
if(!$resize && !$resize_x) exit(); // ���� �� ����� ������ - ���� �����

$image = $link; //���������� $image �������� ���� � ��������� �����

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
//���������� �������� ������ �����������:
//$new_w = ������ ������������ �����������
//$new_h = ������ ������������ �����������

//��� ����� ��������� ����������� ������� 4:3:
if($resize){
$new_w = $resize; // ����������� ������
$new_h = $resize/4*3; // ����������� ������
}
//����� ��� ����� ������ ���������� $resize_x � $resize_y
else{
$new_w = $resize_x; // ����������� ������
$new_h = $resize_y; // ����������� ������

}
//echo $new_w."x".$_new_h;
//---------------------------------------------------------

//---------------------------------------------------------
//����������� ������ � ������ ����������� ������������ � ����� $new_w(������);$new_h(������) - ��. ����.
$image_in=imagecreatefromjpeg($image); //������� ������ $image_in, � ������� ����� �������� ��������� �����������
$img_w = imagesx($image_in);  //������ �����������
$img_h = imagesy($image_in); //������ �����������
$max_w = $new_w; //����������� ���������� ������ �� ��� �
$max_h = $new_h; //����������� ���������� ������ �� ��� �
	//������� ������������� ������� ������� (� ���������������)  �� ����������� ���� ������� {--
	if ($max_h<imagesy($image_in) || $max_w<imagesx($image_in)) {
		if ($max_w/imagesx($image_in)>=$max_h/imagesy($image_in)) {
			$img_w = imagesx($image_in)*$max_h/imagesy($image_in);  //������ ����������� (� ������������ � ������)
			$img_h = $max_h;  //������ ����������� (� ������������ � �������������� ������)
		} else {
			$img_h = imagesy($image_in)*$max_w/imagesx($image_in);  //������ ����������� (� ������������ c ������)
			$img_w = $max_w;  //������ ����������� (� ������������ � �������������� ������)
		}
	}
	//     --}
	// ��������������� ����������� �� ���� � � �
	$center_x = $max_w/2-$img_w/2;
	$center_y = $max_h/2-$img_h/2;

$image_out=imagecreatetruecolor($new_w,$new_h); //������� ������ ��������� �����������
if(!$bgcolor){
	$bg = imagecolorallocate($image_out, 255,255,255); //���������� ��� �����������:
}  else  {
	$bgcolor =  explode(":", $bgcolor);
	$bg = imagecolorallocate($image_out, $bgcolor[0],$bgcolor[1],$bgcolor[2]); //������ ��� �����������:
}

//�������� ������������� ��������� ����������� �����:
imagefilledrectangle($image_out, 0, 0, $new_w, $new_h, $bg);
//���������� � ������������� ��������� �����������, ������� ������, �������� �����������:
imagecopyresampled($image_out,$image_in,$center_x,$center_y,0,0, $img_w,$img_h,imagesx($image_in),imagesy($image_in));


if($subtitr){
	$img_logo=imagecreatefrompng($subtitr); //������� ������ ����������� ��������
	//��������� ��������� �������� �������� ��������, ����� ���������� ������ �����������
	if($new_w>=600 && $new_h>=600) 
		$logo_w = 600;
	elseif($new_w>=600 && $new_h<600) 
		$logo_w = $new_h;
	else
		if($new_h>=$new_w) $logo_w = $new_w;
		else $logo_w = $new_h;
	//��������������� ����������� ��������
	$center_x = 10; //$new_w/2 - $logo_w/2;
	$center_y = $new_h/2 - $logo_w/2;
	// ��������� �������� �� �����������:
	imagecopyresampled($image_out,$img_logo,$center_x,$center_y,0,0, $logo_w,$logo_w,imagesx($img_logo),imagesy($img_logo));
}

header("Content-type: image/jpeg");
imagejpeg($image_out, '', 90); //�������� ����������� � ��������� 75% (���� �� ����������� ��������)
?>