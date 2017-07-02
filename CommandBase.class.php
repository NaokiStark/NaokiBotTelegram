<?php

class CommandBase{
	var $Message;
	var $CommandName;
	var $CommandDescription;
	var $MainBot;
	var $Args;

	public function __construct($message, $mainBot, $args, $commandName, $commandDescription){
		$this->Message = $message;
		$this->CommandName = $commandName;
		$this->CommandDescription = $commandDescription;
		$this->MainBot = $mainBot;
		$this->Args = $args;
	}	
}