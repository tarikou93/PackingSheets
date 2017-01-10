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
        $sql = "select * from t_customStatus order by custStat_label";
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
    * Saves a customStatus into the database.
    *
    * @param \PackingSheets\Domain\CustomStatus $customStatus The customStatus to save
    */
   public function save(CustomStatus $customStatus) {
   
   	$customStatusData = array(
   			'custStat_label' => $customStatus->getLabel(),
   			'custStat_text' => $customStatus->getText()
   	);
   
   	if ($customStatus->getId()) {
   		// The customStatus has already been saved : update it
   		$this->getDb()->update('t_customStatus', $customStatusData, array('custStat_id' => $customStatus->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_customStatus', $customStatusData);
   		// Get the id of the newly created customStatus and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$customStatus->setId($id);
   	}
   }
    
   /**
    * Removes a customStatus from the database.
    *
    * @param integer $id The customStatus id.
    */
   public function delete($id) {
   	//Delete the customStatus
   	$this->getDb()->delete('t_customStatus', array('custStat_id' => $id));
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
