<?php

namespace Phrototype\Tests;

use Phrototype\Model\Model;
use Phrototype\Prototype;

class CreateTest extends \PHPUnit_Framework_TestCase{
	public function testCreateReturnsANewPrototype() {
		$o = Model::create([]);

		$this->assertInstanceOf('\Phrototype\Prototype', $o);
	}

	public function assertCreateWithFieldsReturnsAPrototypeWithThoseFields() {
		// We are starting a book shop ok
		$book = Model::create([
			'title', 'synopsis'
		]);

		$this->assertEquals(
			['title', 'synopsis'],
			array_keys($book->getProperties())
		);
	}

	public function testCanSetAPrototypeWithTypesAndNotHaveThemInTheObject() {
		// Start with a good book
		$book = Model::create([
			'title'	=> ['type' => 'string', 'value' => 'Don Quixote'],
			'published' =>['type' => 'date', 'value' => '1605-05-21'],
			'edition' => ['type' => 'integer', 'value' => '1']
		]);

		$this->assertEquals(
			['title' => 'Don Quixote', 'published' => '1605-05-21', 'edition' => '1'],
			$book->getProperties()
		);
	}

	public function testCreatingWithWrongTypesDropsValues() {
		$book = Model::create([
			'title'	=> ['type' => 'string', 'value' => []],
			'edition' => ['type' => 'int', 'value' => 'one']
		]);
	}
}