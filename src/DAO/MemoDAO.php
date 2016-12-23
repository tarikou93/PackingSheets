<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Memo;

class MemoDAO extends DAO
{

	/**
	 * Return a list of all Memos, sorted by date (most recent first).
	 *
	 * @return array A list of all Memos.
	 */
	public function findAll() {
		$sql = "select * from t_memo order by memo_id desc";
		$result = $this->getDb()->fetchAll($sql);

		// Convert query result to an array of domain objects
		$memos = array();
		foreach ($result as $row) {
			$memoId = $row['memo_id'];
			$memos[$memoId] = $this->buildDomainObject($row);
		}
		return $memos;
	}

	/**
	 * Returns an Memo matching the supplied id.
	 *
	 * @param integer $id
	 *
	 * @return \PackingSheets\Domain\Memo|throws an exception if no matching Memo is found
	 */
	public function find($id) {
		$sql = "select * from t_memo where memo_id=?";
		$row = $this->getDb()->fetchAssoc($sql, array($id));

		if ($row)
			return $this->buildDomainObject($row);
			else
				throw new \Exception("No Memo matching id " . $id);
	}
	
	/**
	 * Saves a memo into the database.
	 *
	 * @param \PackingSheets\Domain\Memo $memo The memo to save
	 */
	public function save(Memo $memo) {
			
		$memoData = array(
				'memo_label' => $memo->getLabel()
		);
			
		if ($memo->getId()) {
			// The memo has already been saved : update it
			$this->getDb()->update('t_memo', $memoData, array('memo_id' => $memo->getId()));
		} else {
			// The article has never been saved : insert it
			$this->getDb()->insert('t_memo', $memoData);
			// Get the id of the newly created memo and set it on the entity.
			$id = $this->getDb()->lastInsertId();
			$memo->setId($id);
		}
	}
	
	/**
	 * Removes a memo from the database.
	 *
	 * @param integer $id The memo id.
	 */
	public function delete($id) {
		//Delete the memo
		$this->getDb()->delete('t_memo', array('memo_id' => $id));
	}

	/**
	 * Creates a Memo object based on a DB row.
	 *
	 * @param array $row The DB row containing Memo data.
	 * @return \PackingSheets\Domain\Memo
	 */
	protected function buildDomainObject($row) {
		$memo = new Memo();
		$memo->setId($row['memo_id']);
		$memo->setLabel($row['memo_label']);
		return $memo;
	}
}
