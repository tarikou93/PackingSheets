<?php

namespace PackingSheets\Domain;

class Image
{
	/**
	 * Image id.
	 *
	 * @var integer
	 */
	private $id;
	
	/**
	 * Image packing id.
	 *
	 * @var integer
	 */
	private $packingId;

	/**
	 * Image name.
	 *
	 * @var string
	 */
	private $name;


	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}
	
	public function getPackingId() {
		return $this->packingId;
	}
	
	public function setPackingId($id) {
		$this->packingId = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

}
