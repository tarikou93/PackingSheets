<?php

namespace PackingSheets\Domain;

class Memo
{
	/**
	 * Memo id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Memo label.
	 *
	 * @var string
	 */
	private $label;
	
	/**
	 * Memo text.
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

	public function getLabel() {
		return $this->label;
	}

	public function setLabel($label) {
		$this->label = $label;
	}
	
	public function getText() {
		return $this->text;
	}
	
	public function setText($text) {
		$this->text = $text;
	}

}
