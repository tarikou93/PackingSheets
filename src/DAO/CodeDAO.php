<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Code;

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
