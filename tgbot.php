<?php

/*

* TgBot by Fabi (Naoki codename)
* Licence: All rights reserved
* Permisions: Free to use by including credits to the original author (Me, Fabi).

- Config Statics Values Below

*/

require_once 'Message.class.php';
require_once 'User.class.php';
require_once 'Downloadable.class.php';
require_once 'Audio.class.php';
require_once 'Chat.class.php';
require_once 'PhotoSize.class.php';
require_once 'Sticker.class.php';
require_once 'Video.class.php';
require_once 'Voice.class.php';
require_once 'Response.class.php';
require_once 'ScriptsHelper.class.php';
require_once 'CommandBase.class.php';


class TgBot{

	public static $BotToken = ""; //replace w telegram token | Colocar el token del bot
	public static $FatherId = "0"; //replace w admin id, aka Father | Colocar el id del creador del bot //Opcional 
	public static $BotName = ""; //replace w bot name | Colocar el nombre del bot 
	public static $BotAlias = ""; //Ej: $ or % or > | Prefijo para el comando
	var $Request; // Request.class.php object 
	var $Stream = ""; //Main Message Stream
	var $JsonMessage = ""; //Message parsed in array
	var $Url;
	var $Message; //Message object

	public function __construct($stream){

		$this->Request = new Requests();

		$this->Stream = $stream;
		$this->JsonMessage = json_decode($stream, true);
		$this->Url = "https://api.telegram.org/" . self::$BotToken . "/";

		$this->Message = new Message();
		$this->Message->Parse($this->JsonMessage);
		
		$this->Process();
	}
	
	public function Process(){

		

		if(startsWith($this->Message->Text, self::$BotName)){
			$text = str_replace_first(self::$BotName,'', $this->Message->Text);
			$text = trim($text);
			error_log($text);
			$this->ProcessCommand($text);
		}
		elseif (startsWith($this->Message->Text, self::$BotAlias)) {
			$text = str_replace_first(self::$BotAlias,'', $this->Message->Text);

			$text = trim($text);
			error_log($text);
			$this->ProcessCommand($text, true);
		}	
		else{


			if(contains(strtolower($this->Message->Text), strtolower(self::$BotName)) || !isset($this->Message->Chat->Title)){
				$this->SendChatAction(); //Bot is typing
				//IA - not included :D
			}

		}

	}

	public function ProcessCommand($text, $calledByAlias = false){

		$scriptsHelper = new ScriptsHelper($this->Message, self::$BotAlias);

		$arrtxt = explode(" ", $text, 2); //0: command; 1: args

		if(!$scriptsHelper->CommandExist($arrtxt[0])){
			if(!$calledByAlias){
				$this->SendChatAction(); //Bot is typing
				
				$toSend = new Response($this->Message, "El comando no existe.", true);
				$this->SendMessage($toSend->ToArray());
			}
			else{
				$this->SendChatAction(); //Bot is typing
				$toSend = new Response($this->Message, 'El comando no existe.', true);
				$this->SendMessage($toSend->ToArray());
			}
		}

				
		$this->SendChatAction(); //Bot is typing
		$scriptsHelper->Execution($arrtxt[0], $arrtxt[1], $this);

	}


	public function SendMessage($params){

		$this->Request->postRequest($this->Url . 'sendMessage', $params);

	}

	public function SendChatAction(){

		$toSend = new Response($this->Message, '');

		$params = $toSend->ToArray();

		$params['action'] = 'typing';

		$this->Request->postRequest($this->Url . 'sendChatAction', $params);
	}

	public function SendPictureFromFile($filename, $text, $userReply = false){
		
		$params = array('chat_id' => $this->Message->Chat->Id);

		if($userReply){
			$params['reply_to_message_id'] = $this->Message->Id;
		}

		if($text != ""){
			$params['caption'] = $text;
		}

		$this->Request->UploadFile($this->Url . 'sendPhoto', $params, $filename,'photo');
	}

	public function SendPictureFromId($tgFileId, $text, $userReply = false){
		

		$params = array('chat_id' => $this->Message->Chat->Id,
						'photo' => $tgFileId);

		if($userReply){
			$params['reply_to_message_id'] = $this->Message->Id;
		}

		if($text != ""){
			$params['caption'] = $text;
		}

		return $this->Request->postRequest($this->Url . 'sendPhoto', $params);

	}

	public function SendPictureFromUrl($url, $text, $userReply = false){

		return $this->SendPictureFromId($url, $text, $userReply);
	}

	public function SendSticker($tgFileId, $text, $userReply = false){

		$params = array('chat_id' => $this->Message->Chat->Id,
						'sticker' => $tgFileId);

		if($userReply){
			$params['reply_to_message_id'] = $this->Message->Id;
		}

		if($text != ""){
			$params['caption'] = $text;
		}

		$this->Request->postRequest($this->Url . 'sendSticker', $params);
	}

	public function SendAudioFromFile($filename, $text, $title, $performer, $userReply = false){
		
		$params = array('chat_id' => $this->Message->Chat->Id);

		if($userReply){
			$params['reply_to_message_id'] = $this->Message->Id;
		}

		if($text != ""){
			$params['caption'] = $text;
		}

		if($title != ""){
			$params['title'] = $text;
		}

		if($performer != ""){
			$params['performer'] = $text;
		}

		$this->Request->UploadFile($this->Url . 'sendAudio', $params, $filename, 'audio');
	}

}

function startsWith($haystack, $needle) {
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}


function str_replace_first($from, $to, $subject)
{
    $from = '/'.preg_quote($from, '/').'/i';


    return preg_replace($from, $to, $subject, 1);
}

function str_replace_all($from, $to, $subject)
{
    $from = '/\s*'.preg_quote($from, '/').'\s*/i';


    return preg_replace($from, $to, $subject);
}

function contains($a,$b){
	return $b === "" || (strpos($a,$b) !== false)?true:false;
}

function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}
