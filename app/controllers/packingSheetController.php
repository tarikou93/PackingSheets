<?php

use PackingSheets\Form\Type\PackingSheetType;
use PackingSheets\Domain\PackingSheet;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

// PackingSheets list page
$app->get('/sheets', function () use ($app) {

	$packingSheets = $app['dao.packingSheet']->findAllByUserSeries($app['session']->get('auth')['packingSheetsSeries']);
	$codes = $app['dao.code']->findAll();
	$inputs = $app['dao.imput']->findAll();
	$searchTag = 0;
	return $app['twig']->render('packingSheet.html.twig', array('packingSheets' => $packingSheets, 'codes' => $codes, 'inputs' => $inputs, 'searchTag' => $searchTag));
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

		$consignedOldCode = $app['dao.code']->find($packingSheet->getConsignedAddressId()->getCodeId());
		$deliveryOldCode = $app['dao.code']->find($packingSheet->getDeliveryAddressId()->getCodeId());
		
		if($status === 'edit'){
			if($packingSheet->getSigned()){
				if($packingSheet->getSigningUser() !== $app['session']->get('user')['username']){
					
					$app['session']->getFlashBag()->add('danger', 'This Packing Sheet has been signed by another User. Please ask to edit.');
					return $app->redirect($app['url_generator']->generate('sheets'));
				}
			}			
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
	$autorities = $app['dao.autority']->findAll();
	$customStatuses = $app['dao.customStatus']->findAll();
	$incTypes = $app['dao.incotermsType']->findAll();
	$incLocs = $app['dao.incotermsLocation']->findAll();
	$currencies = $app['dao.currency']->findAll();
	$imputs = $app['dao.imput']->findAll();

	$address = $app['dao.address'];
	//var_dump($app['session']->get('user')['username']);exit;
	$availableGroups = $app['session']->get('auth')['packingSheetsSeries'];

	//var_dump($packingSheet);exit;

	$packingSheetForm = $app['form.factory']->create(PackingSheetType::class, $packingSheet, array(
			'parts' => $parts, 'packTypes' => $packTypes, 'read_only' => $read_only, 'status' => $status, 'codes' => $codes, 'address' => $address, 'availableGroups' => $availableGroups,
			'consignedAddresses' => $consignedAddresses, 'deliveryAddresses' => $deliveryAddresses,'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs,
			'consignedOldCode' => isset($consignedOldCode) ? $consignedOldCode : null,
			'deliveryOldCode' => isset($deliveryOldCode) ? $deliveryOldCode : null
	));

	$consignedContacts = array();

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
					$consignedContacts = $app['dao.contact']->findAllByAddress($idConsignedAddress);
					return new JsonResponse(array('packing_sheet_consignedContactId' => $consignedContacts));
					break;

				case "packing_sheet_deliveryAddressId" :
					$idDeliveryAddress = $request->get('packing_sheet_deliveryAddressId');
					$deliveryContacts = $app['dao.contact']->findAllByAddress($idDeliveryAddress);
					return new JsonResponse(array('packing_sheet_deliveryContactId' => $deliveryContacts));
					break;
			}
		}
		else{
			$packingSheetForm->handleRequest($request);
				
			//var_dump($packingSheet);exit;
			if ($packingSheetForm->isSubmitted() && $packingSheetForm->isValid()) {
				
				if($packingSheet->getSigned()){
					$packingSheet->setSigningUser($app['session']->get('user')['username']);
				}
				
				$app['dao.packingSheet']->save($packingSheet);

				$app['session']->getFlashBag()->add('success', 'Packing Sheet succesfully updated.');
				return $app->redirect($app['url_generator']->generate('sheets'));
			}
		}
	}

	//var_dump($app['dao.packingSheet']->find(18));exit;

	return $app['twig']->render('/forms/packingSheet_form.html.twig', array(
			'title' => 'Packing Sheet Edition',
			'parts' => $parts,
			'packTypes' => $packTypes,
			'read_only' => $read_only,
			'availableGroups' => $availableGroups,
			'codes' => $codes, 'consignedAddresses' => $consignedAddresses, 'deliveryAddresses' => $deliveryAddresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs,
			'id' => isset($id) ? $id : null,
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