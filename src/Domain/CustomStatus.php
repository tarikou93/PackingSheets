<?php

namespace PackingSheets\Domain;

class CustomStatus
{
    /**
     * CustomStatus id.
     *
     * @var integer
     */
    private $id;

    /**
     * CustomStatus label.
     *
     * @var string
     */
    private $label;

    /**
     * CustomStatus text.
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
