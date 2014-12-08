<?php
class eSputnikAPI{

	private static $username = 'fruktstudio@gmail.com';
	private static $password = '6f0O10840#';
	private static $baseUrl = 'https://esputnik.com.ua/api/v1';
	private static $fromName = 'test';
	//private static $emailFrom = 'info@krasota-style.com.ua';
	//private static $emailFrom = 'stylekrasota@gmail.com';
	
	function send_request($url, $json_value, $user, $password) {
		//if(!$text || !$phone) return false;
		//$value = array(
		//	'from' => self::$fromName,
		//	'text' => $text,
		//	'phoneNumbers' => array($phone)
		//);
		//$json_value = json_encode($value);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_USERPWD, self::$username.':'.self::$password);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	function sendSMS_curl($phone=false, $text=false){
		if(!$text || !$phone) return false;
		$user = 'fruktstudio@gmail.com';
		$password = 'dEee2<034d';
		$send_sms_url = 'https://esputnik.com.ua/api/v1/message/sms';
		$from = 'lenta-dekor';
		$text = $text;
		$number = $phone;
		$json_value = new stdClass();
		$json_value->text = $text;
		$json_value->from = $from;
		$json_value->phoneNumbers = array($number);
		return $this->send_request($send_sms_url, $json_value, $user, $password);
	}
	
