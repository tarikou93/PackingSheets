<?php

namespace PackingSheets\Domain;

class ArchiveSearch
{
	
	/**
	 * PackingSheet ref.
	 *
	 * @var string
	 */
	private $ref;

	/**
	 * PackingSheet serialization user.
	 *
	 * @var string
	 */
	private $user;

	/**
	 * PackingSheet serialization date.
	 *
	 * @var string
	 */
	private $serializationDate;

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
	
}


