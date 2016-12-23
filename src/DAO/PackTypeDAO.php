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
    * Saves a packType into the database.
    *
    * @param \PackingSheets\Domain\PackType $packType The packType to save
    */
   public function save(PackType $packType) {
   		
   	$packTypeData = array(
   			'packType_label' => $packType->getLabel()
   	);
   		
   	if ($packType->getId()) {
   		// The packType has already been saved : update it
   		$this->getDb()->update('t_packtype', $packTypeData, array('packType_id' => $packType->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_packtype', $packTypeData);
   		// Get the id of the newly created packType and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$packType->setId($id);
   	}
   }
   
   /**
    * Removes a packType from the database.
    *
    * @param integer $id The packType id.
    */
   public function delete($id) {
   	//Delete the packType
   	$this->getDb()->delete('t_packtype', array('packType_id' => $id));
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