	function sendSMS($phone=false, $text=false){
		//$phone = "0639054324";
		//$phone = "0689220244";
		//$phone = "0681531027";
		//$phone = "0505732060";
		if(!$text || !$phone) return false;
		$value = array(
			'from' => self::$fromName,
			'text' => $text,
			'phoneNumbers' => array($phone)
		);
		$json_value = json_encode($value);
		$opts = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Authorization: Basic ' . base64_encode(self::$username.':'.self::$password) . "\r\n"
				. 'Accept: application/json' . "\r\n"
				. 'Content-Type: application/json' . "\r\n"
				. 'Content-Length: ' . strlen($json_value) . "\r\n",
				'content' => $json_value
			)
		);
		$context = stream_context_create($opts);
		$url= self::$baseUrl.'/message/sms';
		$file = file_get_contents($url, false, $context);
		echo $file;
	}
	
	/**
	 * что делает - возвращает массив комментариев по отправке email клиенту
	 *
	 * @name  		getESputnikCommentsFromPartnerId
	 * @param 		int $partnerId - ID партнёра
	 * @return 		array
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	function getESputnikCommentsFromPartnerId($partnerId){
		$comments = array(); //Желательно в начале обьявлять переменные, которые в конце будут возвращены
		$query = $this->query("SELECT * FROM `comments` WHERE `target` = '{$partnerId}' AND `type` = '5' ORDER BY `id` DESC LIMIT 0,5");
		if($query->num_rows >= '1'){
			while($comment = $query->fetch_assoc()){
				$comments[] = $comment;
			}
		}
		return $comments;
	}
	
	/**
	 * что делает - возвращает состояние отправленного сообщения из таблицы esputnik
	 *
	 * @name  		getESputnikStatus
	 * @param 		string $requestId - ID сообщения в базе esputnik.com.ua
	 * @return 		JSON
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function getESputnikStatus($requestId){
		$status = '';
		$qu = "SELECT * FROM `esputnik` WHERE `idRequest`='$requestId' ";
		$query = $this->query($qu);
		if($query->num_rows >= '1'){
			$status = $query->fetch_assoc();
		}
		return json_encode($status);
	}
	
	/**
	 * что делает - Смотрит состояние сообщения в базе esputnik.com.ua и, если состояние в таблице отличается от возвращенного, переписывает состояние в таблице 
	 *
	 * @name  		reloadESputnikStatus
	 * @param 		string $requestId - ID сообщения в базе esputnik.com.ua
	 * @return 		JSON
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function reloadESputnikStatus($requestId){
		$query = $this->query("SELECT * FROM `esputnik` WHERE `idRequest`='$requestId' ");
		if($query->num_rows >= '1'){
			$status = $query->fetch_assoc();
		}else{
			return '';
		}
		$statuses = $this->getESputnikMessageStatus($requestId);
		$statuses = json_decode($statuses, true);
		if($status['status']!=$statuses['results']['status']){
			$query = $this->query("UPDATE `esputnik` SET `status`='".$statuses['results']['status']."'  WHERE `idRequest`='$requestId' ");
		}
		return json_encode($statuses['results']);
	}
	
	/**
	 * что делает - Записывает данные об отправке сообщения в таблицу esputnik 
	 *
	 * @name  		addMessageToESputnik
	 * @param 		string $requestId - ID сообщения в базе esputnik.com.ua
	 * @param 		int $operatorId - ID оператора
	 * @param 		int $partnerId - ID клиента
	 * @param 		int $campainId - ID кампании рассылки
	 * @return 		void
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function addMessageToESputnik($requestId, $operatorId, $partnerId, $campainId=false){
		$statuses = $this->getESputnikMessageStatus($requestId);
		$statuses = json_decode($statuses, true);
		//print_r($statuses);
		$query = $this->query("INSERT INTO `esputnik` (`idRequest`, `idOperator`, `idPartner`, `status`) 
		VALUES ('$requestId', $operatorId, $partnerId, '".$statuses['results']['status']."')");
	}
	
	/**
	 * что делает - Отправляет сообщение через сервис esputnik 
	 *
	 * @name  		sendEmail
	 * @param 		string $emailTo - e-mail получателя
	 * @param 		string $subject - тема сообщения
	 * @param 		string $HTMLText - текст HTML
	 * @param 		string $text - простой текст
	 * @return 		JSON
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function sendEmail($emailTo, $subject, $HTMLText='', $text=''){
		if(is_array($emailTo)){
			$emails = $emailTo;
		}else{
			$emails = array($emailTo);
		}
		$value = array(
			'from' => self::$emailFrom,
			'subject' => $subject,
			'htmlText' => $HTMLText,
			'plainText' => $text,
			'emails' => $emails
		);
		$json_value = json_encode($value);
		$opts = array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Authorization: Basic ' . base64_encode(self::$username.':'.self::$password) . "\r\n"
				. 'Accept: application/json' . "\r\n"
				. 'Content-Type: application/json' . "\r\n"
				. 'Content-Length: ' . strlen($json_value) . "\r\n",
				'content' => $json_value
			)
		);
		$context = stream_context_create($opts);
		$url= self::$baseUrl.'/message/email/';
		$file = file_get_contents($url, false, $context);
		return $file;
	}
	
	/**
	 * что делает - Получает список тем сообщений esputnik .com.ua
	 *
	 * @name  		getESputnikMessages
	 * @return 		JSON
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function getESputnikMessages(){
		$opts = array(
			'http' => array(
				'header' => 'Authorization: Basic ' . base64_encode(self::$username.':'.self::$password) . "\r\n"
				. 'Content-Type: application/json' . "\r\n"
			)
		);
		$context = stream_context_create($opts);
		$url= self::$baseUrl.'/messages/email/';
		$file = file_get_contents($url, false, $context);
		return $file;
	}
	
	/**
	 * что делает - Получает заголовок и тело сообщения по id esputnik.com.ua
	 *
	 * @name  		getESputnikMessages
	 * @param 		int $id - ID сообщения в базе esputnik.com.ua
	 * @return 		JSON
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function getESputnikMessage($id){
		$opts = array(
			'http' => array(
				'header' => 'Authorization: Basic ' . base64_encode(self::$username.':'.self::$password) . "\r\n"
				. 'Content-Type: application/json' . "\r\n"
			)
		);
		$context = stream_context_create($opts);
		$url= self::$baseUrl.'/messages/email/'.$id;
		$file = file_get_contents($url, false, $context);
		return $file;
	}
	
	/**
	 * что делает - Получает состояние отправки письма по id esputnik.com.ua
	 *
	 * @name  		getESputnikMessages
	 * @param 		string $requestId - ID сообщения в базе esputnik.com.ua
	 * @return 		JSON
	 * @author  	Олександр <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	
	function getESputnikMessageStatus($requestId){
		$opts = array(
			'http' => array(
				'header' => 'Authorization: Basic ' . base64_encode(self::$username.':'.self::$password) . "\r\n"
				. 'Content-Type: application/json' . "\r\n"
			)
		);
		$context = stream_context_create($opts);
		$url= self::$baseUrl.'/message/email/status?ids='.$requestId;
		$file = file_get_contents($url, false, $context);
		return $file;
	}
	
}
?>