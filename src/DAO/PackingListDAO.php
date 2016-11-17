<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingList;

class PackingListDAO extends DAO
{

	/**
	 * @var \PackingSheets\DAO\PackingListPartDAO
	 */
	private $packingListPartDAO;

	public function setPackingListPartDAO(PackingListPartDAO $packingListPartDAO) {
		$this->packingListPartDAO = $packingListPartDAO;
	}

	/**
	 * Return a list of all PackingSheetParts, sorted by date (most recent first).
	 *
	 * @return array A list of all PackingSheetParts.
	 */
	public function findAll() {
		$sql = "select * from t_packinglist order by pl_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$packingLists = array();
		foreach ($result as $row) {
			$packingListId = $row['pl_id'];
			$packingLists[$packingListId] = $this->buildDomainObject($row);
		}
		return $packingLists;
	}

	/**
	 * Returns an PackingSheetPart matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingPartSheets\Domain\PackingSheetPart|throws an exception if no matching PackingSheetPart is found
	 */
	public function find($id) {
		$sql = "select * from t_packinglist where pl_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No PackingList matching id " . $id);
	}

	/**
	 * Add a PackingSheetPart into the database.
	 *
	 * @param \PackingSheets\Domain\PackingSheetPart $psPart The PackingSheetPart to save
	 */
	public function save(PackingList $packList) {
		
		$parts = $packList->getParts();
		$this->packingListPartDAO->deleteAll($packList->getId());
		
		foreach($parts as $part){
			$part->setId(null);
			$this->packingListPartDAO->save($part, $packList->getId());
		}

		$packListData = array(
				'ps_id' => $packList->getPsId(),
		);

		if ($packList->getId()) {
			// The PackingSheetPart has already been saved : update it
			$this->getDb()->update('t_packinglist', $packListData, array('pl_id' => $packList->getId()));
		} else {
			// The PackingSheetPart has never been saved : insert it
			$this->getDb()->insert('t_packinglist', $packListData);
			// Get the id of the newly created PackingSheetPart and set it on the entity.
			$id = $this->getDb()->lastInsertId();
			$packList->setId($id);
		}
	}

	/**
	 * Removes a PackingSheetPart from the database.
	 *
	 * @param integer $id The PackinhSheetPart id.
	 */
	public function delete($id) {
		//Delete the contact
		$this->getDb()->delete('t_packinglist', array('pl_id' => $id));
	}

	/**
	 * Return a list of all packinglist for a packingsheet.
	 *
	 * @param integer $packingsheetId The packingsheet id.
	 *
	 * @return the packinglist for the packingsheet.
	 */
	
	public function findByPackingSheet($packingSheetId) {
	
		$sql = "select * from t_packinglist where ps_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($packingSheetId));
	
		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No PackingList matching id " . $packingSheetId);
	}


	/**
	 * Creates a PackingList object based on a DB row.
	 *
	 * @param array $row The DB row containing PackingList data.
	 * @return \PackingPartSheets\Domain\PackingList
	 */
	protected function buildDomainObject($row) {
		$packingList = new PackingList();
		$packingList->setId($row['pl_id']);
		$packingList->setPsId($row['ps_id']);
		
		//Parts
		$packingList->setParts($this->packingListPartDAO->findAllByPackingList($row['pl_id']));

		return $packingList;
	}
}

