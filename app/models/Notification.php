<?php

class Notification {
	public $type;
	public $value;
	function set($type, $value) {
		$this->type  = $type;
		$this->value = $value;
	}
}
