<?php

namespace Phrototype\Tests;

use Phrototype;
use Phrototype\Model;
use Phrototype\Validator;

class AddTest extends \PHPUnit_Framework_TestCase {
	public function testAdd() {
		$app = new \Phrototype\App();

		$validator = Validator::create();
		$validator->group('post', 'Post')->field('title');
		$validator->group('post')->field('content')->type('text');
		$validator->group('author', 'Author details')->field('name');
		$validator->group('author', 'Author details')->field('email');

		$add = $app->add($validator);

		$this->assertNotNull($add);
	}
}