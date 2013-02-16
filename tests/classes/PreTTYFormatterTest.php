<?php

class PreTTYFormatterTest extends PHPUnit_Framework_TestCase {

	function getMockPreTTYString($content) {
		$text = $this->getMockBuilder('PreTTYString')
			->disableOriginalConstructor()
			->getMock();

		$text->expects($this->any())
			->method('render')
			->will($this->returnValue($content));
		$text->expects($this->any())
			->method('getLength')
			->will($this->returnValue(strlen($content)));

		return $text;
	}

	/**
	 * @dataProvider firstLinesProvider
	 */
	function testFirstLinesAtIndent($indent, $expected) {
		$formatter = new PreTTYFormatter;
		$formatter->setWidth(32);
		for($i=0;$i<$indent;$i++) $formatter->runHook(iPrettyHooker::INDENT);

		$text = $this->getMockPreTTYString('output');

		$this->assertEquals(
			$expected . PHP_EOL,
			$formatter->runHook(iPreTTYHooker::SAY, array('string' => $text))
		);
	}

	function firstLinesProvider() {
		return array(
			array(0, '||> [ output...................]'),
			array(1, '||===> [ output................]'),
			array(2, '||======> [ output.............]'),
			array(3, '||=========> [ output..........]'),
			array(4, '||============> [ output.......]'),
			array(5, '||===============> [ output....]'),
			// Wrapping is actually done by the text object
			// since it has to handle its 'reset' code.
			// set testLinesAreRenderedWithMaxLength
		);
	}

	/**
	 * @dataProvider SecondLinesProvider
	 */
	function testSecondLinesAtIndent($indent, $expected) {
		$formatter = new PreTTYFormatter;
		$formatter->setWidth(32);

		for($i=0;$i<$indent;$i++) $formatter->runHook(iPrettyHooker::INDENT);

		// run it
		$formatter->runHook(iPreTTYHooker::SAY, array('string' => $this->getMockPreTTYString('anything')));
		// and now we're testing second line indent

		$text = $this->getMockPreTTYString('output');

		$this->assertEquals(
			$expected . PHP_EOL,
			$formatter->runHook(iPreTTYHooker::SAY, array('string' => $text))
		);
	}


	function secondLinesProvider() {
		return array(
			array(0, '||  [ output...................]'),
			array(1, '||     [ output................]'),
			array(2, '||        [ output.............]'),
			array(3, '||           [ output..........]'),
			array(4, '||              [ output.......]'),
			array(5, '||                 [ output....]'),
			// Wrapping is actually done by the text object
			// since it has to handle its 'reset' code.
			// set testLinesAreRenderedWithMaxLength
		);
	}

	/**
	 * @group IntegrationTests
	 */
	function testLinesAreRenderedWithMaxLength() {
		$text = new PreTTYString('12345678901', $this->getMock('PreTTYColorEncoder'));

		$expected = '||> [ 12345...]';
		$formatter = new PreTTYFormatter;
		$formatter->setWidth(strlen($expected));

		$this->assertEquals(
			$expected . PHP_EOL,
			$formatter->runHook(iPreTTYHooker::SAY, array('string' => $text))
		);
	}
}
