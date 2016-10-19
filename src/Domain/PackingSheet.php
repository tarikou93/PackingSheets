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
     * PackingSheet group_id.
     *
     * @var integer
     */
    private $group_id;

    /**
     * PackingSheet consignedAddress_id.
     *
     * @var integer
     */
    private $consignedAddress_id;

    /**
     * PackingSheet deliveryAddress_id.
     *
     * @var integer
     */
    private $deliveryAddress_id;
    
    /**
     * PackingSheet consignedContact_id.
     *
     * @var integer
     */
    private $consignedContact_id;

    /**
     * PackingSheet deliveryContact_id.
     *
     * @var integer
     */
    private $deliveryContact_id;

    /**
     * PackingSheet service_id.
     *
     * @var integer
     */
    private $service_id;

    /**
     * PackingSheet content_id.
     *
     * @var integer
     */
    private $content_id;

    /**
     * PackingSheet priority_id.
     *
     * @var integer
     */
    private $priority_id;

    /**
     * PackingSheet shipper_id.
     *
     * @var integer
     */
    private $shipper_id;

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
     * PackingSheet authority_id.
     *
     * @var integer
     */
    private $autority_id;

    /**
     * PackingSheet customStatus_id.
     *
     * @var integer
     */
    private $customStatus_id;

    /**
     * PackingSheet incType_id.
     *
     * @var integer
     */
    private $incType_id;

    /**
     * PackingSheet incLoc_id.
     *
     * @var integer
     */
    private $incLoc_id;

    /**
     * PackingSheet currency_id.
     *
     * @var integer
     */
    private $currency_id;

    /**
     * PackingSheet input_id.
     *
     * @var integer
     */
    private $imput_id;

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

    public function getGroup_id() {
        return $this->group_id;
    }

    public function setGroup_id($group_id) {
        $this->group_id = $group_id;
    }

    public function getConsignedAddress_id() {
        return $this->consignedAddress_id;
    }

    public function setConsignedAddress_id($consignedAddress_id) {
        $this->consignedAddress_id = $consignedAddress_id;
    }

    public function getDeliveryAddress_id() {
        return $this->deliveryAddress_id;
    }

    public function setDeliveryAddress_id($deliveryAddress_id) {
        $this->deliveryAddress_id = $deliveryAddress_id;
    }
    
    public function getConsignedContact_id() {
        return $this->consignedContact_id;
    }

    public function setConsignedContact_id($consignedContact_id) {
        $this->consignedContact_id = $consignedContact_id;
    }

    public function getDeliveryContact_id() {
        return $this->deliveryContact_id;
    }

    public function setDeliveryContact_id($deliveryContact_id) {
        $this->deliveryContact_id = $deliveryContact_id;
    }

    public function getService_id() {
        return $this->service_id;
    }

    public function setService_id($service_id) {
        $this->service_id = $service_id;
    }

    public function getContent_id() {
        return $this->content_id;
    }

    public function setContent_id($content_id) {
        $this->content_id = $content_id;
    }

    public function getPriority_id() {
        return $this->priority_id;
    }

    public function setPriority_id($priority_id) {
        $this->priority_id = $priority_id;
    }

    public function getShipper_id() {
        return $this->shipper_id;
    }

    public function setShipper_id($shipper_id) {
        $this->shipper_id = $shipper_id;
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

    public function getAutority_id() {
        return $this->autority_id;
    }

    public function setAutority_id($autority_id) {
        $this->autority_id = $autority_id;
    }

    public function getCustomStatus_id() {
        return $this->customStatus_id;
    }

    public function setCustomStatus($customStatus_id) {
        $this->customStatus_id = $customStatus_id;
    }

    public function getIncType_id() {
        return $this->incType_id;
    }

    public function setIncType_id($incType_id) {
        $this->incType_id = $incType_id;
    }

    public function getIncLoc_id() {
        return $this->incLoc_id;
    }

    public function setIncLoc_id($incLoc_id) {
        $this->incLoc_id = $incLoc_id;
    }

    public function getCurrency_id() {
        return $this->currency_id;
    }

    public function setCurrency_id($currency_id) {
        $this->currency_id = $currency_id;
    }

    public function getImput_id() {
        return $this->imput_id;
    }

    public function setImput_id($imput_id) {
        $this->imput_id = $imput_id;
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
}
