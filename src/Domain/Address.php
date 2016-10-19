<?php

namespace PackingSheets\Domain;

class Address
{
    /**
     * Address id.
     *
     * @var integer
     */
    private $id;

    /**
     * Address code id.
     *
     * @var integer
     */
    private $code_id;

    /**
     * Address label.
     *
     * @var string
     */
    private $label;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getCode_id() {
        return $this->code_id;
    }

    public function setCode_id($code_id) {
        $this->code_id = $code_id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }
}


