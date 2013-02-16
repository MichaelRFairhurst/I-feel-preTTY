<?php

$dir = dirname(__FILE__);
require_once(dirname($dir). '/interfaces/iPreTTYHooker.php');
require_once($dir. '/PreTTYColorEncoder.php');
require_once($dir. '/PreTTYTierCache.php');
require_once($dir. '/PreTTYFormatter.php');
require_once($dir. '/PreTTYString.php');
require_once($dir . '/PreTTYProgressBar.php');

/**
 * This was made by Michael Fairhurst and is distributed under
 * the MIT license
 */
class PreTTYProcess {

	private $hookers = array();

	function __construct(PreTTYColorEncoder $encoder = null, array $hookers = null) {

		// simulate `clear`
		$lines = `tput lines`;
		echo str_repeat(PHP_EOL, $lines);

		$this->encoder = $encoder ? $encoder : new PreTTYColorEncoder;

		if($hookers === null)
			$hookers = array(new PreTTYProgressBar, new PreTTYFormatter);

		array_map(array($this, 'addHooker'), $hookers);
	}

	/**
	 * This enables you to run all your views as if one
	 * object, which is pretty cool
	 * @return PreTTYProcess
	 */
	public function __call($method, $args) {
		$this->runHook(strtoupper($method), $args);

		return $this;
	}

	public function addHooker(iPreTTYHooker $hooker) {
		$this->hookers[] = $hooker;
		$hooker->setEncoder($this->encoder);

		return $this;
	}

	public function runHook($hook, array $data = array()) {
		foreach($this->hookers as $hooker) {
			echo $hooker->runHook($hook, $data);
		}
	}

	private function resetWidth() {
		foreach($this->hookers as $hooker)
			$hooker->setWidth(`tput cols` - 1);
	}


	/**
	 * This will print out text and update the progress bar
	 * at the same time. Can specify colors and boldness,
	 * however any unindented and colored output is always bold.
	 * Usually those comments are important.
	 *
	 * @param string $text
	 * @param string $color red, blue, yellow, teal, grey, white, green
	 * @param boolean $bold default false
	 * @return OutputtingProcess for chaining API
	 */
	public function say($text, $color = null, $bold = false) {
		$this->resetWidth();
		$this->runHook(iPreTTYHooker::BEFORE_SAY);

		$text = $this->getPreTTYString($text, $color, $bold);

		$this->runHook(iPreTTYHooker::SAY, array('string' => $text));
		$this->runHook(iPreTTYHooker::AFTER_SAY);
		return $this;
	}

	private function getPreTTYString($text, $color, $bold) {
		$text = new PreTTYString($text, $this->encoder);
		$text->setColor($color);
		$text->setBold($bold);

		return $text;
	}

}
