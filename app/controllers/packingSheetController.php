<?php

use PackingSheets\Form\Type\PackingSheetType;
use PackingSheets\Form\Type\PackingSheetSearchType;
use PackingSheets\Domain\PackingSheet;
use PackingSheets\Domain\PackingSheetSearch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


// Sheets list page
$app->match('/sheets', function(Request $request) use ($app) {
	
	$groups = $app['session']->get('auth')['packingSheetsSeries'];
	$codes = $app['dao.code']->findAll();
	$services = $app['dao.service']->findAll();
	$imputs = $app['dao.imput']->findAll();
	
	$psSearch = new PackingSheetSearch();
	$psSearchForm = $app['form.factory']->create(PackingSheetSearchType::class, $psSearch, array('codes' => $codes, 'services' => $services, 'imputs' => $imputs,'availableGroups' => $groups));

	
	$psSearchForm->handleRequest($request);
	
	if ($psSearchForm->isSubmitted() && $psSearchForm->isValid()) {
					
		($psSearchForm->getData()->getDatalistCode() !== null) ? 
			$psSearchForm->getData()->setDatalistCode($app['dao.code']->findIdByLabel($psSearchForm->getData()->getDatalistCode())) : $psSearchForm->getData()->setDatalistCode("");
		
		($psSearchForm->getData()->getDatalistAddress() !== null) ?
			$psSearchForm->getData()->setDatalistAddress($app['dao.address']->findIdByLabel($psSearchForm->getData()->getDatalistAddress())) : $psSearchForm->getData()->setDatalistAddress("");
		
		($psSearchForm->getData()->getDatalistContact() !== null) ?
			$psSearchForm->getData()->setDatalistContact($app['dao.contact']->findIdByLabel($psSearchForm->getData()->getDatalistContact())) : $psSearchForm->getData()->setDatalistContact("");
		
		//var_dump($psSearchForm->getData());exit;
	
		$searchedSheets = $app['dao.packingSheet']->findBySearch($psSearch);
		
		return $app['twig']->render('sheets.html.twig', array(
				'title' => 'Sheets',
				'sheets' => $searchedSheets,
				'searchTag' => 1,
				'codes' => $codes,
				'psSearchForm' => $psSearchForm->createView()));
	}			
	
	return $app['twig']->render('sheets.html.twig', array(
			'title' => 'Sheets',
			'sheets' => $app['dao.packingSheet']->findAllByUserSeries($app['session']->get('auth')['packingSheetsSeries']),
			'searchTag' => 0,
			'codes' => $codes,
			'psSearchForm' => $psSearchForm->createView()));

})->bind('sheets');


