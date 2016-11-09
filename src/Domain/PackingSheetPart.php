<?php

namespace PackingSheets\Domain;

class PackingSheetPart
{
	/**
	 * PackingSheetPart id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Associated PackingSheet id.
	 *
	 * @var integer
	 */
	private $ps_id;

	/**
	 * Associated Part id.
	 *
	 * @var integer
	 */
	private $part_id;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getPsid() {
		return $this->ps_id;
	}

	public function setPsid($psid) {
		$this->ps_id = $psid;
	}

	public function getPartid() {
		return $this->part_id;
	}

	public function setPartid($partid) {
		$this->part_id = $partid;
	}

}
