<?php

class ScriptExecutor extends CommandBase{

	public function __construct($message, $mainBot, $args){
		parent::__construct($message, $mainBot, $args, "ping", "Comando ping, responde con pong");
	}

	public function Run(){

		$data = file_get_contents("https://api.coindesk.com/v1/bpi/currentprice.json");

		$parsed = json_decode($data, true);

		$toSend = new Response($this->Message, 'El precio actual promedio de BTC-USD es: $' . $parsed['bpi']['rate'], true); //true: responde mensaje

		$this->MainBot->SendMessage($toSend->ToArray());
	}

}