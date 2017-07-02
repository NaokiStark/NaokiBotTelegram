<?php

class User{

	var $Id;
	var $Nick;
	var $Name;
	var $LastName;
	var $LanguageCode;

	public function Parse($a){

		$this->Id = $a['id'];
		$this->Nick = $a['username'];
		$this->Name = $a['first_name'];
		$this->LastName = $a['last_name'];
		$this->LanguageCode = $a['language_code'];

	}
}