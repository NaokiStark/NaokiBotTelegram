<?php

class Chat{

	var $Id;
	var $Type;
	var $Title;
	var $Username;
	var $Name;
	var $LastName;
	var $AllMembersAreAdministrators;

	public function Parse($a){

		$this->Id = $a['id'];
		$this->Type = $a['type'];
		$this->Username = $a['username'];
		$this->Title = $a['title'];
		$this->Name = $a['first_name'];
		$this->LastName = $a['last_name'];
		$this->AllMembersAreAdministrators = $a["all_members_are_administrators"];

	}
}