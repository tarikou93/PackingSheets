<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\Service;

class ServiceDAO extends DAO
{

    /**
     * Return a list of all Services, sorted by date (most recent first).
     *
     * @return array A list of all Services.
     */
    public function findAll() {
        $sql = "select * from t_service order by serv_id desc";
        $result = $this->getDb()->fetchAll($sql);

        // Convert query result to an array of domain objects
        $services = array();
        foreach ($result as $row) {
            $serviceId = $row['serv_id'];
            $services[$serviceId] = $this->buildDomainObject($row);
        }
        return $services;
    }

    /**
    * Returns an Service matching the supplied id.
    *
    * @param integer $id
    *
    * @return \PackingSheets\Domain\Service|throws an exception if no matching Service is found
    */
   public function find($id) {
       $sql = "select * from t_service where serv_id=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row)
           return $this->buildDomainObject($row);
       else
           throw new \Exception("No Service matching id " . $id);
   }

    /**
     * Creates a Service object based on a DB row.
     *
     * @param array $row The DB row containing Service data.
     * @return \PackingSheets\Domain\Service
     */
    protected function buildDomainObject($row) {
        $service = new Service();
        $service->setId($row['serv_id']);
        $service->setLabel($row['serv_label']);
        return $service;
    }
}
