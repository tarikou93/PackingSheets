<?php

namespace PackingSheets\Domain;

class IncotermsType
{
    /**
     * IncotermsType id.
     *
     * @var integer
     */
    private $id;

    /**
     * IncotermsType label.
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

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }

}
