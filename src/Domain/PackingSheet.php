<?php

namespace PackingSheets\Domain;

class PackingSheet
{
    /**
     * PackingSheet id.
     *
     * @var integer
     */
    private $id;

    /**
     * PackingSheet ref.
     *
     * @var string
     */
    private $ref;

    /**
     * PackingSheet groupId.
     *
     * @var integer
     */
    private $groupId;

    /**
     * PackingSheet consignedAddressId.
     *
     * @var integer
     */
    private $consignedAddressId;

    /**
     * PackingSheet deliveryAddressId.
     *
     * @var integer
     */
    private $deliveryAddressId;
    
    /**
     * PackingSheet consignedContactId.
     *
     * @var integer
     */
    private $consignedContactId;

    /**
     * PackingSheet deliveryContactId.
     *
     * @var integer
     */
    private $deliveryContactId;

    /**
     * PackingSheet serviceId.
     *
     * @var integer
     */
    private $serviceId;

    /**
     * PackingSheet contentId.
     *
     * @var integer
     */
    private $contentId;

    /**
     * PackingSheet priorityId.
     *
     * @var integer
     */
    private $priorityId;

    /**
     * PackingSheet shipperId.
     *
     * @var integer
     */
    private $shipperId;

    /**
     * PackingSheet yrOrder.
     *
     * @var string
     */
    private $yrOrder;

    /**
     * PackingSheet AWB.
     *
     * @var string
     */
    private $AWB;

    /**
     * PackingSheet dateIssue.
     *
     * @var date
     */
    private $dateIssue;

    /**
     * PackingSheet collect.
     *
     * @var booelan
     */
    private $collect;

    /**
     * PackingSheet authority.
     *
     * @var string
     */
    private $autority;

    /**
     * PackingSheet customStatusId.
     *
     * @var integer
     */
    private $customStatusId;

    /**
     * PackingSheet incTypeId.
     *
     * @var integer
     */
    private $incTypeId;

    /**
     * PackingSheet incLocId.
     *
     * @var integer
     */
    private $incLocId;

    /**
     * PackingSheet currencyId.
     *
     * @var integer
     */
    private $currencyId;

    /**
     * PackingSheet inputId.
     *
     * @var integer
     */
    private $imputId;

    /**
     * PackingSheet nbrPieces.
     *
     * @var integer
     */
    private $nbrPieces;

    /**
     * PackingSheet weight.
     *
     * @var float
     */
    private $weight;

    /**
     * PackingSheet totalPrice.
     *
     * @var integer
     */
    private $totalPrice;

    /**
     * PackingSheet signed.
     *
     * @var bit
     */
    private $signed;

    /**
     * PackingSheet printed.
     *
     * @var integer
     */
    private $printed;

    /**
     * PackingSheet memo.
     *
     * @var string
     */
    private $memo;
    
    /**
     * PackingSheet packings array.
     *
     * @var Packing array
     */
    private $packings;
    
    /**
     * PackingSheet packing list.
     *
     * @var Packing List
     */
    private $packingList;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRef() {
        return $this->ref;
    }

    public function setRef($ref) {
        $this->ref = $ref;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    public function getConsignedAddressId() {
        return $this->consignedAddressId;
    }

    public function setConsignedAddressId($consignedAddressId) {
        $this->consignedAddressId = $consignedAddressId;
    }

    public function getDeliveryAddressId() {
        return $this->deliveryAddressId;
    }

    public function setDeliveryAddressId($deliveryAddressId) {
        $this->deliveryAddressId = $deliveryAddressId;
    }
    
    public function getConsignedContactId() {
        return $this->consignedContactId;
    }

    public function setConsignedContactId($consignedContactId) {
        $this->consignedContactId = $consignedContactId;
    }

    public function getDeliveryContactId() {
        return $this->deliveryContactId;
    }

    public function setDeliveryContactId($deliveryContactId) {
        $this->deliveryContactId = $deliveryContactId;
    }

    public function getServiceId() {
        return $this->serviceId;
    }

    public function setServiceId($serviceId) {
        $this->serviceId = $serviceId;
    }

    public function getContentId() {
        return $this->contentId;
    }

    public function setContentId($contentId) {
        $this->contentId = $contentId;
    }

    public function getPriorityId() {
        return $this->priorityId;
    }

    public function setPriorityId($priorityId) {
        $this->priorityId = $priorityId;
    }

    public function getShipperId() {
        return $this->shipperId;
    }

    public function setShipperId($shipperId) {
        $this->shipperId = $shipperId;
    }

    public function getYROrder() {
        return $this->yrOrder;
    }

    public function setYROrder($yrOrder) {
        $this->yrOrder = $yrOrder;
    }

    public function getAWB() {
        return $this->AWB;
    }

    public function setAWB($AWB) {
        $this->AWB = $AWB;
    }

    public function getDateIssue() {
        return $this->dateIssue;
    }

    public function setDateIssue($dateIssue) {
        $this->dateIssue = $dateIssue;
    }

    public function getAutority() {
        return $this->autority;
    }

    public function setAutority($autority) {
        $this->autority = $autority;
    }

    public function getCustomStatusId() {
        return $this->customStatusId;
    }

    public function setCustomStatusId($customStatusId) {
        $this->customStatusId = $customStatusId;
    }

    public function getIncTypeId() {
        return $this->incTypeId;
    }

    public function setIncTypeId($incTypeId) {
        $this->incTypeId = $incTypeId;
    }

    public function getIncLocId() {
        return $this->incLocId;
    }

    public function setIncLocId($incLocId) {
        $this->incLocId = $incLocId;
    }

    public function getCurrencyId() {
        return $this->currencyId;
    }

    public function setCurrencyId($currencyId) {
        $this->currencyId = $currencyId;
    }

    public function getImputId() {
        return $this->imputId;
    }

    public function setImputId($imputId) {
        $this->imputId = $imputId;
    }

    public function getNbrPieces() {
        return $this->nbrPieces;
    }

    public function setNbrPieces($nbrPieces) {
        $this->nbrPieces = $nbrPieces;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getTotalPrice() {
        return $this->totalPrice;
    }

    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    public function getSigned() {
        return $this->signed;
    }

    public function setSigned($signed) {
        $this->signed = $signed;
    }

    public function getPrinted() {
        return $this->printed;
    }

    public function setPrinted($printed) {
        $this->printed = $printed;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function setMemo($memo) {
        $this->memo = $memo;
    }
    
    public function getCollect() {
        return $this->collect;
    }

    public function setCollect($collect) {
        $this->collect = $collect;
    }
    
    public function getPackings() {
    	return $this->packings;
    }
    
    public function setPackings($packings) {
    	$this->packings = $packings;
    }
    
    public function getPackingList() {
    	return $this->packingList;
    }
    
    public function setPackingList($packingList) {
    	$this->packingList = $packingList;
    }
    
    public function addPacking(Packing $packing)
    {
    	if (array_search($packing, $this->packings) == false) {
    		array_push($this->packings, $packing);
    	}
    }
    
    public function removePacking(Packing $packing)
    {
    	if (($key = array_search($packing, $this->packings)) !== false) {
    		unset($this->packings[$key]);
    	}
    }
    
    public function addPackingList(PackingList $packingList)
    {
    	if (array_search($packingList, $this->packingList) == false) {
    		array_push($this->packingList, $packingList);
    	}
    }
    
    public function removePackingList(PackingList $packingList)
    {
    	if (($key = array_search($packingList, $this->packingList)) !== false) {
    		unset($this->packingList[$key]);
    	}
    }
    
}
