<?php

class ScriptsHelper{

	var $Message;
	var $Alias;
	
	var $CommandsArr;

	public function __construct($message, $alias){

		$this->Message = $message;
		$this->Alias = $alias;

		$this->getCommands();

	}

	function getCommands(){
		$dir = __DIR__."/Commands";

		$this->CommandsArr = scandir($dir);

	}


	public function CommandExist($command){

		$file = $command.'.php';

		return in_array(basename($file), $this->CommandsArr);

	}

	public function Execution($command, $args, $mainBot){

		$command = strtolower($command);

		require_once "./Commands/" . basename($command . ".php");

		$script = new ScriptExecutor($this->Message, $mainBot, $args);

		$script->Run();

		return false;
	}
}