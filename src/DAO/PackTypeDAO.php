<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackType;

class PackTypeDAO extends DAO
{

    /**
     * Return a list of all PackTypes, sorted by date (most recent first).
     *
     * @return array A list of all PackTypes.
     */
    public function findAll() {
        $sql = "select * from t_packType order by packType_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $packTypes = array();
        foreach ($result as $row) {
            $packTypeId = $row['packType_id'];
            $packTypes[$packTypeId] = $this->buildDomainObject($row);
        }
        return $packTypes;
    }

    /**
    * Returns an PackType matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\PackType|throws an exception if no matching PackType is found
    */
   public function find($id) {
       $sql = "select * from t_packType where packType_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No PackType matching id " . $id);
   }

    /**
     * Creates a PackType object based on a DB row.
     *
     * @param array $row The DB row containing PackType data.
     * @return \PackingSheets\Domain\PackType
     */
    protected function buildDomainObject($row) {
        $packType = new PackType();
        $packType->setId($row['packType_id']);
        $packType->setLabel($row['packType_label']);
        return $packType;
    }
}
