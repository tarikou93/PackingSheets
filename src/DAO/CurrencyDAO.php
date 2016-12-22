<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Currency;

class CurrencyDAO extends DAO
{

    /**
     * Return a list of all Currencys, sorted by date (most recent first).
     *
     * @return array A list of all Currencys.
     */
    public function findAll() {
        $sql = "select * from t_currency order by curr_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $currencys = array();
        foreach ($result as $row) {
            $currencyId = $row['curr_id'];
            $currencys[$currencyId] = $this->buildDomainObject($row);
        }
        return $currencys;
    }

    /**
    * Returns an Currency matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Currency|throws an exception if no matching Currency is found
    */
   public function find($id) {
       $sql = "select * from t_currency where curr_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Currency matching id " . $id);
   }
   
   /**
    * Saves a currency into the database.
    *
    * @param \PackingSheets\Domain\Currency $currency The currency to save
    */
   public function save(Currency $currency) {
   
   	$currencyData = array(
   			'curr_label' => $currency->getLabel()
   	);
   
   	if ($currency->getId()) {
   		// The currency has already been saved : update it
   		$this->getDb()->update('t_currency', $currencyData, array('curr_id' => $currency->getId()));
   	} else {
   		// The article has never been saved : insert it
   		$this->getDb()->insert('t_currency', $currencyData);
   		// Get the id of the newly created currency and set it on the entity.
   		$id = $this->getDb()->lastInsertId();
   		$currency->setId($id);
   	}
   }
    
   /**
    * Removes a currency from the database.
    *
    * @param integer $id The currency id.
    */
   public function delete($id) {
   	//Delete the currency
   	$this->getDb()->delete('t_currency', array('curr_id' => $id));
   }

    /**
     * Creates a Currency object based on a DB row.
     *
     * @param array $row The DB row containing Currency data.
     * @return \PackingSheets\Domain\Currency
     */
    protected function buildDomainObject($row) {
        $currency = new Currency();
        $currency->setId($row['curr_id']);
        $currency->setLabel($row['curr_label']);
        return $currency;
    }
}
