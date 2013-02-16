<?php

class PreTTYTierCache implements iPreTTYHooker {

	private $width;
	private $indent = 1;
	private $encoder;
	private $enabled = false;
	private $cache = array();

	public function setWidth($v) {
		$this->width = $v+0;
	}

	public function setEncoder(PreTTYColorEncoder $encoder) {
		$this->encoder = $encoder;
	}

	public function runHook($hook, array $data = array()) {
		switch($hook) {
			case iPreTTYHooker::SAY:
				$this->cache[$this->indent] = $data['string'];
				break;

			case iPreTTYHooker::AFTER_SAY:
				return $this->printCache();
				break;

			case iPreTTYHooker::INDENT: $this->indent++; break;
			case iPreTTYHooker::OUTDENT: $this->indent--; array_pop($this->cache); break;
		}
	}

	private function printCache() {
		$return = $this->encoder->saveCursor() . $this->encoder->setCursor(0,0);

		$return .= str_repeat("*", $this->width) . PHP_EOL;

		foreach($this->cache as $i => $c) {
			$indent = $i * 2 - 1;
			$text = str_repeat('+', $indent) . $c->render($this->width - $indent);
			$return .= $text . str_repeat('.', $this->width - $c->getLength() - $indent) . PHP_EOL;
		}

		$return .= str_repeat("_", $this->width) . PHP_EOL;
		$return .= str_repeat("^", $this->width) . PHP_EOL;

		$return .= $this->encoder->restoreCursor();

		return $return;
	}
}
