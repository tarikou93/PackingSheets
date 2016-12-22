<?php

namespace PackingSheets\Domain;

class PackingSheetChecker
{
	
	public function checkPackingSheetCompletion(PackingSheet $packingSheet) {
		
		$isValid = true; 
		
		if($packingSheet->getConsignedAddressId() === null){
			$isValid = false;
		}

		if($packingSheet->getConsignedContactId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getServiceId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getContentId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getPriorityId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getShipperId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getYROrder() === null){
			$isValid = false;
		}
		
		if($packingSheet->getAWB() === null){
			$isValid = false;
		}
		
		if($packingSheet->getDateIssue() === null){
			$isValid = false;
		}
		
		if($packingSheet->getCustomStatusId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getIncTypeId() === null){
			$isValid = false;
		}
		
		if($packingSheet->getIncLocId() === null){
			$isValid = false;
		}

		if($packingSheet->getCurrencyId() === null){
			$isValid = false;
		}
		
		return $isValid;
	}

}

