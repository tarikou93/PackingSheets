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
     * Return a list of filtered Contacts, results of search.
     *
     * @return array A list of resulting Contacts.
     */
    public function findBySearch() {
        $by_name = $_POST['name'];
        $by_mail = $_POST['mail'];
        $by_phone = $_POST['phone'];
        $by_fax = $_POST['fax'];
        $by_address = isset($_POST['address']) ? $_POST['address'] : "";

      
        //Do real escaping here

        $query = "SELECT c.*
                FROM t_contact c
                INNER JOIN t_address ad
                    ON c.contact_addressId = ad.address_id";
        
        $conditions = array();

        if ($by_name != "") {
            $conditions[] = "contact_name LIKE '%$by_name%'";
        }
        if ($by_mail != "") {
            $conditions[] = "contact_mail LIKE '%$by_mail%'";
        }
        if ($by_phone != "") {
            $conditions[] = "contact_phoneNr LIKE '%$by_phone%'";
        }
        if ($by_fax != "") {
            $conditions[] = "contact_fax LIKE '%$by_fax%'";
        }
        if ($by_address != ""){
            $conditions[] = "contact_addressId LIKE '%$by_address%'";
        }
        
                
        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

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
     * Saves a part into the database.
     *
     * @param \PackingSheets\Domain\Contact $contact The contact to save
     */
    public function save(Contact $contact) {
        $contactData = array(
            'contact_addressId' => $contact->getAddressId()->getId(),
            'contact_name' => $contact->getName(),
            'contact_mail' => $contact->getMail(),
            'contact_phoneNr' => $contact->getPhoneNr(),
            'contact_fax' => $contact->getFaxNr(),
            );

        if ($contact->getId()) {
            // The contact has already been saved : update it
            $this->getDb()->update('t_contact', $contactData, array('contact_id' => $contact->getId()));
        } else {
            // The contact has never been saved : insert it
            $this->getDb()->insert('t_contact', $contactData);
            // Get the id of the newly created part and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $contact->setId($id);
        }
    }
            
     /**
     * Removes a contact from the database.
     *
     * @param integer $id The contact id.
     */
    public function delete($id) {
        //Delete the contact
        $this->getDb()->delete('t_contact', array('contact_id' => $id));
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
            $contact->setAddressId($address);
        }
        
        return $contact;
    }
}