//Packing Sheet General
$app->match('/sheet/{id}/{status}', function(Request $request, $id, $status) use ($app) {

	//Statuses list : "create" - Creation,  "details" - Consultation, "edit" - Edition

	if($status === "create"){
		$packingSheet = new PackingSheet();
		$read_only = false;
	}
	else{
		$packingSheet = $app['dao.packingSheet']->find($id);
		$read_only = ($status === "details") ? true : false;

		if($packingSheet->getConsignedAddressId() !== null){
			$consignedOldCode = $app['dao.code']->find($packingSheet->getConsignedAddressId()->getCodeId());
		}
		else{
			$consignedOldCode = null;
		}
		
		if($packingSheet->getDeliveryAddressId() !== null){
			$deliveryOldCode = $app['dao.code']->find($packingSheet->getDeliveryAddressId()->getCodeId());		
		}
		else{
			$deliveryOldCode = null;
		}
	}
	

	$parts = $app['dao.part']->findAll();
	//$codes = $app['dao.code']->findAll();
	$codes = $app['dao.code']->findAllArrayResults();
	$packTypes = $app['dao.packType']->findAll();

	$consignedAddresses = $app['dao.address']->findAll();
	$deliveryAddresses = $app['dao.address']->findAll();

	$contacts = $app['dao.contact']->findAll();
	$services = $app['dao.service']->findAll();
	$contents = $app['dao.content']->findAll();
	$priorities = $app['dao.priority']->findAll();
	$shippers = $app['dao.shipper']->findAll();
	$customStatuses = $app['dao.customStatus']->findAll();
	$incTypes = $app['dao.incotermsType']->findAll();
	$incLocs = $app['dao.incotermsLocation']->findAll();
	$currencies = $app['dao.currency']->findAll();
	$imputs = $app['dao.imput']->findAll();

	$address = $app['dao.address'];
	//var_dump($app['session']->get('user')['username']);exit;
	$availableGroups = $app['session']->get('auth')['packingSheetsSeries'];

	$images = array();
	
	if($status !== 'create'){
		$packings = $packingSheet->getPackings();
		
		if($packings !== null){
			foreach($packings as $pack){
				$images[$pack->getId()] = $pack->getImg();
			}
		}
	}
	
	$packingSheetForm = $app['form.factory']->create(PackingSheetType::class, $packingSheet, array(
			'parts' => $parts, 'packTypes' => $packTypes, 'read_only' => $read_only, 'status' => $status, 'codes' => $codes, 'address' => $address, 'availableGroups' => $availableGroups,
			'consignedAddresses' => $consignedAddresses, 'deliveryAddresses' => $deliveryAddresses,'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs, 'images' => $images,
			'consignedOldCode' => isset($consignedOldCode) ? $consignedOldCode : null,
			'deliveryOldCode' => isset($deliveryOldCode) ? $deliveryOldCode : null
	));
	
	if($request->isMethod('POST')){
		if($request->isXmlHttpRequest()){
			switch ($request->get('flag')){
				case "packing_sheet_consignedCode" :
					$idConsignedCode = $request->get('packing_sheet_consignedCode');
					$consignedAddresses = $app['dao.address']->findByCode($idConsignedCode);
					return new JsonResponse(array('packing_sheet_consignedAddressId' => $consignedAddresses));
					break;
						
				case "packing_sheet_deliveryCode" :
					$idDeliveryCode = $request->get('packing_sheet_deliveryCode');
					$deliveryAddresses = $app['dao.address']->findByCode($idDeliveryCode);
					return new JsonResponse(array('packing_sheet_deliveryAddressId' => $deliveryAddresses));
					break;
						
				case "packing_sheet_consignedAddressId" :
					$idConsignedAddress = $request->get('packing_sheet_consignedAddressId');
					$consignedContacts = $app['dao.contact']->findByAddress($idConsignedAddress);
					return new JsonResponse(array('packing_sheet_consignedContactId' => $consignedContacts));
					break;

				case "packing_sheet_deliveryAddressId" :
					$idDeliveryAddress = $request->get('packing_sheet_deliveryAddressId');
					$deliveryContacts = $app['dao.contact']->findByAddress($idDeliveryAddress);
					return new JsonResponse(array('packing_sheet_deliveryContactId' => $deliveryContacts));
					break;
			}
		}
		else{
			$packingSheetForm->handleRequest($request);
				
			//var_dump($packingSheetForm->getData());exit;
			if ($packingSheetForm->isSubmitted() && $packingSheetForm->isValid()) {
				
				$userName = $app['session']->get('user')['name'][0]." ".$app['session']->get('user')['firstName'][0];
				//var_dump($packingSheet);exit;
				$app['dao.packingSheet']->save($packingSheet, $userName);

				$app['session']->getFlashBag()->add('success', 'Packing Sheet succesfully updated.');
				return $app->redirect($app['url_generator']->generate('sheets'));
			}
		}
	}

	return $app['twig']->render('/forms/packingSheet_form.html.twig', array(
			'title' => 'Packing Sheet Edition',
			'parts' => $parts,
			'packTypes' => $packTypes,
			'read_only' => $read_only,
			'availableGroups' => $availableGroups,
			'id' => isset($id) ? $id : 0,
			'consignedOldCode' => isset($consignedOldCode) ? $consignedOldCode : null,
			'deliveryOldCode' => isset($deliveryOldCode) ? $deliveryOldCode : null,
			'packingSheet' => $packingSheet,
			'status' => $status,
			'packingSheetForm' => $packingSheetForm->createView()));

})->value('id', 0)->bind('sheet');

// Remove a Packing Sheet
$app->match('/delete_sheet/{id}', function(Request $request, $id) use ($app) {

	try{
		//Delete the Packing
		$app['dao.packingSheet']->delete($id);
		$app['session']->getFlashBag()->add('success', 'Packing Sheet succesfully removed.');
		// Redirect to admin home page
		return $app->redirect($app['url_generator']->generate('sheets'));

	} catch (Exception $e) {
		//The INSERT query failed due to a key constraint violation.
		$app['session']->getFlashBag()->add('danger', 'This packing sheet cannot be removed.');
		// Redirect to admin home page
		return $app->redirect($app['url_generator']->generate('sheets'));
	}

})->value('id', 0)->bind('packingsheet_delete');