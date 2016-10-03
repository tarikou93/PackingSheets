<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Autority;

class AutorityDAO extends DAO
{

    /**
     * Return a list of all Autoritys, sorted by date (most recent first).
     *
     * @return array A list of all Autoritys.
     */
    public function findAll() {
        $sql = "select * from t_autority order by aut_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $autoritys = array();
        foreach ($result as $row) {
            $autorityId = $row['aut_id'];
            $autoritys[$autorityId] = $this->buildDomainObject($row);
        }
        return $autoritys;
    }

    /**
    * Returns an Autority matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Autority|throws an exception if no matching Autority is found
    */
   public function find($id) {
       $sql = "select * from t_autority where aut_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Autority matching id " . $id);
   }

    /**
     * Creates a Autority object based on a DB row.
     *
     * @param array $row The DB row containing Autority data.
     * @return \PackingSheets\Domain\Autority
     */
    protected function buildDomainObject($row) {
        $autority = new Autority();
        $autority->setId($row['aut_id']);
        $autority->setLabel($row['aut_label']);
        $autority->setText($row['aut_telNumber']);
        return $autority;
    }
}
