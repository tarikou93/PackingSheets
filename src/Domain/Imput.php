<?php

namespace PackingSheets\Domain;

class Imput
{
    /**
     * Imput id.
     *
     * @var integer
     */
    private $id;

    /**
     * Imput label.
     *
     * @var string
     */
    private $label;

    /**
     * Imput text.
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
    
    public function getCompleteInfos(){
    	return sprintf('%s | %s', $this->label, $this->text);
    }

}
