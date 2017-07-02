<?php

class ScriptExecutor extends CommandBase{

	public function __construct($message, $mainBot, $args){
		parent::__construct($message, $mainBot, $args, "ping", "Comando ping, responde con pong");
	}

	public function Run(){

		$toSend = new Response($this->Message, 'Pong!', true);

		$this->MainBot->SendMessage($toSend->ToArray());
	}

}