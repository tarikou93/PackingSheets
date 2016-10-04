<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingSheet;

class PackingSheetDAO extends DAO
{

    /**
     * @var \PackingSheets\DAO\GroupDAO
     */
    private $groupDAO;

    public function setGroupDAO(GroupDAO $groupDAO) {
        $this->groupDAO = $groupDAO;
    }

    /**
     * @var \PackingSheets\DAO\CodeDAO
     */
    private $consignedCodeDAO;

    public function setConsignedCodeDAO(CodeDAO $codeDAO) {
        $this->consignedCodeDAO = $codeDAO;
    }

    /**
     * @var \PackingSheets\DAO\CodeDAO
     */
    private $deliveryCodeDAO;

    public function setDeliveryCodeDAO(CodeDAO $codeDAO) {
        $this->deliveryCodeDAO = $codeDAO;
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
     * @var \PackingSheets\DAO\AutorityDAO
     */
    private $autorityDAO;

    public function setAutorityDAO(AutorityDAO $autorityDAO) {
        $this->autorityDAO = $autorityDAO;
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
     * Creates a PackingSheet object based on a DB row.
     *
     * @param array $row The DB row containing PackingSheet data.
     * @return \PackingSheets\Domain\PackingSheet
     */
    protected function buildDomainObject($row) {
        $packingSheet = new PackingSheet();
        $packingSheet->setId($row['ps_id']);
        $packingSheet->setRef($row['ps_ref']);
        $packingSheet->setYROrder($row['ps_yrOrder']);
        $packingSheet->setAWB($row['ps_AWB']);
        $packingSheet->setDateIssue($row['ps_dateIssue']);
        $packingSheet->setNbrPieces($row['ps_nbrPieces']);
        $packingSheet->setTotalPrice($row['ps_totalPrice']);
        $packingSheet->setSigned($row['ps_signed']);
        $packingSheet->setPrinted($row['ps_printed']);
        $packingSheet->setMemo($row['ps_memo']);
        $packingSheet->setCollect($row['ps_collect']);
        

        if (array_key_exists('group_id', $row)) {
            // Find and set the associated group
            $groupId = $row['group_id'];
            $group = $this->groupDAO->find($groupId);
            $packingSheet->setGroup_id($group);
        }

        if (array_key_exists('consignedCode_id', $row)) {
            // Find and set the associated consignedCode
            $consignedCodeId = $row['consignedCode_id'];
            $consignedCode = $this->consignedCodeDAO->find($consignedCodeId);
            $packingSheet->setConsignedCode_id($consignedCode);
        }

        if (array_key_exists('deliveryCode_id', $row)) {
            // Find and set the associated deliveryCode
            $deliveryCodeId = $row['deliveryCode_id'];
            $deliveryCode = $this->deliveryCodeDAO->find($deliveryCodeId);
            $packingSheet->setDeliveryCode_id($deliveryCode);
        }

        if (array_key_exists('service_id', $row)) {
            // Find and set the associated service
            $serviceId = $row['service_id'];
            $service = $this->serviceDAO->find($serviceId);
            $packingSheet->setService_id($service);
        }

        if (array_key_exists('content_id', $row)) {
            // Find and set the associated content
            $contentId = $row['content_id'];
            $content = $this->contentDAO->find($contentId);
            $packingSheet->setContent_id($content);
        }

        if (array_key_exists('priority_id', $row)) {
            // Find and set the associated priority
            $priorityId = $row['priority_id'];
            $priority = $this->priorityDAO->find($priorityId);
            $packingSheet->setPriority_id($priority);
        }

        if (array_key_exists('shipper_id', $row)) {
            // Find and set the associated shipper
            $shipperId = $row['shipper_id'];
            $shipper = $this->shipperDAO->find($shipperId);
            $packingSheet->setShipper_id($shipper);
        }

        if (array_key_exists('autority_id', $row)) {
            // Find and set the associated autority
            $autorityId = $row['autority_id'];
            $autority = $this->autorityDAO->find($autorityId);
            $packingSheet->setAutority_id($autority);
        }

        if (array_key_exists('customStatus_id', $row)) {
            // Find and set the associated customStatus
            $customStatusId = $row['customStatus_id'];
            $customStatus = $this->customStatusDAO->find($customStatusId);
            $packingSheet->setCustomStatus($customStatus);
        }

        if (array_key_exists('incType_id', $row)) {
            // Find and set the associated incType
            $incotermsTypeId = $row['incType_id'];
            $incotermsType = $this->incotermsTypeDAO->find($incotermsTypeId);
            $packingSheet->setIncType_id($incotermsType);
        }

        if (array_key_exists('incLoc_id', $row)) {
            // Find and set the associated incLoc
            $incotermsLocationId = $row['incLoc_id'];
            $incotermsLocation = $this->incotermsLocationDAO->find($incotermsLocationId);
            $packingSheet->setIncLoc_id($incotermsLocation);
        }

        if (array_key_exists('currency_id', $row)) {
            // Find and set the associated currency
            $currencyId = $row['currency_id'];
            $currency = $this->currencyDAO->find($currencyId);
            $packingSheet->setCurrency_id($currency);
        }

        if (array_key_exists('imput_id', $row)) {
            // Find and set the associated imput
            $imputId = $row['imput_id'];
            $imput = $this->imputDAO->find($imputId);
            $packingSheet->setImput_id($imput);
        }

        return $packingSheet;
    }
}
