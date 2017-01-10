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
     * Part description.
     *
     * @var string
     */
    private $desc;

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

    public function getDesc() {
        return $this->desc;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function getHSCode() {
        return $this->hscode;
    }

    public function setHSCode($hscode) {
        $this->hscode = $hscode;
    }
    
    public function getCompleteInfos(){
    	return sprintf('Pn : %s | Desc : %s | HScode : %s', $this->pn, $this->desc, $this->hscode);
    }
}
