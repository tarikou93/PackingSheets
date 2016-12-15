<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Code;
use PackingSheets\Domain\ContactSearch;

class CodeDAO extends DAO
{
	
	/**
	 * @var \PackingSheets\DAO\AddressDAO
	 */
	private $addressDAO;
	
	public function setAddressDAO(AddressDAO $addressDAO) {
		$this->addressDAO = $addressDAO;
	}

    /**
     * Return a list of all Codes, sorted by date (most recent first).
     *
     * @return array A list of all Codes.
     */
    public function findAll() {
        $sql = "select * from t_code order by code_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $codes = array();
        foreach ($result as $row) {
            $codeId = $row['code_id'];
            $codes[$codeId] = $this->buildDomainObject($row);
        }
        return $codes;
    }
    
    /**
     * Return a list of all Codes by Id, sorted by date (most recent first).
     *
     * @return array A list of all Codes by Id.
     */
    public function findAllById($id) {
    	$sql = "select * from t_code where code_id=".$id." order by code_id desc";
    	$result = $this->getDb()->fetchAll($sql);
    
    	// Convert query result to an array of domain objects
    	$codes = array();
    	foreach ($result as $row) {
    		$codeId = $row['code_id'];
    		$codes[$codeId] = $this->buildDomainObject($row);
    	}
    	return $codes;
    }

    /**
    * Returns an Code matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Code|throws an exception if no matching Code is found
    */
   public function find($id) {
       $sql = "select * from t_code where code_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Code matching id " . $id);
   }
   
   
   public function findAllArrayResults(){
   		$sql = "select * from t_code order by code_id desc";
   		$result = $this->getDb()->fetchAll($sql);
   		
   		// Convert query result to an array of domain objects
   		$codes = array();
   		foreach ($result as $row) {
   			$codeId = $row['code_id'];
   			$code = new Code();
   			$code->setId($row['code_id']);
   			$code->setLabel($row['code_label']);
   			$codes[$codeId] = $code;
   		}
   		
   		return $codes;
   }
   
   /**
    * Return a list of filtered Contacts, results of search.
    *
    * @return array A list of resulting Contacts.
    */
   public function findBySearch(ContactSearch $contactSearch) {
   	 
   	$by_name = $contactSearch->getName();
   	$by_mail = $contactSearch->getMail();
   	$by_phone = $contactSearch->getPhoneNr();
   	$by_fax = $contactSearch->getFaxNr();
   	//$by_address = (null !== $contactSearch->getAddressId()->getId()) ? $contactSearch->getAddressId()->getId() : "";
   
   
   	//Do real escaping here
   
   	$query = "SELECT *
                FROM t_contact c
                LEFT JOIN t_address ad
                    ON c.contact_addressId = ad.address_id
        		LEFT JOIN t_code code
        			ON ad.address_codeId = code.code_id";
   
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
   	/*if ($by_address != ""){
   		$conditions[] = "contact_addressId LIKE '%$by_address%'";
   	}*/
   
   
   	$sql = $query;
   	if (count($conditions) > 0) {
   		$sql .= " WHERE " . implode(' AND ', $conditions);
   	}
   
   	$result = $this->getDb()->fetchAll($sql);
   	//var_dump($result);exit;
   
   	// Convert query result to an array of domain objects
   	$codes = array();
   	foreach ($result as $row) {
   		if(!array_key_exists($row['code_id'], $codes)){
   			$codeId = $row['code_id'];
   			$codes[$codeId] = $this->find($codeId);
   		}
   	}
   	//var_dump($codes);exit;
   	return $codes;
   }

    /**
     * Creates a Code object based on a DB row.
     *
     * @param array $row The DB row containing Code data.
     * @return \PackingSheets\Domain\Code
     */
    protected function buildDomainObject($row) {
        $code = new Code();
        $code->setId($row['code_id']);
        $code->setLabel($row['code_label']);
        
        //Addresses
        $code->setAddresses($this->addressDAO->findByCode($row['code_id']));
        
        return $code;
    }
}
