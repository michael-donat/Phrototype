<?php

namespace Phrototype\Validator;

use Phrototype\Validator\Field;
use Phrototype\Validator\FormParser;
use Phrototype\Utils;

// Given a bunch of fields, make me a form!
class Form {
	// These are HTML elements perhaps you recognise them
	private static  $types = [
		  'input'		=> [
		  	'tag' => 'input',
		  	'attributes' => ['type' => 'text'],
		]
		, 'hidden'		=> [
			'tag' => 'input',
			'attributes' => ['type' => 'hidden']
		]
		, 'checkbox'	=> ['tag' => 'checkbox']
		, 'radio'		=> ['tag' => 'radio']
		, 'password'	=> [
			'tag' => 'input',
			'attributes' => ['type' => 'password']
		]
		, 'text'		=> [
			'input',
			'attributes' => ['type' => 'text']
		]
		, 'submit'		=> [
			'tag' => 'input',
			'attributes' => ['type' => 'submit']
		]
		, 'select'		=> ['tag' => 'select']
		, 'email'		=> [
			'tag' => 'input',
			'attributes' => ['type' => 'email']
		]
	];
	private $form = [];
	private $fields;
	private $method;
	private $action;
	private $attributes = [];

	private $parser;

	public function __construct(array $fields = array()) {
		$this->fields = $fields;
		$this->parser = new FormParser();
	}

	public static function create(array $fields = array()) {
		return new Form($fields);
	}

	public function fields(array $fields = null) {
		if($fields) {
			$this->fields = $fields;
			return $this;
		}
		return $this->fields;
	}

	public function form() {
		return $this;
	}

	public function method($method = null) {
		if($method) {
			$this->method = $method;
			return $this;
		}
		return $this->method;
	}

	public function action($action = null) {
		if($action) {
			$this->action = $action;
			return $this;
		}
		return $this->action;
	}

	public function attributes(array $v = null) {
		if($v !== null) {
			$this->attributes = $v;
			return $this;
		}
		return $this->attributes;
	}

	public function buildSelectOptions($options, $defaultValue) {
		$return = [];
		foreach($options as $value => $text) {
			$hash = [
				'tag' => 'option',
				'attributes' => ['value' => $value],
				'children' => $text,
			];
			if($defaultValue === $value) {
				$hash['attributes']['selected'] = 'selected';
			}
			$return[] = $hash;
		}
		return $return;
	}

	public static function resolveType(Field $field) {
		if(
			$field->type()
			&& in_array(
				$field->type(), array_keys(self::$types)
			)
		) {
			return $field->type();
		}
		if(
			$field->name()
			&& in_array(
				$field->name(), array_keys(self::$types)
			)
		) {
			return $field->name();
		}
		if($field->options()) {
			return 'select';
		}
		return 'input';
	}

	public static function types() {
		return self::$types;
	}

	public function html($elements = array()) {
		if(!$elements) {
			$elements = $this->form();
		}
		if(is_array($elements)) {
			$html = '';
			array_map(function($element) use ($html) {
				$html .= $this->parser->parse($element);
			}, $elements);
			return $html;
		}
		return $this->parser->parse($elements);
	}
}