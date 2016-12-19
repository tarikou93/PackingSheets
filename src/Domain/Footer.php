<?php

namespace PackingSheets\Domain;

class Footer
{
	/**
	 * Footer id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Footer text.
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


