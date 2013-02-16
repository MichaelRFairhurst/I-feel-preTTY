<?php

class PreTTYString {

	private $text;
	private $color;
	private $bold;
	private $encoder;

	function __construct($text, PreTTYColorEncoder $encoder) {
		$this->text = $text;
		$this->encoder = $encoder;
	}

	function setColor($color) { 
		$this->color = $color;
	}

	function setBold($bold) {
		$this->bold = $bold;
	}

	function getLength() {
		return strlen($this->text);
	}

	function render($maxlength) {
		return $this->encoder->encode(
				$this->color,
				$this->bold)
			. substr(
				$this->text,
				0,
				$maxlength
			) . $this->encoder->reset();
	}
}
