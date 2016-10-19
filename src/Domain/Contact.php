<?php

namespace PackingSheets\Domain;

class Contact
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
    private $address_id;

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
    
    public function getAddress_id() {
        return $this->address_id;
    }

    public function setAddress_id($address_id) {
        $this->address_id = $address_id;
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
}

