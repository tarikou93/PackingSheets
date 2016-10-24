<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Part;

class PartDAO extends DAO
{

    /**
     * Return a list of all Parts, sorted by date (most recent first).
     *
     * @return array A list of all Parts.
     */
    public function findAll() {
        $sql = "select * from t_part order by part_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $parts = array();
        foreach ($result as $row) {
            $partId = $row['part_id'];
            $parts[$partId] = $this->buildDomainObject($row);
        }
        return $parts;
    }

    /**
    * Returns an Part matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Part|throws an exception if no matching Part is found
    */
   public function find($id) {
       $sql = "select * from t_part where part_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Part matching id " . $id);
   }

   /**
    * Returns an article matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Part|throws an exception if no matching Part is found
    */
   public function findByPn($id) {
       $sql = "select * from t_part where part_pn=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Part matching pn " . $id);
   }
   
   /**
     * Return a list of filtered Parts, results of search.
     *
     * @return array A list of resulting Parts.
     */
    public function findBySearch() {
        
        $by_pn = $_POST['pn'];
        $by_sn = $_POST['sn'];
        $by_desc = $_POST['desc'];
        $by_hscode = $_POST['hscode'];
        
        //Do real escaping here

        $query = "SELECT * FROM t_part";
        
        $conditions = array();

        if ($by_pn != "") {
            $conditions[] = "part_pn LIKE '%$by_pn%'";
        }
        if ($by_sn != "") {
            $conditions[] = "part_serial LIKE '%$by_sn%'";
        }
        if ($by_desc != "") {
            $conditions[] = "part_desc LIKE '%$by_desc%'";
        }
        if ($by_hscode != "") {
            $conditions[] = "part_HSCode LIKE '%$by_hscode%'";
        }
        
        
        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $parts = array();
        foreach ($result as $row) {
            $partId = $row['part_id'];
            $parts[$partId] = $this->buildDomainObject($row);
        }
        return $parts;
    }

    /**
     * Creates a Part object based on a DB row.
     *
     * @param array $row The DB row containing Part data.
     * @return \PackingSheets\Domain\Part
     */
    protected function buildDomainObject($row) {
        $part = new Part();
        $part->setId($row['part_id']);
        $part->setPN($row['part_pn']);
        $part->setSerial($row['part_serial']);
        $part->setDesc($row['part_desc']);
        $part->setPrice($row['part_price']);
        $part->setHSCode($row['part_HSCode']);
        return $part;
    }
}
