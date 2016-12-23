<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Header;

class HeaderDAO extends DAO
{

	/**
	 * Return a list of all headers, sorted by date (most recent first).
	 *
	 * @return array A list of all headers.
	 */
	public function findAll() {
		$sql = "select * from t_header order by header_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$headers = array();
		foreach ($result as $row) {
			$headerId = $row['header_id'];
			$headers[$headerId] = $this->buildDomainObject($row);
		}
		return $headers;
	}

	/**
	 * Returns an Header matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingSheets\Domain\Header|throws an exception if no matching header is found
	 */
	public function find($id) {
		$sql = "select * from t_header where header_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No header matching id " . $id);
	}
	
	/**
	 * Saves a header into the database.
	 *
	 * @param \PackingSheets\Domain\Header $header The header to save
	 */
	public function save(Header $header) {
		 
		$headerData = array(
				'header_text' => $header->getText()
		);
		 
		if ($header->getId()) {
			// The header has already been saved : update it
			$this->getDb()->update('t_header', $headerData, array('header_id' => $header->getId()));
		} else {
			// The article has never been saved : insert it
			$this->getDb()->insert('t_header', $headerData);
			// Get the id of the newly created header and set it on the entity.
			$id = $this->getDb()->lastInsertId();
			$header->setId($id);
		}
	}
	
	/**
	 * Removes a header from the database.
	 *
	 * @param integer $id The header id.
	 */
	public function delete($id) {
		//Delete the header
		$this->getDb()->delete('t_header', array('header_id' => $id));
	}

	/**
	 * Creates a header object based on a DB row.
	 *
	 * @param array $row The DB row containing header data.
	 * @return \PackingSheets\Domain\Header
	 */
	protected function buildDomainObject($row) {
		$header = new Header();
		$header->setId($row['header_id']);
		$header->setText($row['header_text']);
		return $header;
	}
}

