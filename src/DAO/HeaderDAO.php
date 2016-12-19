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

