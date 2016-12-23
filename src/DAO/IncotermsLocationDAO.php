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
    * Saves a incotermsLocation into the database.
    *
    * @param \PackingSheets\Domain\IncotermsLocation $incotermsLocation The incotermsLocation to save
    */
   public function save(IncotermsLocation $incotermsLocation) {
   		
   	$incotermsLocationData = array(
   			'incLoc_label' => $incotermsLocation->getLabel()
   	);
   		
   	if ($incotermsLocation->getId()) {
   		// The incotermsLocation has already been saved : update it
   		$this->getDb()->update('t_incotermsLocation', $incotermsLocationData, array('incLoc_id' => $incotermsLocation->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_incotermsLocation', $incotermsLocationData);
   		// Get the id of the newly created incotermsLocation and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$incotermsLocation->setId($id);
   	}
   }
   
   /**
    * Removes a incotermsLocation from the database.
    *
    * @param integer $id The incotermsLocation id.
    */
   public function delete($id) {
   	//Delete the incotermsLocation
   	$this->getDb()->delete('t_incotermsLocation', array('incLoc_id' => $id));
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
