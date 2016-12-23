<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\IncotermsType;

class IncotermsTypeDAO extends DAO
{

    /**
     * Return a list of all IncotermsTypes, sorted by date (most recent first).
     *
     * @return array A list of all IncotermsTypes.
     */
    public function findAll() {
        $sql = "select * from t_incotermsType order by incType_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $incotermsTypes = array();
        foreach ($result as $row) {
            $incotermsTypeId = $row['incType_id'];
            $incotermsTypes[$incotermsTypeId] = $this->buildDomainObject($row);
        }
        return $incotermsTypes;
    }

    /**
    * Returns an IncotermsType matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\IncotermsType|throws an exception if no matching IncotermsType is found
    */
   public function find($id) {
       $sql = "select * from t_incotermsType where incType_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No IncotermsType matching id " . $id);
   }
   
   /**
    * Saves a incotermsType into the database.
    *
    * @param \PackingSheets\Domain\IncotermsType $incotermsType The incotermsType to save
    */
   public function save(IncotermsType $incotermsType) {
   		
   	$incotermsTypeData = array(
   			'incType_label' => $incotermsType->getLabel()
   	);
   		
   	if ($incotermsType->getId()) {
   		// The incotermsType has already been saved : update it
   		$this->getDb()->update('t_incotermstype', $incotermsTypeData, array('incType_id' => $incotermsType->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_incotermstype', $incotermsTypeData);
   		// Get the id of the newly created incotermsType and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$incotermsType->setId($id);
   	}
   }
   
   /**
    * Removes a incotermsType from the database.
    *
    * @param integer $id The incotermsType id.
    */
   public function delete($id) {
   	//Delete the incotermsType
   	$this->getDb()->delete('t_incotermstype', array('incType_id' => $id));
   }

    /**
     * Creates a IncotermsType object based on a DB row.
     *
     * @param array $row The DB row containing IncotermsType data.
     * @return \PackingSheets\Domain\IncotermsType
     */
    protected function buildDomainObject($row) {
        $incotermsType = new IncotermsType();
        $incotermsType->setId($row['incType_id']);
        $incotermsType->setLabel($row['incType_label']);
        return $incotermsType;
    }
}
