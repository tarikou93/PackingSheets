<?php

namespace PackingSheets\Domain;

class Header
{
	/**
	 * Header id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Header text.
	 *
	 * @var string
	 */
	private $text;


	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getText() {
		return $this->text;
	}

	public function setText($text) {
		$this->text = $text;
	}

}

