<?php

namespace PackingSheets\Domain;

class Archive
{
	/**
	 * Archive id.
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Archive PS ref.
	 *
	 * @var string
	 */
	private $ref;
	
	/**
	 * Archive PS user.
	 *
	 * @var string
	 */
	private $user;
	
	/**
	 * Archive PS serialization date.
	 *
	 * @var string
	 */
	private $serializationDate;
	
	/**
	 * Archive PS serialized pdf file.
	 *
	 * @var string
	 */
	private $serializedPdf;


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
	
	public function getUser() {
		return $this->user;
	}
	
	public function setUser($user) {
		$this->user = $user;
	}
	
	public function getSerializationDate() {
		return $this->serializationDate;
	}
	
	public function setSerializationDate($date) {
		$this->serializationDate = $date;
	}
	
	public function getSerializedPdf() {
		return $this->serializedPdf;
	}
	
	public function setSerializedPdf($pdf) {
		$this->serializedPdf = $pdf;
	}

}
