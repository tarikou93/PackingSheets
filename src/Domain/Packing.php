<?php

namespace PackingSheets\Domain;

class Packing
{
    /**
     * Packing id.
     *
     * @var integer
     */
    private $id;

    /**
     * Associated PackingSheet id.
     *
     * @var integer
     */
    private $ps_id;

    /**
     * Packing net Weight.
     *
     * @var float
     */
    private $netWeight;

    /**
     * Packing gross Weight.
     *
     * @var float
     */
    private $grossWeight;

    /**
     * Packing first dimension.
     *
     * @var float
     */
    private $M1;

    /**
     * Packing second dimension.
     *
     * @var float
     */
    private $M2;

    /**
     * Packing third dimension.
     *
     * @var float
     */
    private $M3;

    /**
     * Associated Packing Type id.
     *
     * @var integer
     */
    private $packType_id;
    
    /**
     * Associated Packing image.
     *
     * @var integer
     */
    private $img;
    
    /**
     * Associated PackingParts array.
     *
     * @var integer
     */
    private $parts;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPSid() {
        return $this->ps_id;
    }

    public function setPSid($psid) {
        $this->ps_id = $psid;
    }

    public function getNetWeight() {
        return $this->netWeight;
    }

    public function setNetWeight($nw) {
        $this->netWeight = $nw;
    }

    public function getGrossWeight() {
        return $this->grossWeight;
    }

    public function setGrossWeight($gw) {
        $this->grossWeight = $gw;
    }

    public function getM1() {
        return $this->M1;
    }

    public function setM1($m1) {
        $this->M1 = $m1;
    }

    public function getM2() {
        return $this->M2;
    }

    public function setM2($m2) {
        $this->M2 = $m2;
    }

    public function getM3() {
        return $this->M3;
    }

    public function setM3($m3) {
        $this->M3 = $m3;
    }

    public function getPackTypeid() {
        return $this->packType_id;
    }

    public function setPackTypeid($packType_id) {
        $this->packType_id = $packType_id;
    }
    
    public function getImg() {
        return $this->img;
    }

    public function setImg($img) {
        $this->img = $img;
    }
    
    public function getParts() {
    	return $this->parts;
    }
    
    public function setParts($parts) {
    	$this->parts = $parts;
    }
    
    public function addPart(PackingPart $pkPart)
    {
    	if($this->parts === null){
    		$this->setParts(array());
    	}
    	
    	if (array_search($pkPart, $this->parts) == false) {
    		array_push($this->parts, $pkPart);
    	}
    }
    
    public function removePart(PackingPart $pkPart)
    {
    	if (($key = array_search($pkPart, $this->parts)) !== false) {
    		unset($this->parts[$key]);
    	}
    }
}
