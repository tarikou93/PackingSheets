<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingSheet;
use PackingSheets\Domain\PackingSheetSearch;
use PackingSheets\Domain\PackingList;

class PackingSheetDAO extends DAO
{

    /**
     * @var \PackingSheets\DAO\AdressDAO
     */
    private $consignedAddressDAO;

    public function setConsignedAddressDAO(AddressDAO $addressDAO) {
        $this->consignedAddressDAO = $addressDAO;
    }

    /**
     * @var \PackingSheets\DAO\AdressDAO
     */
    private $deliveryAddressDAO;

    public function setDeliveryAddressDAO(AddressDAO $addressDAO) {
        $this->deliveryAddressDAO = $addressDAO;
    }
    
    /**
     * @var \PackingSheets\DAO\ContactDAO
     */
    private $consignedContactDAO;

    public function setConsignedContactDAO(ContactDAO $contactDAO) {
        $this->consignedContactDAO = $contactDAO;
    }

    /**
     * @var \PackingSheets\DAO\ContactDAO
     */
    private $deliveryContactDAO;

    public function setDeliveryContactDAO(ContactDAO $contactDAO) {
        $this->deliveryContactDAO = $contactDAO;
    }

    /**
     * @var \PackingSheets\DAO\ServiceDAO
     */
    private $serviceDAO;

    public function setServiceDAO(ServiceDAO $serviceDAO) {
        $this->serviceDAO = $serviceDAO;
    }

    /**
     * @var \PackingSheets\DAO\ContentDAO
     */
    private $contentDAO;

    public function setContentDAO(ContentDAO $contentDAO) {
        $this->contentDAO = $contentDAO;
    }

    /**
     * @var \PackingSheets\DAO\PriorityDAO
     */
    private $priorityDAO;

    public function setPriorityDAO(PriorityDAO $priorityDAO) {
        $this->priorityDAO = $priorityDAO;
    }

    /**
     * @var \PackingSheets\DAO\ShipperDAO
     */
    private $shipperDAO;

    public function setShipperDAO(ShipperDAO $shipperDAO) {
        $this->shipperDAO = $shipperDAO;
    }

    public function getShipperDAO() {
        return $this->shipperDAO;
    }


    /**
     * @var \PackingSheets\DAO\CustomStatusDAO
     */
    private $customStatusDAO;

    public function setCustomStatusDAO(CustomStatusDAO $customStatusDAO) {
        $this->customStatusDAO = $customStatusDAO;
    }

    /**
     * @var \PackingSheets\DAO\IncotermsTypeDAO
     */
    private $incotermsTypeDAO;

    public function setIncotermsTypeDAO(IncotermsTypeDAO $incotermsTypeDAO) {
        $this->incotermsTypeDAO = $incotermsTypeDAO;
    }

    /**
     * @var \PackingSheets\DAO\IncotermsLocationDAO
     */
    private $incotermsLocationDAO;

    public function setIncotermsLocationDAO(IncotermsLocationDAO $incotermsLocationDAO) {
        $this->incotermsLocationDAO = $incotermsLocationDAO;
    }

    /**
     * @var \PackingSheets\DAO\CurrencyDAO
     */
    private $currencyDAO;

    public function setCurrencyDAO(CurrencyDAO $currencyDAO) {
        $this->currencyDAO = $currencyDAO;
    }

    /**
     * @var \PackingSheets\DAO\ImputDAO
     */
    private $imputDAO;

    public function setImputDAO(ImputDAO $imputDAO) {
        $this->imputDAO = $imputDAO;
    }
    
    /**
     * @var \PackingSheets\DAO\PackingDAO
     */
    private $packingDAO;
    
    public function setPackingDAO(PackingDAO $packingDAO) {
    	$this->packingDAO = $packingDAO;
    }
    
    /**
     * @var \PackingSheets\DAO\PackingListDAO
     */
    private $packingListDAO;
    
