<?php

namespace PackingSheets\Domain;

class PackingListPart
{
	/**
	 * PackingListPart id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Associated PackingList id.
	 *
	 * @var integer
	 */
	private $pl_id;

	/**
	 * Associated Part id.
	 *
	 * @var integer
	 */
	private $part_id;
	
	/**
	 * PackingListPart quantity.
	 *
	 * @var integer
	 */
	private $quantity;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getPlid() {
		return $this->pl_id;
	}

	public function setPlid($plid) {
		$this->pl_id = $plid;
	}

	public function getPartid() {
		return $this->part_id;
	}

	public function setPartid($partid) {
		$this->part_id = $partid;
	}
	
	public function getQuantity() {
		return $this->quantity;
	}
	
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}
	
}
