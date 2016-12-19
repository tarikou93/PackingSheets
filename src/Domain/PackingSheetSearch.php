<?php

namespace PackingSheets\Domain;

class PackingSheetSearch
{
	/**
	 * PackingSheet id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * PackingSheet ref.
	 *
	 * @var string
	 */
	private $ref;

	/**
	 * PackingSheet groupId.
	 *
	 * @var integer
	 */
	private $groupId;

	/**
	 * PackingSheet consignedAddressId.
	 *
	 * @var integer
	 */
	private $consignedAddressId;


	/**
	 * PackingSheet consignedContactId.
	 *
	 * @var integer
	 */
	private $consignedContactId;


	/**
	 * PackingSheet AWB.
	 *
	 * @var string
	 */
	private $AWB;

	/**
	 * PackingSheet dateIssue.
	 *
	 * @var date
	 */
	private $dateIssue;


	/**
	 * PackingSheet inputId.
	 *
	 * @var integer
	 */
	private $imputId;
	
	/**
	 * PackingSheet serviceId.
	 *
	 * @var integer
	 */
	private $serviceId;

	/**
	 * PackingSheet signed.
	 *
	 * @var bit
	 */
	private $signed;

	/**
	 * PackingSheet printed.
	 *
	 * @var integer
	 */
	private $printed;
	
	/**
	 * Part pn.
	 *
	 * @var integer
	 */
	private $pn;
	
	/**
	 * Part serial.
	 *
	 * @var integer
	 */
	private $serial;
	
	/**
	 * Partdesc.
	 *
	 * @var integer
	 */
	private $desc;

	/**
	 * Part hscode.
	 *
	 * @var integer
	 */
	private $hscode;
	
	
	/**
	 * PackingSheet Code selection.
	 *
	 * @var String
	 */
	private $datalistCode;
	
	/**
	 * PackingSheet Address selection.
	 *
	 * @var String
	 */
	private $datalistAddress;
	
	/**
	 * PackingSheet Contact selection.
	 *
	 * @var String
	 */
	private $datalistContact;
	
	public function getDatalistCode() {
		return $this->datalistCode;
	}
	
	public function setDatalistCode($datalistCode) {
		$this->datalistCode = $datalistCode;
	}
	
	public function getDatalistAddress() {
		return $this->datalistAddress;
	}
	
	public function setDatalistAddress($datalistAddress) {
		$this->datalistAddress = $datalistAddress;
	}
	
	public function getDatalistContact() {
		return $this->datalistContact;
	}
	
	public function setDatalistContact($datalistContact) {
		$this->datalistContact = $datalistContact;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getRef() {
		return $this->ref;
	}

	public function setRef($ref) {
		$this->ref = $ref;
	}

	public function getGroupId() {
		return $this->groupId;
	}

	public function setGroupId($groupId) {
		$this->groupId = $groupId;
	}

	public function getConsignedAddressId() {
		return $this->consignedAddressId;
	}

	public function setConsignedAddressId($consignedAddressId) {
		$this->consignedAddressId = $consignedAddressId;
	}

	public function getConsignedContactId() {
		return $this->consignedContactId;
	}

	public function setConsignedContactId($consignedContactId) {
		$this->consignedContactId = $consignedContactId;
	}

	public function getAWB() {
		return $this->AWB;
	}

	public function setAWB($AWB) {
		$this->AWB = $AWB;
	}

	public function getDateIssue() {
		return $this->dateIssue;
	}

	public function setDateIssue($dateIssue) {
		$this->dateIssue = $dateIssue;
	}

	public function getImputId() {
		return $this->imputId;
	}

	public function setImputId($imputId) {
		$this->imputId = $imputId;
	}
	
	public function getServiceId() {
		return $this->serviceId;
	}
	
	public function setServiceId($serviceId) {
		$this->serviceId = $serviceId;
	}

	public function getSigned() {
		return $this->signed;
	}

	public function setSigned($signed) {
		$this->signed = $signed;
	}

	public function getPrinted() {
		return $this->printed;
	}

	public function setPrinted($printed) {
		$this->printed = $printed;
	}
	
	public function getPn() {
		return $this->pn;
	}
	
	public function setPn($pn) {
		$this->pn = $pn;
	}
	
	public function getSerial() {
		return $this->serial;
	}
	
	public function setSerial($serial) {
		$this->serial = $serial;
	}
	
	public function getDesc() {
		return $this->desc;
	}
	
	public function setDesc($desc) {
		$this->desc = $desc;
	}
	
	public function getHSCode() {
		return $this->hscode;
	}
	
	public function setHSCode($hscode) {
		$this->hscode = $hscode;
	}
}