    public function setPackingListDAO(PackingListDAO $packingListDAO) {
    	$this->packingListDAO = $packingListDAO;
    }

    /**
     * Return a list of all PackingSheets, sorted by date (most recent first).
     *
     * @return array A list of all PackingSheets.
     */
    public function findAll() {
        $sql = "select * from t_packingsheet order by ps_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $packingSheets = array();
        foreach ($result as $row) {
            $packingSheetId = $row['ps_id'];
            $packingSheets[$packingSheetId] = $this->buildDomainObject($row);
        }
        return $packingSheets;
    }
    
    /**
     * Return a list of all PackingSheets for a user, sorted by date (most recent first).
     *
     * @return array A list of all PackingSheets accesible for the current user.
     */
    public function findAllByUserSeries($series) {
		
    	$sql = "select * from t_packingsheet where group_id in (".implode(',',$series).") order by ps_id desc";
    	$result = $this->getDb()->fetchAll($sql);
    
    	// Convert query result to an array of domain objects
    	$packingSheets = array();
    	foreach ($result as $row) {
    		$packingSheetId = $row['ps_id'];
    		$packingSheets[$packingSheetId] = $this->buildDomainObject($row);
    	}
    	return $packingSheets;
    }

    /**
     * Return a list of filtered PackingSheets, results of search.
     *
     * @return array A list of resulting PackingSheets.
     */
    public function findBySearch(PackingSheetSearch $psSearch) {
    	
    	//var_dump($psSearch);exit;
    	
        $by_ref = (null !== $psSearch->getRef()) ? $psSearch->getRef() : "";
        $by_awb = (null !== $psSearch->getAWB()) ? $psSearch->getAWB() : "";
        $by_date = (null !== $psSearch->getDateIssue()) ? $psSearch->getDateIssue() : "";
        $by_pn = (null !== $psSearch->getPn()) ? $psSearch->getPn() : "";
        $by_sn = (null !== $psSearch->getSerial()) ? $psSearch->getSerial() : "";
        $by_desc = (null !== $psSearch->getDesc()) ? $psSearch->getDesc() : "";
        $by_hscode = (null !== $psSearch->getHSCode()) ? $psSearch->getHSCode() : "";
        $by_input = (null !== $psSearch->getImputId()) ? $psSearch->getImputId()->getId() : "";
        $by_service = (null !== $psSearch->getServiceId()) ? $psSearch->getServiceId()->getId() : "";
        $by_address = (null !== $psSearch->getDatalistAddress()) ? $psSearch->getDatalistAddress() : "";
        $by_contact = (null !== $psSearch->getDatalistContact()) ? $psSearch->getDatalistContact() : "";
        $signed = $psSearch->getSigned();
        $printed = $psSearch->getPrinted();
        $by_group = (null !== $psSearch->getGroupId()) ? $psSearch->getGroupId() : "";
        $by_code = (null !== $psSearch->getDatalistCode()) ? $psSearch->getDatalistCode() : "";
              
        $selectedGroups = "";
        $groupsLength = count($by_group);
        
        for ($i = 0; $i < $groupsLength; $i++) {
        	if($i === $groupsLength-1){
        		$selectedGroups .= $by_group[$i];
        	}
        	else{
        		$selectedGroups .= $by_group[$i].",";
        	}
        }
            
        //Do real escaping here

        $query = "SELECT ps.*
                FROM t_packingsheet ps
                LEFT JOIN t_packing pack
                    ON ps.ps_id = pack.ps_id
                LEFT JOIN t_packing_part packpart
                    ON packpart.pack_id = pack.pack_id
               	LEFT JOIN t_part part
                    ON packpart.part_id = part.part_id
        		LEFT JOIN t_address address
        			ON address.address_id = ps.consignedAddress_id
        		LEFT JOIN t_contact contact
        			ON ps.consignedContact_id = contact.contact_id
        		LEFT JOIN t_code code
                    ON code.code_id = address.address_codeId";
        
        
        $conditions = array();

        if ($by_ref != "") {
            $conditions[] = "ps_ref LIKE '%$by_ref%'";
        }
        
        if ($by_awb != "") {
            $conditions[] = "ps_AWB LIKE '%$by_awb%'";
        }
        
        if ($by_date != "") {
            $conditions[] = "ps_dateIssue LIKE '%$by_date%'";
        }
        
        if ($by_pn != "") {
            $conditions[] = "part_pn LIKE '%$by_pn%'";
        }
        
        if ($by_sn != "") {
            $conditions[] = "part_serial LIKE '%$by_sn%'";
        }
        
        if ($by_desc != "") {
            $conditions[] = "part_desc LIKE '%$by_desc%'";
        }
        
        if ($by_hscode != "") {
            $conditions[] = "part_HSCode LIKE '%$by_hscode%'";
        }
        
        if ($by_input != "") {
            $conditions[] = "imput_id LIKE '%$by_input%'";
        }
        
        if ($by_service != "") {
        	$conditions[] = "service_id LIKE '%$by_service%'";
        }
        
        if ($signed) {
            $conditions[] = "ps_signed = 1";
        }
        
        if ($printed) {
            $conditions[] = "ps_printed = 1";
        }

        if ($by_code != "") {
        	$conditions[] = "code_id LIKE '%$by_code%'";
        }
        
        if ($by_address != "") {
            $conditions[] = "consignedAddress_id LIKE '%$by_address%'";
        }
        
        if ($by_contact != "") {
            $conditions[] = "consignedContact_id LIKE '%$by_contact%'";
        }
        
        if ($selectedGroups != "") {
        	$conditions[] = "group_id IN ($selectedGroups)";
        }
        
        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
                  
        //print_r($sql);exit;
        
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $packingSheets = array();
        foreach ($result as $row) {
            $packingSheetId = $row['ps_id'];
            $packingSheets[$packingSheetId] = $this->buildDomainObject($row);
        }
        
        return $packingSheets;
    }

