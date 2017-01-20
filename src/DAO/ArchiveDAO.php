<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Archive;
use PackingSheets\Domain\ArchiveSearch;

class ArchiveDAO extends DAO
{

	/**
	 * Return a list of all Archives, sorted by date (most recent first).
	 *
	 * @return array A list of all Archives.
	 */
	public function findAll() {
		$sql = "select * from t_archive order by archive_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$archives = array();
		foreach ($result as $row) {
			$archiveId = $row['archive_id'];
			$archives[$archiveId] = $this->buildDomainObject($row);
		}
		return $archives;
	}

	/**
	 * Returns an Archive matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingSheets\Domain\Archive|throws an exception if no matching Archive is found
	 */
	public function find($id) {
		$sql = "select * from t_archive where archive_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No Archive matching id " . $id);
	}
	
	
	/**
	 * Return a list of filtered Archives, results of search.
	 *
	 * @return array A list of resulting Archives.
	 */
	public function findBySearch(ArchiveSearch $searchArchive) {
	
		$by_ref = $searchArchive->getRef();
		$by_user = $searchArchive->getUser();
		$by_date = $searchArchive->getSerializationDate();
	
		//Do real escaping here
	
		$query = "SELECT * FROM t_archive";
	
		$conditions = array();
	
		if ($by_ref != "") {
			$conditions[] = "archive_ref LIKE '%$by_ref%'";
		}
		if ($by_user != "") {
			$conditions[] = "archive_user LIKE '%$by_user%'";
		}
		if ($by_date != "") {
			$conditions[] = "archive_serializationdate LIKE '%$by_date%'";
		}
	
	
		$sql = $query;
		if (count($conditions) > 0) {
			$sql .= " WHERE " . implode(' AND ', $conditions);
		}
	
		//print_r($sql);exit;
		$result = $this->getDb()->fetchAll($sql);
	
		// Convert query result to an array of domain objects
		$archives = array();
		foreach ($result as $row) {
			$archiveId = $row['archive_id'];
			$archives[$archiveId] = $this->buildDomainObject($row);
		}
		return $archives;
	}
	 
	/**
	 * Saves a archive into the database.
	 *
	 * @param \PackingSheets\Domain\Archive $archive The archive to save
	 */
	public function save(Archive $archive) {

		$archiveData = array(
				'archive_ref' => $archive->getRef(),
				'archive_user' => $archive->getUser(),
				'archive_serializationdate' => $archive->getSerializationDate(),
				'archive_serializedpdf' => $archive->getSerializedPdf()
		);

		if ($archive->getId()) {
			// The archive has already been saved : update it
			$this->getDb()->update('t_archive', $archiveData, array('archive_id' => $archive->getId()));
		} else {
			// The article has never been saved : insert it
			$this->getDb()->insert('t_archive', $archiveData);
			// Get the id of the newly created archive and set it on the entity.
			$id = $this->getDb()->lastInsertId();
			$archive->setId($id);
		}
	}
	 
	/**
	 * Removes a archive from the database.
	 *
	 * @param integer $id The archive id.
	 */
	public function delete($id) {
		//Delete the archive
		$this->getDb()->delete('t_archive', array('archive_id' => $id));
	}

	/**
	 * Creates a Archive object based on a DB row.
	 *
	 * @param array $row The DB row containing Archive data.
	 * @return \PackingSheets\Domain\Archive
	 */
	protected function buildDomainObject($row) {
		$archive = new Archive();
		$archive->setId($row['archive_id']);
		$archive->setRef($row['archive_ref']);
		$archive->setUser($row['archive_user']);
		$archive->setSerializationDate($row['archive_serializationdate']);
		$archive->setSerializedPdf($row['archive_serializedpdf']);
		return $archive;
	}
}

