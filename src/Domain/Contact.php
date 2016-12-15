<?php

namespace PackingSheets\Domain;

use JsonSerializable;

class Contact implements JsonSerializable
{
    /**
     * Contact id.
     *
     * @var integer
     */
    private $id;

    /**
     * Contact address id.
     *
     * @var integer
     */
    private $addressId;

    /**
     * Contact name.
     *
     * @var string
     */
    private $name;
    
    /**
     * Contact mail.
     *
     * @var string
     */
    private $mail;
    
    /**
     * Contact phone number.
     *
     * @var string
     */
    private $phoneNr;
    
    /**
     * Contact fax.
     *
     * @var string
     */
    private $faxNr;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    
    public function getAddressId() {
        return $this->addressId;
    }

    public function setAddressId($addressId) {
        $this->addressId = $addressId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    
    public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
    }
    
    public function getPhoneNr() {
        return $this->phoneNr;
    }

    public function setPhoneNr($phoneNr) {
        $this->phoneNr = $phoneNr;
    }
    
    public function getFaxNr() {
        return $this->faxNr;
    }

    public function setFaxNr($faxNr) {
        $this->faxNr = $faxNr;
    }
    
    public function getCompleteInfos(){
    	return sprintf('Name : %s | Mail : %s | Phone : %s | Fax : %s', $this->name, $this->mail, $this->phoneNr, $this->faxNr);
    }
    
    public function jsonSerialize()
    {
    	return array(
    			'id' => $this->id,
    			'name'=> $this->name,
    			'mail' => $this->mail,
    			'phoneNr' => $this->phoneNr,
    			'faxNr' => $this->faxNr,
    			'addressId' => $this->addressId
    	);
    }
}

