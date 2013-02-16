<?php

class PreTTYProgressBar implements iPreTTYComponent {

	const HOOK_COMPLETE_TASK = 'COMPLETETASK';
	const HOOK_SET_TASKS = 'SETTASKS';

	private $tasks = 999999;
	private $completed = 0;
	private $started;
	private $enabled = true;
	private $printed_bar = false;
	private $encoder;
	private $width;

	public function setEncoder(PreTTYColorEncoder $encoder) {
		$this->encoder = $encoder;
	}

	public function disable() {
		$this->enabled = false;
	}

	private function render() {
		if($this->started === null) $this->started = date('U');
		$this->printed_bar = true;

		$return = '';

		$perc = $this->getPercentage();

		$cols = $this->width - 10;
		$i = 0;
		$delta = 1/($cols);
		$pos = $delta;
		$firstgreater = $pos > $perc;

		$topper = $this->getProgressBarTopper();

		// Top bar
		$return .= $this->encoder->encode('blue') . $topper . PHP_EOL;

		// Progress bar
		$return .= '= ' . $this->encoder->encode('green', true);
		while(++$i < $cols) {
			if($firstgreater) $return .= $this->encoder->encode('red', true);
			$return .= $pos < $perc ? '+' : 'X';
			$wasless = $pos < $perc;
			$pos += $delta;
			$firstgreater = $wasless && $pos >= $perc;
		}

		// Readout
		$return .= sprintf(' %%%5.01f', $perc*100);
		$return .= $this->encoder->encode('blue') . ' =' . PHP_EOL;

		// Bottom bar & cleanup
		$return .= $topper . $this->encoder->moveback($this->width + 1);
		$return .= $this->encoder->reset();// . PHP_EOL; // in case execution stops

		return $return;
	}

	private function getTimeString() {
		$perc = $this->getPercentage();
		$time = date('U') - $this->started;
		$time = $perc == 0
			? 0
			: $time * (1 / $perc) * (1 - $perc);
		$sec = $time % 60;
		$min = ($time - $sec) % 3600 / 60;
		return " $min min $sec sec remain ";
	}

	private function getPercentage() {
		return min($this->completed / $this->tasks, 1);
	}

	private function getProgressBarTopper() {
		$timestr = $this->getTimeString();

		$width = (($this->width) - strlen($timestr))/2 - 1;
		$start = '<' . str_repeat('=', floor($width));
		$end = str_repeat('=', ceil($width)) . '>';

		return $start . $timestr . $end;
	}

	/**
	 * Set the number of total tasks this process will do before
	 * its completed, so that you can present an accurate progress
	 * of completion. Can be changed at any time, allowing your
	 * process to make...educated guesses.
	 *
	 * @param $count the number of tasks to declare
	 * @return OutputtingProcess for chaining API
	 */
	public function setTasks($count) {
		$this->tasks = $count;
		return $this;
	}

	/**
	 * Mark a task as completed, so that you can present an accurate
	 * percentage of completion. Remember that you can also use
	 * setTasks for processes where tracking progress is highly
	 * varied
	 *
	 * @return OutputtingProcess for chaining API
	 */
	public function completeTask() {
		$this->completed++;
		return $this;
	}

	public function setWidth($v) {
		$this->width = $v;
	}

	public function runHook($hook, array $data = array()) {
		switch($hook) {
			case iPreTTYComponent::HOOK_BEFORE_SAY:
				if($this->printed_bar)
					return $this->encoder->moveup(2);
				break;

			case iPreTTYComponent::HOOK_AFTER_SAY:
				return $this->render();
				break;

			case self::HOOK_COMPLETE_TASK:
				$this->completeTask();
				break;

			case self::HOOK_SET_TASKS:
				$this->setTasks($data[0]);
				break;

		}
	}
}
