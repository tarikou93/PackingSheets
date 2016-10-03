<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingPart;

class PackingPartDAO extends DAO
{

    /**
     * @var \PackingPartSheets\DAO\PackingDAO
     */
    private $packingDAO;

    public function setPackingDAO(PackingDAO $packingDAO) {
        $this->packingDAO = $packingDAO;
    }

    /**
     * @var \PackingPartSheets\DAO\PartDAO
     */
    private $partDAO;

    public function setPartDAO(PartDAO $partDAO) {
        $this->partDAO = $partDAO;
    }

    /**
     * Return a list of all PackingParts, sorted by date (most recent first).
     *
     * @return array A list of all PackingParts.
     */
    public function findAll() {
        $sql = "select * from t_packing_part order by pkp_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $packingParts = array();
        foreach ($result as $row) {
            $packingPartId = $row['pkp_id'];
            $packingParts[$packingPartId] = $this->buildDomainObject($row);
        }
        return $packingParts;
    }

    /**
    * Returns an PackingPart matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingPartSheets\Domain\PackingPart|throws an exception if no matching PackingPart is found
    */
   public function find($id) {
       $sql = "select * from t_packing_part where pkp_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No PackingPart matching id " . $id);
   }

   /**
     * Return a list of all packingparts for a packing.
     *
     * @param integer $packingId The packing id.
     *
     * @return array A list of all packingParts for the packing.
     */
    public function findAllByPacking($packingId) {
        // The associated packing is retrieved only once
        $packing = $this->packingDAO->find($packingId);

        // pack_id is not selected by the SQL query
        // The packing won't be retrieved during domain objet construction
        $sql = "select pkp_id, part_id, pkp_quantity, pkp_origin from t_packing_part where pack_id=? order by pkp_id";
        $result = $this->getDb()->fetchAll($sql, array($packingId));

        // Convert query result to an array of domain objects
        $packingParts = array();
        foreach ($result as $row) {
            $packingPartId = $row['pkp_id'];
            $packingPart = $this->buildDomainObject($row);
            // The associated packing is defined for the constructed packing
            $packingPart->setPackid($packing);
            $packingParts[$packingPartId] = $packingPart;
        }
        return $packingParts;
    }

    /**
      * Return a list of all packingParts for a part.
      *
      * @param integer $partId The part id.
      *
      * @return array A list of all packingParts for the part.
      */
     public function findAllByPart($partId) {
         // The associated part is retrieved only once
         $part = $this->partDAO->find($partId);

         // part_id is not selected by the SQL query
         // The part won't be retrieved during domain objet construction
         $sql = "select pkp_id, pack_id, pkp_quantity, pkp_origin from t_packing_part where part_id=? order by pkp_id";
         $result = $this->getDb()->fetchAll($sql, array($partId));

         // Convert query result to an array of domain objects
         $packingParts = array();
         foreach ($result as $row) {
             $packingPartId = $row['pkp_id'];
             $packingPart = $this->buildDomainObject($row);
             // The associated part is defined for the constructed packing
             $packingPart->setPartid($part);
             $packingParts[$packingPartId] = $packingPart;
         }
         return $packingParts;
     }

    /**
     * Creates a PackingPart object based on a DB row.
     *
     * @param array $row The DB row containing PackingPart data.
     * @return \PackingPartSheets\Domain\PackingPart
     */
    protected function buildDomainObject($row) {
        $packingPart = new PackingPart();
        $packingPart->setId($row['pkp_id']);
        $packingPart->setQuantity($row['pkp_quantity']);
        $packingPart->setOrigin($row['pkp_origin']);

        if (array_key_exists('pack_id', $row)) {
            // Find and set the associated packingSheet
            $packingId = $row['pack_id'];
            $packing = $this->packingDAO->find($packingId);
            $packingPart->setPackid($packing);
        }

        if (array_key_exists('part_id', $row)) {
            // Find and set the associated packingSheet
            $partId = $row['part_id'];
            $part = $this->partDAO->find($partId);
            $packingPart->setPartid($part);
        }

        return $packingPart;
    }
}
