<?php

namespace PackingSheets\Domain;

class Content
{
    /**
     * Content id.
     *
     * @var integer
     */
    private $id;

    /**
     * Content label.
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
