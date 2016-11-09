<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingSheetPart;

class PackingSheetPartDAO extends DAO
{

	/**
	 * @var \PackingPartSheets\DAO\PackingSheetDAO
	 */
	private $psDAO;

	public function setPackingSheetDAO(PackingSheetDAO $psDAO) {
		$this->psDAO = $psDAO;
	}

	/**
	 * @var \PackingPartSheets\DAO\PartDAO
	 */
	private $partDAO;

	public function setPartDAO(PartDAO $partDAO) {
		$this->partDAO = $partDAO;
	}

	/**
	 * Return a list of all PackingSheetParts, sorted by date (most recent first).
	 *
	 * @return array A list of all PackingSheetParts.
	 */
	public function findAll() {
		$sql = "select * from t_packingsheet_part order by psp_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$packingSheetParts = array();
		foreach ($result as $row) {
			$packingSheetPartId = $row['psp_id'];
			$packingSheetParts[$packingSheetPartId] = $this->buildDomainObject($row);
		}
		return $packingSheetParts;
	}

	/**
	 * Returns an PackingSheetPart matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingPartSheets\Domain\PackingSheetPart|throws an exception if no matching PackingSheetPart is found
	 */
	public function find($id) {
		$sql = "select * from t_packingsheet_part where psp_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No PackingSheetPart matching id " . $id);
	}

	/**
	 * Return a list of all packingsheetparts for a packingsheet.
	 *
	 * @param integer $packingsheetId The packingsheet id.
	 *
	 * @return array A list of all packingsheetParts for the packingsheet.
	 */
	public function findAllByPackingSheet($packingSheetId) {
		// The associated packing is retrieved only once
		$packingSheet = $this->psDAO->find($packingSheetId);

		// ps_id is not selected by the SQL query
		// The packingsheet won't be retrieved during domain objet construction
		$sql = "select psp_id, part_id from t_packingsheet_part where ps_id=? order by psp_id";
		$result = $this->getDb()->fetchAll($sql, array($packingSheetId));

		// Convert query result to an array of domain objects
		$packingSheetParts = array();
		foreach ($result as $row) {
			$packingSheetPartId = $row['psp_id'];
			$packingSheetPart = $this->buildDomainObject($row);
			// The associated packing is defined for the constructed packing
			$packingSheetPart->setPsid($packingSheet);
			$packingSheetParts[$packingSheetPartId] = $packingSheetPart;
		}
		return $packingSheetParts;
	}

	/**
	 * Return a list of all packingSheetParts for a part.
	 *
	 * @param integer $partId The part id.
	 *
	 * @return array A list of all packingSheetParts for the part.
	 */
	public function findAllByPart($partId) {
		// The associated part is retrieved only once
		$part = $this->partDAO->find($partId);

		// part_id is not selected by the SQL query
		// The part won't be retrieved during domain objet construction
		$sql = "select psp_id, ps_id from t_packingsheet_part where part_id=? order by psp_id";
		$result = $this->getDb()->fetchAll($sql, array($partId));

		// Convert query result to an array of domain objects
		$packingSheetParts = array();
		foreach ($result as $row) {
			$packingSheetPartId = $row['psp_id'];
			$packingSheetPart = $this->buildDomainObject($row);
			// The associated part is defined for the constructed packing
			$packingSheetPart->setPartid($part);
			$packingSheetParts[$packingSheetPartId] = $packingSheetPart;
		}
		return $packingSheetParts;
	}

	/**
	 * Creates a PackingPart object based on a DB row.
	 *
	 * @param array $row The DB row containing PackingPart data.
	 * @return \PackingPartSheets\Domain\PackingPart
	 */
	protected function buildDomainObject($row) {
		$packingSheetPart = new PackingSheetPart();
		$packingSheetPart->setId($row['psp_id']);

		if (array_key_exists('ps_id', $row)) {
			// Find and set the associated packingSheet
			$packingSheetId = $row['ps_id'];
			$packingSheet = $this->psDAO->find($packingSheetId);
			$packingSheetPart->setPsid($packingSheet);
		}

		if (array_key_exists('part_id', $row)) {
			// Find and set the associated packingSheet
			$partId = $row['part_id'];
			$part = $this->partDAO->find($partId);
			$packingSheetPart->setPartid($part);
		}

		return $packingSheetPart;
	}
}
