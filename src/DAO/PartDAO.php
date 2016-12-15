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
    * Returns a Part matching the supplied id.
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
    * Returns a Part matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Part|throws an exception if no matching Part is found
    */
   public function findByPn($pn) {
       $sql = "select * from t_part where part_pn=?";
       $row = $this->getDb()->fetchAssoc($sql, array($pn));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Part matching pn " . $pn);
   }
   
   /**
     * Return a list of filtered Parts, results of search.
     *
     * @return array A list of resulting Parts.
     */
    public function findBySearch(Part $searchPart) {
        
        $by_pn = $searchPart->getPN();
        $by_sn = $searchPart->getSerial();
        $by_desc = $searchPart->getDesc();
        $by_hscode = $searchPart->getHSCode();
        $by_price = $searchPart->getPrice();
        
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
        if ($by_price != "") {
        	$conditions[] = "part_price LIKE '%$by_price%'";
        }
        
        
        $sql = $query;
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        //print_r($sql);exit;
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
     * Saves a part into the database.
     *
     * @param \PackingSheets\Domain\Part $part The part to save
     */
    public function save(Part $part) {
        $partData = array(
            'part_pn' => $part->getPN(),
            'part_serial' => $part->getSerial(),
            'part_desc' => $part->getDesc(),
            'part_price' => $part->getPrice(),
            'part_HSCode' => $part->getHSCode(),
            );

        if ($part->getId()) {
            // The part has already been saved : update it
            $this->getDb()->update('t_part', $partData, array('part_id' => $part->getId()));
        } else {
            // The article has never been saved : insert it
            $this->getDb()->insert('t_part', $partData);
            // Get the id of the newly created part and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $part->setId($id);
        }
    }
            
     /**
     * Removes a part from the database.
     *
     * @param integer $id The part id.
     */
    public function delete($id) {
        //Delete the part
        $this->getDb()->delete('t_part', array('part_id' => $id));
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
