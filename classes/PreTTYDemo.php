<?php

require_once 'PreTTYProcess.php';

class PreTTYDemo extends PreTTYProcess {

	function __construct() {
		parent::__construct();
		$this->install(new PreTTYBreadCrumbs);
	}

	function run() {
		$this->setTasks(342);
		$this->say('Cue music', 'white')
			->say('BEGIN VERSE', 'red')
			->indent()
				->say('I', 'yellow', true)
				->say('feel', 'yellow', true)
				->say('preTTY', 'purple', true)
				->indent()
					->say('Oh', 'yellow')
					->say('so', 'yellow')
					->say('preTTY', 'purple', true)
				->outdent()
				->say('I', 'teal')
				->say('feel', 'teal')
				->say('preTTY', 'purple', true)
				->indent()
					->say('and', 'green')
					->say('witty', 'green')
					->say('and', 'green')
					->say('gay', 'grey', true)
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('and', 'white')
				->say('I', 'white')
				->say('pity', 'white')
				->indent()
					->say('any', 'grey')
					->say('girl', 'grey')
					->say('who', 'grey')
					->say('isn\'t', 'grey')
					->indent()
						->say('me', 'yellow', true)
					->outdent()
					->say('today', 'grey', true)
				->outdent()
			->outdent()
			->say('END VERSE', 'red')
			->say('BEGIN VERSE', 'red')
			->indent()
				->say('I', 'green')
				->say('feel', 'green')
				->say('charming', 'green')
				->indent()
					->say('oh', 'green')
					->indent()
						->say('so', 'green')
						->say('charming!', 'green')
					->outdent()
					->say('its', 'yellow')
					->say('alarming', 'yellow')
						->indent()
						->say('how', 'green', true)
						->say('charming', 'green', true)
						->say('I', 'grey')
						->say('feel!', 'grey')
					->outdent()
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->indent()
					->say('and', 'teal')
					->say('so', 'teal')
					->say('preTTY', 'purple', true)
					->indent()
						->say('that I')
						->say('I')
						->say('hardly')
						->say('can')
						->say('believe')
						->say('I\'m', null, true)
						->say('real', null, true)
					->outdent()
				->outdent()
			->outdent()
			->say('END VERSE', 'red')
			->say('BEGIN BRIDGE', 'red')
			->indent()
				->say('see', 'white')
				->say('that', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('girl', 'yellow')
				->outdent()
				->say('in', 'yellow')
				->say('that', 'yellow')
				->indent()
					->say('mirror', 'yellow')
					->say('there', 'yellow')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('Who', 'yellow')
				->say('can', 'yellow')
				->say('that', 'yellow')
				->say('attractive', 'yellow')
				->say('girl', 'yellow')
				->say('be?', 'yellow')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('face', 'teal')
				->outdent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('dress', 'teal')
				->outdent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('smile', 'teal')
				->outdent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('me', 'teal', true)
				->outdent()
			->outdent()
			->say('END BRIDGE', 'red')
			->say('BEGIN VERSE', 'red')
			->indent()
				->say('I', 'yellow')
				->say('feel', 'yellow')
				->say('stunning', 'yellow')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->indent()
					->say('and', 'white')
					->say('entrancing', 'white')
				->outdent()
				->say('Feel', 'yellow')
				->say('like', 'yellow')
				->indent()
					->say('Running', 'green')
					->say('and')
					->say('dancing', 'grey')
					->say('for')
					->say('joy!', 'grey', true)
				->outdent()
				->say('for', 'yellow')
				->indent()
					->say('I\'m', 'yellow')
					->say('loved', 'yellow')
				->outdent()
				->say('by', 'teal')
				->say('a', 'teal')
				->indent()
					->say('preTTY', 'purple', true)
					->say('wonderful', 'yellow')
					->say('boy', 'yellow', true)
				->outdent()
			->outdent()
			->say('END VERSE', 'red')
			->say('GIRLS PART', 'red')
			->indent()
				->say('Have', 'grey')
				->indent()
					->say('you', 'grey')
					->say('met', 'grey')
				->outdent()
				->say('my', 'grey')
				->say('good', 'grey')
				->say('friend', 'grey')
				->say('Maria', 'white', true)
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('the', 'grey')
				->say('craziest', 'white', true)
				->say('girl', 'grey')
				->indent()
					->say('on', 'grey')
					->say('the', 'grey')
					->say('block', 'grey')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('You\'ll', 'green')
				->indent()
					->say('know', 'green')
					->say('her', 'green')
				->outdent()
				->say('the', 'green')
				->say('minute', 'green', true)
				->say('you', 'white')
				->say('see', 'white')
				->say('her', 'white')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('she\'s', 'green')
				->say('the', 'green')
				->say('one', 'green')
				->say('who', 'green')
				->say('is', 'green')
				->say('in', 'green')
				->indent()
					->say('an', 'green')
					->say('advanced', 'green', true)
					->say('state', 'green')
					->say('of', 'green')
					->say('shock', 'green', true)
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('she', 'grey')
				->say('thinks', 'white')
				->say('she\'s', 'grey')
				->indent()
					->say('in', 'yellow')
					->say('love', 'yellow')
				->outdent()
				->say('she', 'grey')
				->say('thinks', 'white')
				->say('she\'s', 'grey')
				->indent()
					->say('in', 'white')
					->say('Spain', 'white')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('she', 'grey')
				->indent()
					->say('isn\'t', 'white')
					->say('in', 'white')
					->say('love', 'white')
				->outdent()
				->say('she\'s', 'grey')
				->say('merely', 'yellow')
				->say('insane', 'grey')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->indent()
					->say('It', 'yellow')
					->say('must', 'yellow')
					->say('be', 'yellow')
					->say('the', 'yellow')
					->say('heat', 'yellow')
				->outdent()
				->say('or', 'teal')
				->indent()
					->say('some')
					->say('rare')
					->say('disease', 'teal')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('or', 'white')
				->indent()
					->say('too', 'grey')
					->say('much', 'grey')
					->say('to', 'grey')
					->say('eat', 'grey')
				->outdent()
				->say('or', 'white')
				->indent()
					->say('maybe', 'teal')
					->say('its', 'teal')
					->say('fleas', 'teal', true)
				->outdent()
			->outdent()
			->say('MORE DRAMATIC', 'red')
			->indent()
				->say('keep', 'green')
				->indent()
					->say('away', 'green')
					->indent()
						->say('from', 'green')
						->indent()
							->say('her', 'green')
						->outdent()
					->outdent()
				->outdent()
				->say('send', 'green', true)
				->say('for', 'green', true)
				->say('Chino', 'green', true)
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('this', 'white')
				->indent()
					->say('is', 'white')
					->say('not', 'white')
				->outdent()
				->say('the', 'white')
				->say('Maria', 'teal', true)
				->indent()
					->say('we', 'white')
					->say('know', 'white')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('modest', 'white')
				->say('and', 'grey')
				->say('pure', 'white')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('polite', 'white')
				->say('and', 'grey')
				->say('refined', 'white')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('well-bred', 'white')
				->say('and', 'grey')
				->say('mature', 'white')
				->say('and', 'grey')
				->say('out', 'green', true)
				->say('of', 'green', true)
				->say('her', 'green', true)
				->say('mind!', 'green', true)
			->outdent()
			->say('END GIRLS PART', 'red')
			->say('BEGIN EXCITED DISCUSSION', 'red')
			->indent()
				->say('Miss', 'white', true)
				->say('America', 'white', true)
				->say('Miss', 'white', true)
				->say('America', 'white', true)
				->indent()
					->say('speech!', 'yellow')
				->outdent()
				->say('Miss', 'white', true)
				->say('America', 'white', true)
				->indent()
					->say('bravo', 'yellow')
					->say('speech!', 'yellow')
				->outdent()
			->outdent()
			->say('BEGIN VERSE', 'red')
			->indent()
				->say('I', 'green')
				->say('feel', 'green')
				->say('preTTY', 'purple', true)
				->say('oh', 'green')
				->indent()
					->say('so', 'green')
					->say('preTTY', 'purple', true)
				->outdent()
				->say('that', 'white')
				->indent()
					->say('the', 'white')
					->say('city', 'white')
				->outdent()
				->say('should', 'white')
				->indent()
					->say('give', 'green')
					->say('me', 'green')
					->indent()
						->say('its', 'green')
						->say('key', 'green')
					->outdent()
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->indent()
					->say('a', 'yellow')
					->say('committee', 'yellow')
				->outdent()
				->say('should', 'grey', true)
				->say('be', 'grey', true)
				->indent()
					->say('organized', 'yellow')
					->say('to', 'yellow')
					->say('honor', 'yellow')
					->say('me', 'yellow')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('I', 'white')
				->indent()
					->say('feel', 'yellow')
					->say('dizzy', 'yellow')
				->outdent()
				->say('I', 'white')
				->indent()
					->say('feel', 'yellow')
					->say('sunny', 'yellow')
				->outdent()
				->say('I', 'white')
				->indent()
					->say('feel', 'yellow')
					->say('fizzy', 'yellow')
					->say('and', 'white')
					->say('funny')
					->say('and', 'white')
					->say('fine', 'yellow')
				->outdent()
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->say('and', 'teal')
				->indent()
					->say('so', 'teal')
					->say('preTTY', 'purple', true)
				->outdent()
				->say('Miss', 'teal')
				->say('America', 'white')
				->indent()
					->say('can', 'white')
					->say('just', 'white')
				->outdent()
				->say('resign', 'white')
			->outdent()
			->say('END VERSE', 'red')
			->say('BEGIN BRIDGE', 'red')
			->indent()
				->say('see', 'white')
				->say('that', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('girl', 'yellow')
				->outdent()
				->say('in', 'yellow')
				->say('that', 'yellow')
				->indent()
					->say('mirror', 'yellow')
					->say('there', 'yellow')
				->outdent()
			->outdent()
			->say('GIRLS', 'red')
			->indent()
				->say('what', 'white')
				->say('mirror', 'white')
				->say('where?', 'white')
			->outdent()
			->say('MARIA', 'red')
			->indent()
				->say('Who', 'yellow')
				->say('can', 'yellow')
				->say('that', 'yellow')
				->say('attractive', 'yellow')
				->say('girl', 'yellow')
				->say('be?', 'yellow')
			->outdent()
			->say('GIRLS', 'red')
			->indent()
				->say('which?', 'white')
				->say('what?', 'grey')
				->say('where?', 'white')
				->say('whom?', 'grey')
			->outdent()
			->say('MARIA', 'red')
			->indent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('face', 'teal')
				->outdent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('dress', 'teal')
				->outdent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('smile', 'teal')
				->outdent()
				->say('such', 'yellow')
				->say('a', 'yellow')
				->indent()
					->say('preTTY', 'purple', true)
					->say('me', 'teal', true)
				->outdent()
			->outdent()
			->say('END BRIDGE', 'red')
			->say('BEGIN VERSE', 'red')
			->say('IN UNISON', 'red')
			->indent()
				->say('I', 'yellow')
				->say('feel', 'yellow')
				->say('stunning', 'yellow')
			->outdent()
			->say('SHORT PAUSE', 'red')
			->indent()
				->indent()
					->say('and', 'white')
					->say('entrancing', 'white')
				->outdent()
				->say('Feel', 'yellow')
				->say('like', 'yellow')
				->indent()
					->say('Running', 'green')
					->say('and')
					->say('dancing', 'grey')
					->say('for')
					->say('joy!', 'grey', true)
				->outdent()
				->say('for', 'yellow')
				->indent()
					->say('I\'m', 'yellow')
					->say('loved', 'yellow')
				->outdent()
				->say('by', 'teal')
				->say('a', 'teal')
				->indent()
					->say('preTTY', 'purple', true)
					->say('wonderful', 'yellow')
					->say('boy', 'yellow', true)
				->outdent()
			->outdent()
			->say('END HAPPY SINGING', 'red');
	}

	function say($text, $color = null, $weight = null) {
		// fake some process time
		usleep(130000 + (rand() % 30000));
		$this->completeTask();
		return parent::say($text, $color, $weight);
	}

}
