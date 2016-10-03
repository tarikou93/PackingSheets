<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Packing;

class PackingDAO extends DAO
{

    /**
     * @var \PackingSheets\DAO\PackingSheetDAO
     */
    private $packingSheetDAO;

    public function setPackingSheetDAO(PackingSheetDAO $packingSheetDAO) {
        $this->packingSheetDAO = $packingSheetDAO;
    }

    /**
     * @var \PackingSheets\DAO\PackTypeDAO
     */
    private $packTypeDAO;

    public function setPackTypeDAO(PackTypeDAO $packTypeDAO) {
        $this->packTypeDAO = $packTypeDAO;
    }

    /**
     * Return a list of all Packings, sorted by date (most recent first).
     *
     * @return array A list of all Packings.
     */
    public function findAll() {
        $sql = "select * from t_packing order by pack_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $packings = array();
        foreach ($result as $row) {
            $packingId = $row['pack_id'];
            $packings[$packingId] = $this->buildDomainObject($row);
        }
        return $packings;
    }

    /**
    * Returns an Packing matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Packing|throws an exception if no matching Packing is found
    */
   public function find($id) {
       $sql = "select * from t_packing where pack_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Packing matching id " . $id);
   }

   /**
     * Return a list of all packings for a packingSheet.
     *
     * @param integer $packingSheetId The packingSheet id.
     *
     * @return array A list of all packings for the packingSheet.
     */
    public function findAllByPackingSheet($packingSheetId) {
        // The associated packingSheet is retrieved only once
        $packingSheet = $this->packingSheetDAO->find($packingSheetId);

        // ps_id is not selected by the SQL query
        // The packingSheet won't be retrieved during domain objet construction
        $sql = "select pack_id, pack_netWeight, pack_grossWeight, pack_M1, pack_M2, pack_M3, packType_id from t_packing where ps_id=? order by pack_id";
        $result = $this->getDb()->fetchAll($sql, array($packingSheetId));

        // Convert query result to an array of domain objects
        $packings = array();
        foreach ($result as $row) {
            $packId = $row['pack_id'];
            $packing = $this->buildDomainObject($row);
            // The associated packingSheet is defined for the constructed packing
            $packing->setPSid($packingSheet);
            $packings[$packId] = $packing;
        }
        return $packings;
    }

    /**
     * Creates a Packing object based on a DB row.
     *
     * @param array $row The DB row containing Packing data.
     * @return \PackingSheets\Domain\Packing
     */
    protected function buildDomainObject($row) {
        $packing = new Packing();
        $packing->setId($row['pack_id']);
        $packing->setNetWeight($row['pack_netWeight']);
        $packing->setGrossWeight($row['pack_grossWeight']);
        $packing->setM1($row['pack_M1']);
        $packing->setM2($row['pack_M2']);
        $packing->setM3($row['pack_M3']);

        if (array_key_exists('ps_id', $row)) {
            // Find and set the associated packingSheet
            $packingSheetId = $row['ps_id'];
            $packingSheet = $this->packingSheetDAO->find($packingSheetId);
            $packing->setPSid($packingSheet);
        }

        if (array_key_exists('packType_id', $row)) {
            // Find and set the associated packingSheet
            $packTypeId = $row['packType_id'];
            $packType = $this->packTypeDAO->find($packTypeId);
            $packing->setPackTypeid($packType);
        }

        return $packing;
    }
}
