<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingListPart;

class PackingListPartDAO extends DAO
{


	/**
	 * @var \PackingPartSheets\DAO\PartDAO
	 */
	private $partDAO;

	public function setPartDAO(PartDAO $partDAO) {
		$this->partDAO = $partDAO;
	}

	/**
	 * Return a list of all PackingListParts, sorted by date (most recent first).
	 *
	 * @return array A list of all PackingListParts.
	 */
	public function findAll() {
		$sql = "select * from t_packinglist_part order by plp_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$packingListParts = array();
		foreach ($result as $row) {
			$packingListPartId = $row['plp_id'];
			$packingListParts[$packingListPartId] = $this->buildDomainObject($row);
		}
		return $packingListParts;
	}

	/**
	 * Returns an PackingListPart matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingPartSheets\Domain\PackingListPart|throws an exception if no matching PackingListPart is found
	 */
	public function find($id) {
		$sql = "select * from t_packinglist_part where plp_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No PackingListPart matching id " . $id);
	}

	/**
	 * Add a PackingSheetPart into the database.
	 *
	 * @param \PackingSheets\Domain\PackingListPart $plPart The PackingListPart to save
	 */
	public function save(PackingListPart $plPart, $Plid) {
			
		$plPartData = array(
				'pl_id' => $Plid,
				'part_id' => $plPart->getPartid()->getId(),
				'plp_quantity' => $plPart->getQuantity(),
		);

		if ($plPart->getId()) {
			// The PackingListPart has already been saved : update it
			$this->getDb()->update('t_packinglist_part', $plPartData, array('plp_id' => $plPart->getId()));
		} else {
			// The PackingListPart has never been saved : insert it
			$this->getDb()->insert('t_packinglist_part', $plPartData);
			// Get the id of the newly created PackingListPart and set it on the entity.
			$id = $this->getDb()->lastInsertId();
			$plPart->setId($id);
		}
	}

	/**
	 * Removes a PackingListPart from the database.
	 *
	 * @param integer $id The PackingListPart id.
	 */
	public function delete($id) {
		//Delete the PackingListPart
		$this->getDb()->delete('t_packinglist_part', array('plp_id' => $id));
	}
	
	public function deleteAll($plId){
		$this->getDb()->delete('t_packinglist_part', array('pl_id' => $plId));
	}

	/**
	 * Return a list of all packingsheetparts for a packingList.
	 *
	 * @param integer $packingListId The packingList id.
	 *
	 * @return array A list of all packingListParts for the packingList.
	 */
	
	public function findAllByPackingList($packingListId) {
		$sql = "select * from t_packinglist_part where pl_id=".$packingListId;
		$result = $this->getDb()->fetchAll($sql);
	
		// Convert query result to an array of domain objects
		$packingListParts = array();
		foreach ($result as $row) {
			$packingListPartId = $row['plp_id'];
			$packingListParts[$packingListPartId] = $this->buildDomainObject($row);
		}
		return $packingListParts;
	}

	/**
	 * Return a list of all packingListParts for a part.
	 *
	 * @param integer $partId The part id.
	 *
	 * @return array A list of all packingListParts for the part.
	 */
	public function findAllByPart($partId) {
		// The associated part is retrieved only once
		$part = $this->partDAO->find($partId);

		// part_id is not selected by the SQL query
		// The part won't be retrieved during domain objet construction
		$sql = "select psp_id, pl_id, plp_quantity from t_packingsheet_part where part_id=? order by psp_id";
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
	 * Creates a PackingListPart object based on a DB row.
	 *
	 * @param array $row The DB row containing PackingPart data.
	 * @return \PackingPartSheets\Domain\PackingPart
	 */
	protected function buildDomainObject($row) {
		$packingListPart = new PackingListPart();
		$packingListPart->setId($row['plp_id']);
		$packingListPart->setPlid($row['pl_id']);
		$packingListPart->setQuantity($row['plp_quantity']);

		if (array_key_exists('part_id', $row)) {
			// Find and set the associated part
			$partId = $row['part_id'];
			$part = $this->partDAO->find($partId);
			$packingListPart->setPartid($part);
		}

		return $packingListPart;
	}
}
