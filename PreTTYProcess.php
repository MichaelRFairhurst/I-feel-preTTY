<?php

/**
 * This was made by Michael Fairhurst and is distributed under
 * the MIT license
 */
class PreTTYProcess {

	private $indent = 0;
	private $priorindent = 1;
	private $maxwidth = 106;
	private $firstline = true;
	private $tasks = 999999;
	private $completed = 0;
	private $started;
	private $progress_bar = true;
	private $printed_bar = false;
	private $cache = array();
	protected $show_cache_header = false;

	function __construct() {
		$lines = `tput lines`;
		echo str_repeat(PHP_EOL, $lines);
	}

	public function showCacheHeader() {
		$this->show_cache_header = true;
	}

	public function hideProgressBar() {
		$this->progress_bar = false;
	}

	/**
	 * This will make the next line appear with more indentation,
	 * as if a subset of the prior item
	 *
	 * @return OutputtingProcess for chaining API
	 */
	public function indent() {
		$this->indent++;
		return $this;
	}

	/**
	 * This will make the next line appear with less indentation,
	 * indicating the prior set of tasks for the prior subsets
	 * were completed.
	 *
	 * @return OutputtingProcess for chaining API
	 */
	public function outdent() {
		$this->indent--;
		return $this;
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
		$this->maxwidth = `tput cols` - 1;
		if($this->printed_bar) echo "\033[3A";

		$diff = false;
		if($this->firstline)
			$this->firstline = false;
		else
			$diff = $this->indent != $this->priorindent;

		$this->cache($text, $color, $bold);

		if($this->indent == 0) $bold = true;

		$this->printStrLn($text, $this->indent, $diff, $color, $bold);

		$this->priorindent = $this->indent;
		if($this->progress_bar) $this->progressBar();
		$this->printCache();
		return $this;
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

		$width = (($this->maxwidth+1) - strlen($timestr))/2 - 1;
		$start = '<' . str_repeat('=', floor($width));
		$end = str_repeat('=', ceil($width)) . '>';

		return $start . $timestr . $end;
	}

	private function progressBar() {
		if($this->started === null) $this->started = date('U');
		$this->printed_bar = true;

		$perc = $this->getPercentage();

		$cols = $this->maxwidth - 9;
		$i = 0;
		$delta = 1/($cols);
		$pos = $delta;
		$firstgreater = $pos > $perc;

		$topper = $this->getProgressBarTopper();

		// Top bar
		echo "\033[0;34m" . $topper . PHP_EOL;

		// Progress bar
		echo "= \033[1;32m";
		while(++$i < $cols) {
			if($firstgreater) echo "\033[1;31m";
			echo $pos < $perc ? '+' : 'X';
			$wasless = $pos < $perc;
			$pos += $delta;
			$firstgreater = $wasless && $pos >= $perc;
		}

		// Readout
		printf(' %%%5.01f', $perc*100);
		echo "\033[0;34m =" . PHP_EOL;

		// Bottom bar & cleanup
		echo $topper . "\033[" . ($this->maxwidth + 1) . 'D';
		echo "\033[0m" . PHP_EOL; // in case execution stops
	}

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

	private function printStrLn($text, $indent, $first, $color, $bold) {
		$start = $this->getTextIndentation($indent, $first);
		$text = $this->truncateText($text, strlen($start));

		$ccode = $this->getColorCode($color); 
		if($ccode) $text = "\033[" . ((int)$bold) . ';' . $ccode . 'm' . $text;
		echo $start . $text . ']' . PHP_EOL;
	}

	private function getTextIndentation($indent, $first) {
		if($first) $this->printEmptyLine();

		$repeat = $first ? '===' : '   ';

		$start = '||' . str_repeat($repeat, $indent);
		$start .= $first ? '> [ ' : '  [ ';

		return $start;
	}

	private function printEmptyLine() {
		echo '||' . str_repeat(' ', $this->maxwidth - 2) . ']' . PHP_EOL;
	}

	private function truncateText($text, $offset) {
		$maxlen = $this->maxwidth - $offset;
		$text = trim($text);
		if(strlen($text) > $maxlen)
			$text = substr($text, 0, $maxlen - 3);
		$text .= "\033[0m";
		$text = str_pad($text, $maxlen + 4, '.');
		return $text;
	}

	private function printCache() {
		if(!$this->show_cache_header) return;

		if($this->indent == 0) return;
		echo "\033[s\033[0;0H";

		echo str_repeat("*", $this->maxwidth + 1) . PHP_EOL;

		foreach($this->cache as $i => $c) {
			if($i >= $this->indent) {
				if($i + 1 >= count($this->cache)) break;
				$this->printEmptyLine();
			} else {
				$this->printStrLn($c->text, $i, false, $c->color, $c->bold);
			}
		}

		echo str_repeat("_", $this->maxwidth + 1) . PHP_EOL;
		echo str_repeat("^", $this->maxwidth + 1) . PHP_EOL;

		echo "\033[u";
	}

	private function cache($text, $color, $bold) {
		$c = new StdClass;
		$c->text = $text;
		$c->color = $color;
		$c->bold = $bold;
		$this->cache[$this->indent] = $c;
	}

}
