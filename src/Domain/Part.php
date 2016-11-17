<?php

namespace PackingSheets\Domain;

class Part
{
    /**
     * Part id.
     *
     * @var integer
     */
    private $id;

    /**
     * Part number.
     *
     * @var string
     */
    private $pn;

    /**
     * Part serial.
     *
     * @var string
     */
    private $serial;

    /**
     * Part description.
     *
     * @var string
     */
    private $desc;

    /**
     * Part price.
     *
     * @var float
     */
    private $price;

    /**
     * Part HSCode.
     *
     * @var string
     */
    private $hscode;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPN() {
        return $this->pn;
    }

    public function setPN($pn) {
        $this->pn = $pn;
    }

    public function getSerial() {
        return $this->serial;
    }

    public function setSerial($serial) {
        $this->serial = $serial;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getHSCode() {
        return $this->hscode;
    }

    public function setHSCode($hscode) {
        $this->hscode = $hscode;
    }
    
    public function getCompleteInfos(){
    	return sprintf('Pn : %s | Sn : %s | Desc : %s | Price : %s | HScode : %s', $this->pn, $this->serial, $this->desc, $this->price, $this->hscode);
    }
}
