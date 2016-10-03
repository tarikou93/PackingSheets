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
