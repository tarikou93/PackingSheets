<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\IncotermsLocation;

class IncotermsLocationDAO extends DAO
{

    /**
     * Return a list of all IncotermsLocations, sorted by date (most recent first).
     *
     * @return array A list of all IncotermsLocations.
     */
    public function findAll() {
        $sql = "select * from t_incotermsLocation order by incLoc_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $incotermsLocations = array();
        foreach ($result as $row) {
            $incotermsLocationId = $row['incLoc_id'];
            $incotermsLocations[$incotermsLocationId] = $this->buildDomainObject($row);
        }
        return $incotermsLocations;
    }

    /**
    * Returns an IncotermsLocation matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\IncotermsLocation|throws an exception if no matching IncotermsLocation is found
    */
   public function find($id) {
       $sql = "select * from t_incotermsLocation where incLoc_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No IncotermsLocation matching id " . $id);
   }

    /**
     * Creates a IncotermsLocation object based on a DB row.
     *
     * @param array $row The DB row containing IncotermsLocation data.
     * @return \PackingSheets\Domain\IncotermsLocation
     */
    protected function buildDomainObject($row) {
        $incotermsLocation = new IncotermsLocation();
        $incotermsLocation->setId($row['incLoc_id']);
        $incotermsLocation->setLabel($row['incLoc_label']);
        return $incotermsLocation;
    }
}
