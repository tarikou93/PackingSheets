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
