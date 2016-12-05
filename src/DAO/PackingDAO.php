<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Packing;

class PackingDAO extends DAO
{
	/**
	 * @var \PackingSheets\DAO\PackingPartDAO
	 */
	private $packingPartDAO;
	
	public function setPackingPartDAO(PackingPartDAO $packingPartDAO) {
		$this->packingPartDAO = $packingPartDAO;
	}
	
	/**
	 * @var \PackingSheets\DAO\PackTypeDAO
	 */
	private $packTypeDAO;
	
	public function setPackTypeDAO(PackTypeDAO $packTypeDAO) {
		$this->packTypeDAO = $packTypeDAO;
	}

    /**
     * Return a list of all Packings, sorted by date (most recent first).
     *
     * @return array A list of all Packings.
     */
    public function findAll() {
        $sql = "select * from t_packing order by pack_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $packings = array();
        foreach ($result as $row) {
            $packingId = $row['pack_id'];
            $packings[$packingId] = $this->buildDomainObject($row);
        }
        return $packings;
    }

    /**
    * Returns an Packing matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Packing|throws an exception if no matching Packing is found
    */
   public function find($id) {
       $sql = "select * from t_packing where pack_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Packing matching id " . $id);
   }

   /**
     * Return a list of all packings for a packingSheet.
     *
     * @param integer $packingSheetId The packingSheet id.
     *
     * @return array A list of all packings for the packingSheet.
     */
    public function findAllByPackingSheet($packingSheetId) {
        
        $sql = "select * from t_packing where ps_id=? order by pack_id";
        $result = $this->getDb()->fetchAll($sql, array($packingSheetId));

        // Convert query result to an array of domain objects
        $packings = array();
        foreach ($result as $row) {
            $packId = $row['pack_id'];
            $packing = $this->buildDomainObject($row);
            // The associated packingSheet is defined for the constructed packing
            $packings[$packId] = $packing;
        }
        return $packings;
    }
    
    /**
     * Add a Packing into the database.
     *
     * @param \PackingSheets\Domain\Packing $pack The Packing to save
     */
    public function save(Packing $pack) {
    	
    	$packData = array(
    			'ps_id' => $pack->getPSid(),
    			'pack_netWeight' => $pack->getNetWeight(),
    			'pack_grossWeight' => $pack->getGrossWeight(),
    			'pack_M1' => $pack->getM1(),
    			'pack_M2' => $pack->getM2(),
    			'pack_M3' => $pack->getM3(),
    			'pack_img' => "packing1.jpg",
    			'packType_id' => $pack->getPackTypeid()->getId(),
    	);
    	
    	if ($pack->getId()) {
    		// The Packing has already been saved : update it
    		$this->getDb()->update('t_packing', $packData, array('pack_id' => $pack->getId()));
    	} else {
    		// The Packing has never been saved : insert it
    		$this->getDb()->insert('t_packing', $packData);
    		// Get the id of the newly created Packing and set it on the entity.
    		$id = $this->getDb()->lastInsertId();
    		$pack->setId($id);
    	}
    	
    	$parts = $pack->getParts();
    	
    	$sql = "select * from t_packing_part where pack_id=?";
    	$result = $this->getDb()->fetchAll($sql, array($pack->getId()));
    	 
    	$partsDbini = array();
    	foreach ($result as $row) {
    		$partId = $row['pkp_id'];
    		$partsDbini[$partId] = $this->packingPartDAO->buildDomainObject($row);
    	}
    	
    	if(!empty($parts)){
    		 
    		foreach($parts as $part){
    			$part->setPackid($pack->getId());
    			$this->packingPartDAO->save($part);
    		}
    		 
    		$sql = "select * from t_packing_part where pack_id=?";
    		$result = $this->getDb()->fetchAll($sql, array($pack->getId()));
    		 
    		//var_dump($result);
    		//var_dump($packings);
    		
    		foreach($result as $partDb){
    			foreach($parts as $part){
    				$del =true;
    				if ($partDb['pkp_id'] === $part->getId())
    				{
    					$del = false;
    					break;
    				}
    			}
    			if($del){
    				$this->packingPartDAO->delete($partDb['pkp_id']);
    			}
    		}
    	
    	}
    	else{
    		foreach($partsDbini as $partDb){
    			$this->packingPartDAO->delete($partDb->getId());
    		}
    	}
    }
    
    
    /**
     * Removes a Packing from the database.
     *
     * @param integer $id The Packing id.
     */
    public function delete($id) {
    	//Delete the packing
    	$this->packingPartDAO->deleteAll($id);
    	$this->getDb()->delete('t_packing', array('pack_id' => $id));
    }
    
    public function deleteAll($psId){
    	foreach($this->findAllByPackingSheet($psId) as $pack){
    		$this->delete($pack->getId());
    	}
    }

    /**
     * Creates a Packing object based on a DB row.
     *
     * @param array $row The DB row containing Packing data.
     * @return \PackingSheets\Domain\Packing
     */
    protected function buildDomainObject($row) {
        $packing = new Packing();
        $packing->setId($row['pack_id']);
        $packing->setPSid($row['ps_id']);
        $packing->setNetWeight($row['pack_netWeight']);
        $packing->setGrossWeight($row['pack_grossWeight']);
        $packing->setM1($row['pack_M1']);
        $packing->setM2($row['pack_M2']);
        $packing->setM3($row['pack_M3']);
        $packing->setImg($row['pack_img']);

        //PackType
        if (array_key_exists('packType_id', $row)) {
        	// Find and set the associated packType
        	$packTypeId = $row['packType_id'];
        	$packType = $this->packTypeDAO->find($packTypeId);
        	$packing->setPackTypeid($packType);
        }
        
        //Parts
        $packing->setParts($this->packingPartDAO->findAllByPacking($row['pack_id']));

        return $packing;
    }
}
