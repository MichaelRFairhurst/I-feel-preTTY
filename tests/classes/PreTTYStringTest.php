<?php

class PreTTYStringTest extends PHPUnit_Framework_TestCase {

	function setUp() {
		$this->encoder = $this->getMock('PreTTYColorEncoder');
	}

	function testColoredStringIncludesCode() {
		$this->encoder->expects($this->once())
			->method('encode')
			->with('yellow', true)
			->will($this->returnValue('!CODE!'));

		$text = new PreTTYString('and they were so yellow', $this->encoder);
		$text->setColor('yellow');
		$text->setBold(true);

		$this->assertEquals('!CODE!and they were so yellow', $text->render(100));
	}

	function testStringIncludesReset() {
		$this->encoder->expects($this->once())
			->method('reset')
			->will($this->returnValue('!RESET!'));

		$text = new PreTTYString('and they were so yellow', $this->encoder);

		$this->assertEquals('and they were so yellow!RESET!', $text->render(100));
	}

	function testRenderTruncates() {
		$text = new PreTTYString('1234567890', $this->encoder);
		$this->assertEquals('1234567', $text->render(7));
	}

	/**
	 * @depends testRenderTruncates
	 */
	function testRenderWithCodeTruncatesPreservingCode() {
		$this->encoder->expects($this->once())
			->method('encode')
			->with('yellow', true)
			->will($this->returnValue('!CODE!'));

		$this->encoder->expects($this->once())
			->method('reset')
			->will($this->returnValue('!RESET!'));

		$text = new PreTTYString('1234567890', $this->encoder);
		$text->setColor('yellow');
		$text->setBold(true);

		$this->assertEquals('!CODE!1234!RESET!', $text->render(4));
	}

	function testGetLengthMatchesString() {
		$text = new PreTTYString('123456', $this->encoder);
		$this->assertEquals(6, $text->getLength());
	}

	/**
	 * @depnds testGetLengthMatchesString
	 */
	function testGetLengthMatchesStringWithCodes() {
		$this->encoder->expects($this->any())
			->method('encode')
			->with('yellow', true)
			->will($this->returnValue('!CODE!'));

		$text = new PreTTYString('1234567890', $this->encoder);
		$text->setColor('yellow');
		$text->setBold(true);

		$this->assertEquals(10, $text->getLength());
	}
}
