<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Shipper;

class ShipperDAO extends DAO
{

    /**
     * Return a list of all Shippers, sorted by date (most recent first).
     *
     * @return array A list of all Shippers.
     */
    public function findAll() {
        $sql = "select * from t_shipper order by ship_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $shippers = array();
        foreach ($result as $row) {
            $shipperId = $row['ship_id'];
            $shippers[$shipperId] = $this->buildDomainObject($row);
        }
        return $shippers;
    }

    /**
    * Returns an Shipper matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Shipper|throws an exception if no matching Shipper is found
    */
   public function find($id) {
       $sql = "select * from t_shipper where ship_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Shipper matching id " . $id);
   }

    /**
     * Creates a Shipper object based on a DB row.
     *
     * @param array $row The DB row containing Shipper data.
     * @return \PackingSheets\Domain\Shipper
     */
    protected function buildDomainObject($row) {
        $shipper = new Shipper();
        $shipper->setId($row['ship_id']);
        $shipper->setLabel($row['ship_label']);
        return $shipper;
    }
}
