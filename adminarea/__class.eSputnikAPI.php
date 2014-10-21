<?php
class eSputnikAPI{

	private static $username = 'fruktstudio@gmail.com';
	private static $password = 'dEee2<034d';
	private static $baseUrl = 'https://esputnik.com.ua/api/v1';
	//private static $emailFrom = 'info@krasota-style.com.ua';
	//private static $emailFrom = 'stylekrasota@gmail.com';
	
	function sendSMS($phone=false, $text=false){
		//$phone = "0639054324";
		//$phone = "0689220244";
		$phone = "0681531027";
		$text = "��� ��� � ���������� ���";
		$value = array(
			'from' => "test",
			'text' => "send TTN",
			'phoneNumbers' => array($phone)
		);
		print_r($value);
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
		//return $file;
	}
	
	/**
	 * ��� ������ - ���������� ������ ������������ �� �������� email �������
	 *
	 * @name  		getESputnikCommentsFromPartnerId
	 * @param 		int $partnerId - ID ��������
	 * @return 		array
	 * @author  	��������� <fruktstudio@gmail.com>
	 * @version 	1.0
	 */
	function getESputnikCommentsFromPartnerId($partnerId){
		$comments = array(); //���������� � ������ ��������� ����������, ������� � ����� ����� ����������
		$query = $this->query("SELECT * FROM `comments` WHERE `target` = '{$partnerId}' AND `type` = '5' ORDER BY `id` DESC LIMIT 0,5");
		if($query->num_rows >= '1'){
			while($comment = $query->fetch_assoc()){
				$comments[] = $comment;
			}
		}
		return $comments;
	}
	
	/**
	 * ��� ������ - ���������� ��������� ������������� ��������� �� ������� esputnik
	 *
	 * @name  		getESputnikStatus
	 * @param 		string $requestId - ID ��������� � ���� esputnik.com.ua
	 * @return 		JSON
	 * @author  	��������� <fruktstudio@gmail.com>
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
	 * ��� ������ - ������� ��������� ��������� � ���� esputnik.com.ua �, ���� ��������� � ������� ���������� �� �������������, ������������ ��������� � ������� 
	 *
	 * @name  		reloadESputnikStatus
	 * @param 		string $requestId - ID ��������� � ���� esputnik.com.ua
	 * @return 		JSON
	 * @author  	��������� <fruktstudio@gmail.com>
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
	 * ��� ������ - ���������� ������ �� �������� ��������� � ������� esputnik 
	 *
	 * @name  		addMessageToESputnik
	 * @param 		string $requestId - ID ��������� � ���� esputnik.com.ua
	 * @param 		int $operatorId - ID ���������
	 * @param 		int $partnerId - ID �������
	 * @param 		int $campainId - ID �������� ��������
	 * @return 		void
	 * @author  	��������� <fruktstudio@gmail.com>
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
	 * ��� ������ - ���������� ��������� ����� ������ esputnik 
	 *
	 * @name  		sendEmail
	 * @param 		string $emailTo - e-mail ����������
	 * @param 		string $subject - ���� ���������
	 * @param 		string $HTMLText - ����� HTML
	 * @param 		string $text - ������� �����
	 * @return 		JSON
	 * @author  	��������� <fruktstudio@gmail.com>
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
	 * ��� ������ - �������� ������ ��� ��������� esputnik .com.ua
	 *
	 * @name  		getESputnikMessages
	 * @return 		JSON
	 * @author  	��������� <fruktstudio@gmail.com>
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
	 * ��� ������ - �������� ��������� � ���� ��������� �� id esputnik.com.ua
	 *
	 * @name  		getESputnikMessages
	 * @param 		int $id - ID ��������� � ���� esputnik.com.ua
	 * @return 		JSON
	 * @author  	��������� <fruktstudio@gmail.com>
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
	 * ��� ������ - �������� ��������� �������� ������ �� id esputnik.com.ua
	 *
	 * @name  		getESputnikMessages
	 * @param 		string $requestId - ID ��������� � ���� esputnik.com.ua
	 * @return 		JSON
	 * @author  	��������� <fruktstudio@gmail.com>
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