    /**
    * Returns an PackingSheet matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheet\Domain\PackingSheet|throws an exception if no matching PackingSheet is found
    */
   public function find($id) {
       $sql = "select * from t_packingsheet where ps_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No PackingSheet matching id " . $id);
   }
   
   /**
    * Returns the last inserted Id in the PS table for the supplied group id.
    *
    * @param integer $id
    *
    * @return int
    */
   public function getGroupLastId($id) {
	   	$sql = "select count(group_id) from t_packingsheet where group_id=".$id;
	   	$row = $this->getDb()->fetchAssoc($sql);
	   
	   	if($row){
	   		return ($row['count(group_id)'] + 1);
	   	}
   }
   
   /**
    * Add a Packing into the database.
    *
    * @param \PackingSheets\Domain\Packing $pack The Packing to save
    */
   public function save(PackingSheet $packingSheet, $userName) {
   	
   	$packingSheetData = array(
   			'ps_id' => $packingSheet->getId(),
   			'ps_ref' => ($packingSheet->getRef() === null) ? (date('Ymd').'/'.$packingSheet->getGroupId().($this->getGroupLastId($packingSheet->getGroupId()))) : $packingSheet->getRef(),
   			'group_id' => $packingSheet->getGroupId(),
   			'consignedAddress_id' => ($packingSheet->getConsignedAddressId() === null) ? null : $packingSheet->getConsignedAddressId()->getId(),
   			'deliveryAddress_id' => ($packingSheet->getDeliveryAddressId() === null) ? null : $packingSheet->getDeliveryAddressId()->getId(),
   			'consignedContact_id' => ($packingSheet->getConsignedContactId() === null) ? null : $packingSheet->getConsignedContactId()->getId(),
   			'deliveryContact_id' => ($packingSheet->getDeliveryContactId() === null) ? null : $packingSheet->getDeliveryContactId()->getId(),
   			'service_id' => ($packingSheet->getServiceId() === null) ? null : $packingSheet->getServiceId()->getId(),
   			'content_id' => ($packingSheet->getContentId() === null) ? null : $packingSheet->getContentId()->getId(),
   			'priority_id' => ($packingSheet->getPriorityId() === null) ? null : $packingSheet->getPriorityId()->getId(),
   			'shipper_id' => ($packingSheet->getShipperId() === null) ? null : $packingSheet->getShipperId()->getId(),
   			'ps_yrOrder' => $packingSheet->getYROrder(),
   			'ps_AWB' => $packingSheet->getAWB(),
   			'ps_dateIssue' => $packingSheet->getDateIssue(),
   			'ps_collect' => ($packingSheet->getCollect() === true) ? 1 : 0,
   			'ps_autority' => ($packingSheet->getAutority() === null) ? $userName : $packingSheet->getAutority(),
   			'customStatus_id' => ($packingSheet->getCustomStatusId() === null) ? null : $packingSheet->getCustomStatusId()->getId(),
   			'incType_id' => ($packingSheet->getIncTypeId() === null) ? null : $packingSheet->getIncTypeId()->getId(),
   			'incLoc_id' => ($packingSheet->getIncLocId() === null) ? null : $packingSheet->getIncLocId()->getId(),
   			'currency_id' => ($packingSheet->getCurrencyId() === null) ? null : $packingSheet->getCurrencyId()->getId(),
   			'imput_id' => ($packingSheet->getImputId() === null) ? null : $packingSheet->getImputId()->getId(),
   			'ps_signed' => ($packingSheet->getSigned() === true) ? 1 : 0,
   			'ps_printed' => ($packingSheet->getPrinted() === true) ? 1 : 0,
   			'ps_memo' => $packingSheet->getMemo(),
   			'ps_Weight' => ($packingSheet->getWeight() === null) ? 0 : $packingSheet->getWeight(),
   			'ps_totalPrice' => ($packingSheet->getTotalPrice() === null) ? 0 : $packingSheet->getTotalPrice(),
   			'ps_nbrPieces' => ($packingSheet->getNbrPieces() === null) ? 0 : $packingSheet->getNbrPieces(),
   	
   	);
   	 
   	if ($packingSheet->getId()) {
   		// The PackingSheet has already been saved : update it
   		$this->getDb()->update('t_packingsheet', $packingSheetData, array('ps_id' => $packingSheet->getId()));
   	} else {
   		// The PackingSheetPart has never been saved : insert it
   		$this->getDb()->insert('t_packingsheet', $packingSheetData);
   		// Get the id of the newly created PackingSheetPart and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$packingSheet->setId($id);
   	}
   	
   	if($packingSheet->getPackingList() === null){
   		$packingList = new PackingList();
   		$packingList->setPsId($packingSheet->getId());
   		$this->packingListDAO->save($packingList);
   	}
   	
   	else{
   		$this->packingListDAO->save($packingSheet->getPackingList());
   	}
   	
   	$packings = $packingSheet->getPackings();
   	//var_dump($packings);exit;
   		
   	$sql = "select * from t_packing where ps_id=?";
   	$result = $this->getDb()->fetchAll($sql, array($packingSheet->getId()));
   	 
   	$packingsDbini = array();
   	foreach ($result as $row) {
   		$packingId = $row['pack_id'];
   		$packingsDbini[$packingId] = $this->packingDAO->buildDomainObject($row);
   	}
   	
   	if(!empty($packings)){
   		   		
   		foreach($packings as $pack){
   			$pack->setPSid($packingSheet->getId());
   			$this->packingDAO->save($pack);
   		}
   		
   		$sql = "select * from t_packing where ps_id=?";
   		$result = $this->getDb()->fetchAll($sql, array($packingSheet->getId()));
   		
   		//var_dump($result);
   		//var_dump($packings);
   		 
   		foreach($result as $packDb){
   			foreach($packings as $packing){
   				$del =true;
   				if ($packDb['pack_id'] === $packing->getId())
   				{
   					$del = false;
   					break;
   				}
   			}
   			if($del){
   				$this->packingDAO->delete($packDb['pack_id']);
   			}
   		}
   	}
   	else{
   		foreach($packingsDbini as $packDb){
   			$this->packingDAO->delete($packDb->getId());
   		}
   	}
   	
   }
   
   /**
    * Removes a Packing from the database.
    *
    * @param integer $id The Packing id.
    */
   public function delete($id) {
   	//Delete the packingSheet
   	$this->packingDAO->deleteAll($id);
   	$this->packingListDAO->delete($id);
   	$this->getDb()->delete('t_packingsheet', array('ps_id' => $id));
   }

    /**
     * Creates a PackingSheet object based on a DB row.
     *
     * @param array $row The DB row containing PackingSheet data.
     * @return \PackingSheets\Domain\PackingSheet
     */
    protected function buildDomainObject($row) {
    	
    	$signed = ($row['ps_signed'] === '1') ? true : false;
    	$printed = ($row['ps_printed'] === '1') ? true : false;
    	$collect = ($row['ps_collect'] === '1') ? true : false;
    	
        $packingSheet = new PackingSheet();
        $packingSheet->setId($row['ps_id']);
        $packingSheet->setRef($row['ps_ref']);
        $packingSheet->setGroupId($row['group_id']);
        $packingSheet->setYROrder($row['ps_yrOrder']);
        $packingSheet->setAWB($row['ps_AWB']);
        $packingSheet->setDateIssue($row['ps_dateIssue']);
        $packingSheet->setNbrPieces($row['ps_nbrPieces']);
        $packingSheet->setTotalPrice($row['ps_totalPrice']);
        $packingSheet->setWeight($row['ps_weight']);
        $packingSheet->setSigned($signed);
        $packingSheet->setPrinted($printed);
        $packingSheet->setMemo($row['ps_memo']);
        $packingSheet->setCollect($collect);
        $packingSheet->setAutority($row['ps_autority']);

        if (array_key_exists('consignedAddress_id', $row)) {
            // Find and set the associated consignedAddress
            $consignedAddressId = $row['consignedAddress_id'];
            if($consignedAddressId !== null){
            	$consignedAddress = $this->consignedAddressDAO->find($consignedAddressId);
            	$packingSheet->setConsignedAddressId($consignedAddress);
            }
            else{
            	$packingSheet->setConsignedAddressId(null);
            }
        }

        if (array_key_exists('deliveryAddress_id', $row)) {
            // Find and set the associated deliveryAddress
            $deliveryAddressId = $row['deliveryAddress_id'];
            if($deliveryAddressId !== null){
            	$deliveryAddress = $this->deliveryAddressDAO->find($deliveryAddressId);
            	$packingSheet->setDeliveryAddressId($deliveryAddress);
            }
            else{
            	$packingSheet->setDeliveryAddressId(null);
            }
        }
        
        if (array_key_exists('consignedContact_id', $row)) {
            // Find and set the associated consignedContact
            $consignedContactId = $row['consignedContact_id'];
            if($consignedContactId !== null){
            	$consignedContact = $this->consignedContactDAO->find($consignedContactId);
            	$packingSheet->setConsignedContactId($consignedContact);
            }
            else{
            	$packingSheet->setConsignedContactId(null);
            }
        }

        if (array_key_exists('deliveryContact_id', $row)) {
            // Find and set the associated deliveryContact
            $deliveryContactId = $row['deliveryContact_id'];
            if($deliveryContactId !== null){
            	$deliveryContact = $this->deliveryContactDAO->find($deliveryContactId);
            	$packingSheet->setDeliveryContactId($deliveryContact);
            }
            else{
            	$packingSheet->setDeliveryContactId(null);
            }
        }

        if (array_key_exists('service_id', $row)) {
            // Find and set the associated service
            $serviceId = $row['service_id'];
            if($serviceId !== null){
            	$service = $this->serviceDAO->find($serviceId);
            	$packingSheet->setServiceId($service);
            }
            else{
            	$packingSheet->setServiceId(null);
            }
        }

        if (array_key_exists('content_id', $row)) {
            // Find and set the associated content
            $contentId = $row['content_id'];
            if($contentId !== null){
            	$content = $this->contentDAO->find($contentId);
            	$packingSheet->setContentId($content);
            }
            else{
            	$packingSheet->setContentId(null);
            }
        }

        if (array_key_exists('priority_id', $row)) {
            // Find and set the associated priority
            $priorityId = $row['priority_id'];
            if($priorityId !== null){
            	$priority = $this->priorityDAO->find($priorityId);
            	$packingSheet->setPriorityId($priority);
            }
            else{
            	$packingSheet->setPriorityId(null);
            }
        }

        if (array_key_exists('shipper_id', $row)) {
            // Find and set the associated shipper
            $shipperId = $row['shipper_id'];
            if($shipperId !== null){
            	$shipper = $this->shipperDAO->find($shipperId);
            	$packingSheet->setShipperId($shipper);
            }
            else{
            	$packingSheet->setShipperId(null);
            }
        }


        if (array_key_exists('customStatus_id', $row)) {
            // Find and set the associated customStatus
            $customStatusId = $row['customStatus_id'];
            if($customStatusId !== null){
            	$customStatus = $this->customStatusDAO->find($customStatusId);
            	$packingSheet->setCustomStatusId($customStatus);
            }
            else{
            	$packingSheet->setCustomStatusId(null);
            }
        }

        if (array_key_exists('incType_id', $row)) {
            // Find and set the associated incType
            $incotermsTypeId = $row['incType_id'];
            if($incotermsTypeId !== null){
            	$incotermsType = $this->incotermsTypeDAO->find($incotermsTypeId);
            	$packingSheet->setIncTypeId($incotermsType);
            }
            else{
            	$packingSheet->setIncTypeId(null);
            }
        }

        if (array_key_exists('incLoc_id', $row)) {
            // Find and set the associated incLoc
            $incotermsLocationId = $row['incLoc_id'];
            if($incotermsLocationId !== null){
            	$incotermsLocation = $this->incotermsLocationDAO->find($incotermsLocationId);
            	$packingSheet->setIncLocId($incotermsLocation);
            }
            else{
            	$packingSheet->setIncLocId(null);
            }
        }

        if (array_key_exists('currency_id', $row)) {
            // Find and set the associated currency
            $currencyId = $row['currency_id'];
            if($currencyId !== null){
            	$currency = $this->currencyDAO->find($currencyId);
            	$packingSheet->setCurrencyId($currency);
            }
            else{
            	$packingSheet->setCurrencyId(null);
            }
        }

        if (array_key_exists('imput_id', $row)) {
            // Find and set the associated imput
            $imputId = $row['imput_id'];
            if($imputId !== null){
            	$imput = $this->imputDAO->find($imputId);
            	$packingSheet->setImputId($imput);
            }
            else{
            	$packingSheet->setImputId(null);
            }
        }
        
        //Packings
        $packingSheet->setPackings($this->packingDAO->findAllByPackingSheet($row['ps_id']));
        $packingSheet->setNbrPieces(count($packingSheet->getPackings()));
        
        //Weight and Price
        $totWeight = 0;
        $totPrice = 0;
        
        foreach($packingSheet->getPackings() as $pack){
        	$totWeight += $pack->getGrossWeight();
        	foreach($pack->getParts() as $part){
        		$totPrice += $part->getPartid()->getPrice();
        	}
        }
        
        $packingSheet->setTotalPrice($totPrice);
        $packingSheet->setWeight($totWeight);

        $packingSheet->setPackingList($this->packingListDAO->findByPackingSheet($row['ps_id']));

        return $packingSheet;
    }
}
