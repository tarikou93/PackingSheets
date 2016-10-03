<?php

namespace PackingSheets\Domain;

class Autority
{
    /**
     * Autority id.
     *
     * @var integer
     */
    private $id;

    /**
     * Autority label.
     *
     * @var string
     */
    private $label;

    /**
     * Autority text.
     *
     * @var string
     */
    private $text;

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

    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

}
