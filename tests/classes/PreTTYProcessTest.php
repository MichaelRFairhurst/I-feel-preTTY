<?php

class PreTTYProcessTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		$this->tput = $this->getMock('TPUTWrapper');
		$this->hook_spy = $this->getMock('iPreTTYComponent');
		$this->encoder = $this->getMock('PreTTYColorEncoder');
		$this->process = new PreTTYProcess(array($this->hook_spy), $this->encoder, $this->tput);
	}

	function testRunHookSendsToSpy() {
		$this->hook_spy->expects($this->once())
			->method('runHook')
			->with('TESTHOOK', array(1,2,3));

		$this->process->runHook('TESTHOOK', array(1,2,3));
	}

	function testCallSendHookToSpy() {
		$this->hook_spy->expects($this->once())
			->method('runHook')
			->with('TESTHOOK', array(1,2,3));

		$this->process->testhook(1,2,3);
	}

	function testIndentSendsHookToSpy() {
		$this->hook_spy->expects($this->once())
			->method('runHook')
			->with(iPrettyComponent::HOOK_INDENT);

		$this->process->indent();
	}

	function testOutdentSendsHookToSpy() {
		$this->hook_spy->expects($this->once())
			->method('runHook')
			->with(iPrettyComponent::HOOK_OUTDENT);

		$this->process->outdent();
	}

	function testSaySendsSayHooksToSpy() {
		$this->hook_spy->expects($this->at(1))
			->method('runHook')
			->with(iPrettyComponent::HOOK_BEFORE_SAY, array());

		$this->hook_spy->expects($this->at(2))
			->method('runHook')
			->with(iPrettyComponent::HOOK_SAY, $this->anything());

		$this->hook_spy->expects($this->at(3))
			->method('runHook')
			->with(iPrettyComponent::HOOK_AFTER_SAY, array());

		$this->process->say('a string', 'a color', false);
	}

	function testSayResizesSpyImmediately() {
		$this->tput->expects($this->any())
			->method('getColumns')
			->will($this->returnValue(1234));

		$this->hook_spy->expects($this->at(0))
			->method('setWidth')
			->with(1234);

		$this->process->say('doesnt', 'matter');
	}
}
