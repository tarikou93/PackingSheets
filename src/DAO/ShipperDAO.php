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
    * Saves a shipper into the database.
    *
    * @param \PackingSheets\Domain\Shipper $shipper The shipper to save
    */
   public function save(Shipper $shipper) {
   		
   	$shipperData = array(
   			'ship_label' => $shipper->getLabel()
   	);
   		
   	if ($shipper->getId()) {
   		// The shipper has already been saved : update it
   		$this->getDb()->update('t_shipper', $shipperData, array('ship_id' => $shipper->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_shipper', $shipperData);
   		// Get the id of the newly created shipper and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$shipper->setId($id);
   	}
   }
   
   /**
    * Removes a shipper from the database.
    *
    * @param integer $id The shipper id.
    */
   public function delete($id) {
   	//Delete the shipper
   	$this->getDb()->delete('t_shipper', array('ship_id' => $id));
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
