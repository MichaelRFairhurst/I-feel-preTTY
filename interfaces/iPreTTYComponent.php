<?php

interface iPreTTYComponent {

	const HOOK_SAY = 'SAY';
	const HOOK_BEFORE_SAY = 'BEFORE_SAY';
	const HOOK_AFTER_SAY = 'AFTER_SAY';
	const HOOK_INDENT = 'INDENT';
	const HOOK_OUTDENT = 'OUTDENT';

	public function runHook($hook, array $data = array());

	public function setEncoder(PreTTYColorEncoder $encoder);

	public function setWidth($value);

}
