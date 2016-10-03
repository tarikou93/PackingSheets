<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Imput;

class ImputDAO extends DAO
{

    /**
     * Return a list of all Imputs, sorted by date (most recent first).
     *
     * @return array A list of all Imputs.
     */
    public function findAll() {
        $sql = "select * from t_imput order by imp_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $imputs = array();
        foreach ($result as $row) {
            $imputId = $row['imp_id'];
            $imputs[$imputId] = $this->buildDomainObject($row);
        }
        return $imputs;
    }

    /**
    * Returns an Imput matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Imput|throws an exception if no matching Imput is found
    */
   public function find($id) {
       $sql = "select * from t_imput where imp_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Imput matching id " . $id);
   }

    /**
     * Creates a Imput object based on a DB row.
     *
     * @param array $row The DB row containing Imput data.
     * @return \PackingSheets\Domain\Imput
     */
    protected function buildDomainObject($row) {
        $imput = new Imput();
        $imput->setId($row['imp_id']);
        $imput->setLabel($row['imp_label']);
        $imput->setText($row['imp_text']);
        return $imput;
    }
}
