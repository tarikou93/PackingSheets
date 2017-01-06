<?php

namespace PackingSheets\Domain;

class PackingAssignation
{
    
    /**
     * Packing Assignation parts
     *
     * @var array(PackingListPart)
     */
    private $packingListPart;
    
    /**
     * Packing Assignation packings numbers.
     *
     * @var array(Packings)
     */
    private $packing;
    
    /**
     * Packing Assignation origin.
     *
     * @var string
     */
    private $origin;
    
    /**
     * Packing Assignation price.
     *
     * @var float
     */
    private $price;

    public function getPackingListPart() {
        return $this->packingListPart;
    }

    public function setPackingListPart($plpart) {
        $this->packingListPart = $plpart;
    }

    public function getPacking() {
        return $this->packing;
    }

    public function setPacking($pack) {
        $this->packing = $pack;
    }
    
    public function getOrigin() {
    	return $this->origin;
    }
    
    public function setOrigin($origin) {
    	$this->origin = $origin;
    }
    
    public function getPrice() {
    	return $this->price;
    }
    
    public function setPrice($price) {
    	$this->price = $price;
    }

}

