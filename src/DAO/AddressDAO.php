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
        $sql = "select * from t_address order by address_label";
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
    * @return an array of address Id by label.
    */
   public function findIdByLabel($label) {
   	$sql = "select address_id from t_address where address_label like '%$label%'";
   	$result = $this->getDb()->fetchAll($sql);
   	 
   	$ids = array();
   	foreach($result as $res){
   		array_push($ids, $res['address_id']);
   	}
   	
   	return $ids;
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
    * Saves a address into the database.
    *
    * @param \PackingSheets\Domain\Address $address The address to save, $codeId the Id of the Code object it belongs to
    */
   public function save(Address $address, $codeId) {
   	 
   	$addressData = array(
   			'address_label' => $address->getLabel(),
   			'address_codeId' => $codeId
   	);
   	 
   	if ($address->getId()) {
   		// The address has already been saved : update it
   		$this->getDb()->update('t_address', $addressData, array('address_id' => $address->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_address', $addressData);
   		// Get the id of the newly created address and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$address->setId($id);
   	}
   }
    
   /**
    * Removes a address from the database.
    *
    * @param integer $id The address id.
    */
   public function delete($id) {
   	//Delete the address
   	$this->getDb()->delete('t_address', array('address_id' => $id));
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