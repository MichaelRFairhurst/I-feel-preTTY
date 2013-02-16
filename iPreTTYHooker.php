<?php

interface iPrettyHooker {

	const SAY = 'SAY';
	const BEFORE_SAY = 'BEFORE_SAY';
	const AFTER_SAY = 'AFTER_SAY';
	const INDENT = 'INDENT';
	const OUTDENT = 'OUTDENT';

	public function runHook($hook, array $data = array());

	public function setEncoder(PreTTYColorEncoder $encoder);

	public function setWidth($value);

}
