<?php

$dir = dirname(__FILE__);
require_once(dirname($dir). '/interfaces/iPreTTYComponent.php');
require_once($dir. '/TPUTWrapper.php');
require_once($dir. '/PreTTYColorEncoder.php');
require_once($dir. '/PreTTYBreadCrumbs.php');
require_once($dir. '/PreTTYFormatter.php');
require_once($dir. '/PreTTYString.php');
require_once($dir . '/PreTTYProgressBar.php');

/**
 * This was made by Michael Fairhurst and is distributed under
 * the MIT license
 */
class PreTTYProcess {

	private $components = array();
	private $tput;

	function __construct(array $components = null, PreTTYColorEncoder $encoder = null, TPUTWrapper $tput = null) {

		$this->tput = $tput ? $tput : new TPUTWrapper;
		$this->encoder = $encoder ? $encoder : new PreTTYColorEncoder;

		// clear terminal
		$lines = $this->tput->getLines();
		echo str_repeat(PHP_EOL, $lines);

		if($components === null)
			$components = array(new PreTTYProgressBar, new PreTTYFormatter);

		array_map(array($this, 'install'), $components);
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

	public function install(iPreTTYComponent $component) {
		$this->components[] = $component;
		$component->setEncoder($this->encoder);

		return $this;
	}

	public function runHook($hook, array $data = array()) {
		foreach($this->components as $component) {
			echo $component->runHook($hook, $data);
		}
	}

	private function resetWidth() {
		foreach($this->components as $component)
			$component->setWidth($this->tput->getColumns());
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
		$this->runHook(iPreTTYComponent::HOOK_BEFORE_SAY);

		$text = $this->getPreTTYString($text, $color, $bold);

		$this->runHook(iPreTTYComponent::HOOK_SAY, array('string' => $text));
		$this->runHook(iPreTTYComponent::HOOK_AFTER_SAY);
		return $this;
	}

	private function getPreTTYString($text, $color, $bold) {
		$text = new PreTTYString($text, $this->encoder);
		$text->setColor($color);
		$text->setBold($bold);

		return $text;
	}

}
