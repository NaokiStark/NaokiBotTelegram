<?php

class Response{

	var $Text;
	var $ParseMode;
	var $Reply;
	var $Message;

	public function __construct($messageObj, $text, $reply = false, $parse_mode = 'Markdown'){
		$this->Text = $text;
		$this->ParseMode = $parse_mode;
		$this->Reply = $reply;
		$this->Message = $messageObj;
	}

	public function ToArray(){

		$toSend =  array('chat_id' => $this->Message->Chat->Id,
					 'text' => $this->Text,
					 'parse_mode' => $this->ParseMode);

		if($this->Reply){
			$toSend['reply_to_message_id'] = $this->Message->Id;
		}

		return $toSend;

	}

}