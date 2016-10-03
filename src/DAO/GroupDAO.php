<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Group;

class GroupDAO extends DAO
{

    /**
     * Return a list of all Groups, sorted by date (most recent first).
     *
     * @return array A list of all Groups.
     */
    public function findAll() {
        $sql = "select * from t_group order by group_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $groups = array();
        foreach ($result as $row) {
            $groupId = $row['group_id'];
            $groups[$groupId] = $this->buildDomainObject($row);
        }
        return $groups;
    }

    /**
    * Returns an Group matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Group|throws an exception if no matching Group is found
    */
   public function find($id) {
       $sql = "select * from t_group where group_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Group matching id " . $id);
   }

    /**
     * Creates a Group object based on a DB row.
     *
     * @param array $row The DB row containing Group data.
     * @return \PackingSheets\Domain\Group
     */
    protected function buildDomainObject($row) {
        $group = new Group();
        $group->setId($row['group_id']);
        $group->setLabel($row['group_label']);
        return $group;
    }
}
