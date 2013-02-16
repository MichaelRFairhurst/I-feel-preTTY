<?php

class PreTTYTierCache implements iPreTTYHooker {

	private $width;
	private $indent = 1;
	private $encoder;
	private $enabled = false;
	private $cache = array();

	public function setWidth($v) {
		$this->width = $v;
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
				$this->printCache();
				break;

			case iPreTTYHooker::INDENT: $this->indent++; break;
			case iPreTTYHooker::OUTDENT: $this->indent--; array_pop($this->cache); break;
		}
	}

	private function printCache() {
		//if($this->indent == 0) return;
		echo "\033[s\033[0;0H";

		echo str_repeat("*", $this->width + 1) . PHP_EOL;

		foreach($this->cache as $i => $c) {
			$indent = $i * 2 - 1;
			$text = str_repeat('+', $indent) . $c->render($this->width - $indent);
			echo $text . str_repeat('.', $this->width - $c->getLength() - $indent + 1) . PHP_EOL;
		}

		echo str_repeat("_", $this->width + 1) . PHP_EOL;
		echo str_repeat("^", $this->width + 1) . PHP_EOL;

		echo "\033[u";
	}
}
