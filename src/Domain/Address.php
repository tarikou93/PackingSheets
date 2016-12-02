<?php

namespace PackingSheets\Domain;

use JsonSerializable;

class Address implements JsonSerializable
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
    private $codeId;

    /**
     * Address label.
     *
     * @var string
     */
    private $label;
    
    /**
     * Address contacts.
     *
     * @var array(Contact)
     */
    private $contacts;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getCodeId() {
        return $this->codeId;
    }

    public function setCodeId($code_id) {
        $this->codeId = $code_id;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }
    
    public function getContacts() {
    	return $this->contacts;
    }
    
    public function setContacts($contacts) {
    	$this->contacts = $contacts;
    }
    
    public function jsonSerialize()
    {
    	return array(
    			'id' => $this->id,
    			'codeId'=> $this->codeId,
    			'label' => $this->label,
    	);
    }
}


