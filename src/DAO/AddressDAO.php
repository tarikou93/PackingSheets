<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Address;

class AddressDAO extends DAO
{

    /**
     * @var \PackingSheets\DAO\CodeDAO
     */
    private $addressCodeDAO;

    public function setAddressCodeDAO(CodeDAO $codeDAO) {
        $this->addressCodeDAO = $codeDAO;
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
    * Returns an Address matching the supplied code.
    *
    * @param integer $code
    *
    * @return \PackingSheet\Domain\Address|throws an exception if no matching Address is found
    */
   public function findByCode($code) {
       
       $sql = "select * from t_address where address_codeId=?";
       $row = $this->getDb()->fetchAssoc($sql, array($code));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No PackingSheet matching id " . $id);
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
        
        if (array_key_exists('address_codeId', $row)) {
            // Find and set the associated code
            $addressCodeId = $row['address_codeId'];
            $addressCode = $this->addressCodeDAO->find($addressCodeId);
            $address->setCode_id($addressCode);
        }

        return $address;
    }
}