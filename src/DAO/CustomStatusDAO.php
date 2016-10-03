<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\CustomStatus;

class CustomStatusDAO extends DAO
{

    /**
     * Return a list of all CustomStatuss, sorted by date (most recent first).
     *
     * @return array A list of all CustomStatuss.
     */
    public function findAll() {
        $sql = "select * from t_customStatus order by custStat_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $customStatuss = array();
        foreach ($result as $row) {
            $customStatusId = $row['custStat_id'];
            $customStatuss[$customStatusId] = $this->buildDomainObject($row);
        }
        return $customStatuss;
    }

    /**
    * Returns an CustomStatus matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\CustomStatus|throws an exception if no matching CustomStatus is found
    */
   public function find($id) {
       $sql = "select * from t_customStatus where custStat_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No CustomStatus matching id " . $id);
   }

    /**
     * Creates a CustomStatus object based on a DB row.
     *
     * @param array $row The DB row containing CustomStatus data.
     * @return \PackingSheets\Domain\CustomStatus
     */
    protected function buildDomainObject($row) {
        $customStatus = new CustomStatus();
        $customStatus->setId($row['custStat_id']);
        $customStatus->setLabel($row['custStat_label']);
        $customStatus->setText($row['custStat_text']);
        return $customStatus;
    }
}
