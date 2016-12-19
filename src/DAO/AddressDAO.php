<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Address;

class AddressDAO extends DAO
{

    /**
     * @var \PackingSheets\DAO\ContactDAO
     */
    private $contactDAO;

    public function setContactDAO(ContactDAO $contactDAO) {
        $this->contactDAO = $contactDAO;
    }

    /**
     * Return a list of all Addresses, sorted by date (most recent first).
     *
     * @return array A list of all Addresses.
     */
    public function findAll() {
        $sql = "select * from t_address order by address_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $addresses = array();
        foreach ($result as $row) {
            $addressId = $row['address_id'];
            $addresses[$addressId] = $this->buildDomainObject($row);
        }
        return $addresses;
    }

    /**
    * Returns an Address matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheet\Domain\Address|throws an exception if no matching Address is found
    */
   public function find($id) {
       $sql = "select * from t_address where address_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No PackingSheet matching id " . $id);
   }
   
   
   /**
    * Return the Id of the address by label.
    *
    * @return an address Id by label.
    */
   public function findIdByLabel($label) {
   	$sql = "select address_id from t_address where address_label like '%$label%'";
   	$result = $this->getDb()->fetchAll($sql);
   	 
   	$id = $result[0]['address_id'];
   	return $id;
   }
   
   /**
    * Returns an Address matching the supplied code.
    *
    * @param integer $code
    *
    * @return \PackingSheet\Domain\Address|throws an exception if no matching Address is found
    */
   public function findByCode($code) {
       
        $sql = "select * from t_address where address_codeId=".$code;
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $addresses = array();
        foreach ($result as $row) {
            $addressId = $row['address_id'];
            $addresses[$addressId] = $this->buildDomainObject($row);
        }
        return $addresses;
   }

    /**
     * Creates a Address object based on a DB row.
     *
     * @param array $row The DB row containing Address data.
     * @return \PackingSheets\Domain\Address
     */
    protected function buildDomainObject($row) {
        $address = new Address();
        $address->setId($row['address_id']);
        $address->setLabel($row['address_label']);
        $address->setCodeId($row['address_codeId']);
        
        //Contacts
        $address->setContacts($this->contactDAO->findByAddress($row['address_id']));

        return $address;
    }
}