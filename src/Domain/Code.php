<?php

namespace PackingSheets\Domain;

class Code
{
    /**
     * Code id.
     *
     * @var integer
     */
    private $id;

    /**
     * Code label.
     *
     * @var string
     */
    private $label;
    
    /**
     * Code addresses.
     *
     * @var array(Address)
     */
    private $addresses;

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
    
    public function getAddresses() {
    	return $this->addresses;
    }
    
    public function setAddresses($addresses) {
    	$this->addresses = $addresses;
    }

}
