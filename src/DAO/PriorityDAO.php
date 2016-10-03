<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Priority;

class PriorityDAO extends DAO
{

    /**
     * Return a list of all Prioritys, sorted by date (most recent first).
     *
     * @return array A list of all Prioritys.
     */
    public function findAll() {
        $sql = "select * from t_priority order by prior_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $prioritys = array();
        foreach ($result as $row) {
            $priorityId = $row['prior_id'];
            $prioritys[$priorityId] = $this->buildDomainObject($row);
        }
        return $prioritys;
    }

    /**
    * Returns an Priority matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Priority|throws an exception if no matching Priority is found
    */
   public function find($id) {
       $sql = "select * from t_priority where prior_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Priority matching id " . $id);
   }

    /**
     * Creates a Priority object based on a DB row.
     *
     * @param array $row The DB row containing Priority data.
     * @return \PackingSheets\Domain\Priority
     */
    protected function buildDomainObject($row) {
        $priority = new Priority();
        $priority->setId($row['prior_id']);
        $priority->setLabel($row['prior_label']);
        return $priority;
    }
}
