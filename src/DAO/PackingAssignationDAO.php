<?php

namespace PackingSheets\DAO;

use PackingSheets\Domain\PackingAssignation;
use PackingSheets\Domain\PackingPart;

class PackingAssignationDAO extends DAO
{

	/**
	 * @var \PackingSheets\DAO\PackingListPartDAO
	 */
	private $packingListPartDAO;

	public function setPackingListPartDAO(PackingListPartDAO $packingListPartDAO) {
		$this->packingListPartDAO = $packingListPartDAO;
	}
	
	/**
	 * @var \PackingSheets\DAO\PackingDAO
	 */
	private $packingPartDAO;
	
	public function setPackingPartDAO(PackingPartDAO $packingPartDAO) {
		$this->packingPartDAO = $packingPartDAO;
	}
	

	public function assignPacking(PackingAssignation $pa){
		
		$packingPart = new PackingPart();
		$packingPart->setOrigin($pa->getOrigin());
		$packingPart->setPackid($pa->getPacking()->getId());
		$packingPart->setPartid($pa->getPackingListPart()->getPartid());
		$packingPart->setQuantity($pa->getPackingListPart()->getQuantity());
		$packingPart->setPrice($pa->getPrice());
		$packingPart->setSerial($pa->getSerial());
		
		$this->packingPartDAO->save($packingPart);

		$this->packingListPartDAO->delete($pa->getPackingListPart()->getId());
	}
	
	/**
	 * Creates a Packing Assignation object based on a DB row.
	 *
	 * @param array $row The DB row containing PA data.
	 * @return \PackingSheets\Domain\Packing Assignation
	 */
	protected function buildDomainObject($row) {
		$packingAssignation = new PackingAssignation();
		return $packingAssignation;
	}

}

