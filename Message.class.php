<?php

class Message{

	var $Id;
	var $From;
	var $Date;
	var $Chat;
	var $ForwardFrom;
	var $ForwardFromChat;
	var $ForwardFromMessageId;
	var $ForwardDate;
	var $ReplyToMessage;
	var $EditDate;
	var $Text;
	var $Entities; //ToDo
	var $Audio;
	var $Document;
	var $Game; //ToDo
	var $Photo; //PhotoSizeObject
	var $Sticker;
	var $Video; //VideoObject 
	var $Voice; //VoiceObject
	var $VideoNote; //ToDo
	var $NewChatMenbers; //Array of Users Objects
	var $Caption; //ToDo
	var $Contact; //Useless
	Var $Location; //ToDo

	public function Parse($j){
		$m = $j['message'];
		
		$this->Id = $m['message_id'];

		$From = new User();
		$From->Parse($m['from']);

		$this->From = $From;

		$Chat = new Chat();
		$Chat->Parse($m['chat']);

		$this->Chat = $Chat;

		$this->Date = $m['date'];

		$this->Text = $m['text'];

	}
}