<?php

class PreTTYColorEncoder {

	/**
	 * This should really just be an array lookup...
	 * but \033[1;{$this->getColorCode('red')}m will print
	 * as red text
	 *
	 * @param string $color
	 * @return int
	 */
	private function getColorCode($color) {
		switch($color) {
			case 'red': return 31;
			case 'green': return 32;
			case 'yellow': return 33;
			case 'blue': return 34;
			case 'purple': return 35;
			case 'teal': return 36;
			case 'white': return 37;
			case 'grey': return 38;
			default: return false;
		}
	}

	/**
	 * this is an ANSI sequence but thanks to dependency injection it
	 * doesn't have to be
	 * @param string $color
	 * @param boolean $bold
	 * @return string
	 */
	public function encode($color, $bold = false) {
		$text = '';
		$ccode = $this->getColorCode($color); 
		if($ccode) $text = "\033[" . ((int)$bold) . ';' . $ccode . 'm';

		return $text;
	}

	public function reset() {
		return "\033[0m";
	}

	public function moveback($amount) {
		return "\033[{$amount}D";
	}

	public function moveup($amount) {
		return "\033[{$amount}A";
	}

	public function saveCursor() {
		return "\033[s";
	}

	public function restoreCursor() {
		return "\033[u";
	}

	public function setCursor($line, $column) {
		return "\033[$line;{$column}H";
	}
}
