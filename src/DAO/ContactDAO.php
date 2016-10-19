<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Contact;

class ContactDAO extends DAO
{

    /**
     * @var \PackingSheets\DAO\AddressDAO
     */
    private $addressDAO;

    public function setAddressDAO(AddressDAO $addressDAO) {
        $this->addressDAO = $addressDAO;
    }
    
    /**
     * Return a list of all Contacts, sorted by date (most recent first).
     *
     * @return array A list of all Contacts.
     */
    public function findAll() {
        $sql = "select * from t_contact order by contact_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $contacts = array();
        foreach ($result as $row) {
            $contactId = $row['contact_id'];
            $contacts[$contactId] = $this->buildDomainObject($row);
        }
        return $contacts;
    }

    /**
    * Returns an Contact matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Contact|throws an exception if no matching Contact is found
    */
   public function find($id) {
       $sql = "select * from t_contact where contact_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Content matching id " . $id);
   }

    /**
     * Creates a Contact object based on a DB row.
     *
     * @param array $row The DB row containing Contact data.
     * @return \PackingSheets\Domain\Contact
     */
    protected function buildDomainObject($row) {
        $contact = new Contact();
        $contact->setId($row['contact_id']);
        $contact->setName($row['contact_name']);
        $contact->setMail($row['contact_mail']);
        $contact->setPhoneNr($row['contact_phoneNr']);
        $contact->setFaxNr($row['contact_fax']);
        
        if (array_key_exists('contact_addressId', $row)) {
            // Find and set the associated address
            $addressId = $row['contact_addressId'];
            $address = $this->addressDAO->find($addressId);
            $contact->setAddress_id($address);
        }
        
        return $contact;
    }
}


