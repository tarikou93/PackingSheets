<?php

namespace PackingSheets\Domain;

class PackingList
{
	/**
	 * PackingList id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * PackingList PackingSheet id.
	 *
	 * @var integer
	 */
	private $ps_id;
	
	/**
	 * PackingList PackingListParts array.
	 *
	 * @var integer array
	 */
	private $parts;


	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getPsId() {
		return $this->psId;
	}

	public function setPsId($ps_id) {
		$this->psId = $ps_id;
	}
	
	public function getParts() {
		return $this->parts;
	}
	
	public function setParts($parts) {
		$this->parts = $parts;
	}

}


