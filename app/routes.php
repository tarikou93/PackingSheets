<?php

use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\Part;
use PackingSheets\Domain\Contact;
use PackingSheets\Domain\PackingSheet;
use PackingSheets\Form\Type\PartType;
use PackingSheets\Form\Type\ContactTypeAdd;
use PackingSheets\Form\Type\ContactTypeEdit;
use Symfony\Component\HttpFoundation\JsonResponse;
use PackingSheets\Form\Type\PackingListType;
use PackingSheets\Form\Type\PackingSheetType;
use PackingSheets\Form\Type\PackingType;

//use Symfony\Component\Form\Extension\Core\Type\FormType;
// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// PackingSheets list page
$app->get('/sheets', function () use ($app) {
    $packingSheets = $app['dao.packingSheet']->findAll();
    $codes = $app['dao.code']->findAll();
    $inputs = $app['dao.imput']->findAll();
    $searchTag = 0;
    return $app['twig']->render('packingSheet.html.twig', array('packingSheets' => $packingSheets, 'codes' => $codes, 'inputs' => $inputs, 'searchTag' => $searchTag));
})->bind('sheets');

// Parts list page
$app->get('/parts', function () use ($app) {
    $parts = $app['dao.part']->findAll();
    $searchTag = 0;
    return $app['twig']->render('parts.html.twig', array('parts' => $parts, 'searchTag' => $searchTag));
})->bind('parts');

// Contacts list page
$app->get('/contacts', function () use ($app) {
    $contacts = $app['dao.contact']->findAll();
    $codes = $app['dao.code']->findAll();
    
    $searchTag = 0;
    return $app['twig']->render('contacts.html.twig', array('contacts' => $contacts, 'codes' => $codes, 'searchTag' => $searchTag));
})->bind('contacts');

/*
// PackingSheet details with Packings and detailed parts
$app->get('/sheets/{id}', function ($id) use ($app) {
    $packingSheet = $app['dao.packingSheet']->find($id);
    $packings = $app['dao.packing']->findAllByPackingSheet($id);
    $packingParts = $app['dao.packingPart']->findAll();
    
    $Psid = $id;
    return $app['twig']->render('packingSheetDetails.html.twig', array('packingSheet' => $packingSheet, 'packings' => $packings, 'packingParts' => $packingParts, 
    		'Psid' => $Psid));
})->bind('sheetDetails');*/

//Packing Sheet Consultation
$app->match('/sheets/{id}/details', function(Request $request, $id) use ($app) {

	$packingSheet = $app['dao.packingSheet']->find($id);
	$parts = $app['dao.part']->findAll();
	$packTypes = $app['dao.packType']->findAll();
	$addresses = $app['dao.address']->findAll();
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
	
	
	$packingSheetForm = $app['form.factory']->create(PackingSheetType::class, $packingSheet, array(
			'parts' => $parts, 'packTypes' => $packTypes, 'read_only' => true,
			'addresses' => $addresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs	
	));
	$packingSheetForm->handleRequest($request);


	if ($packingSheetForm->isSubmitted() && $packingSheetForm->isValid()) {

		//$selectedPackings = $packingSheetForm->get('packings')->getData();
		$app['dao.packingSheet']->save($packingSheet);
			
		$app['session']->getFlashBag()->add('success', 'Packing Sheet succesfully updated.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('sheetDetails', array('id' => $id, 'packingSheet' => $packingSheet)));
	}
	return $app['twig']->render('/forms/packingSheet_form.html.twig', array(
			'title' => 'Packing Sheet Consultation',
			'parts' => $parts,
			'packTypes' => $packTypes,
			'read_only' => true,
			'addresses' => $addresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs,
			'id' => $id,
			'packingSheet' => $packingSheet,
			'packingSheetForm' => $packingSheetForm->createView()));

})->bind('sheetDetails');

//Packing Sheet Creation
$app->match('/sheets/create', function(Request $request) use ($app) {

	$packingSheet = new PackingSheet();
	$parts = $app['dao.part']->findAll();
	$packTypes = $app['dao.packType']->findAll();
	$addresses = $app['dao.address']->findAll();
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
	
	
	$packingSheetForm = $app['form.factory']->create(PackingSheetType::class, $packingSheet, array(
			'parts' => $parts, 'packTypes' => $packTypes, 'read_only' => false,
			'addresses' => $addresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs
	));
	$packingSheetForm->handleRequest($request);


	if ($packingSheetForm->isSubmitted() && $packingSheetForm->isValid()) {

		//$selectedPackings = $packingSheetForm->get('packings')->getData();
		$app['dao.packingSheet']->save($packingSheet);
			
		$app['session']->getFlashBag()->add('success', 'Packing Sheet succesfully updated.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('sheetDetails'));
	}
	return $app['twig']->render('/forms/packingSheet_form.html.twig', array(
			'title' => 'Packing Sheet Edition',
			'parts' => $parts,
			'packTypes' => $packTypes,
			'read_only' => false,
			'addresses' => $addresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs,
			'packingSheetForm' => $packingSheetForm->createView()));

})->bind('sheetCreate');

//Packing Sheet Edition
$app->match('/sheets/{id}/edit', function(Request $request, $id) use ($app) {

	$packingSheet = $app['dao.packingSheet']->find($id);
	$parts = $app['dao.part']->findAll();
	$packTypes = $app['dao.packType']->findAll();
	$addresses = $app['dao.address']->findAll();
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
	
	$packingSheetForm = $app['form.factory']->create(PackingSheetType::class, $packingSheet, array(
			'parts' => $parts, 'packTypes' => $packTypes, 'read_only' => false,
			'addresses' => $addresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs
	));
	$packingSheetForm->handleRequest($request);


	if ($packingSheetForm->isSubmitted() && $packingSheetForm->isValid()) {
		
		//$selectedPackings = $packingSheetForm->get('packings')->getData();
		$app['dao.packingSheet']->save($packingSheet);
			
		$app['session']->getFlashBag()->add('success', 'Packing Sheet succesfully updated.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('sheetDetails', array('id' => $id, 'packingSheet' => $packingSheet)));
	}
	return $app['twig']->render('/forms/packingSheet_form.html.twig', array(
			'title' => 'Packing Sheet Edition',
			'parts' => $parts,
			'packTypes' => $packTypes,
			'read_only' => false,
			'addresses' => $addresses, 'contacts' => $contacts, 'services' => $services, 'contents' => $contents, 'priorities' => $priorities, 'shippers' => $shippers,
			'autorities' => $autorities, 'customStatuses' => $customStatuses, 'incTypes' => $incTypes, 'incLocs' => $incLocs, 'currencies' => $currencies, 'imputs' => $imputs,
			'id' => $id,
			'packingSheet' => $packingSheet,
			'packingSheetForm' => $packingSheetForm->createView()));

})->bind('sheetEdit');


//Packing Edition
$app->match('/sheets/{id}/packing/{packingid}', function(Request $request, $id, $packingid) use ($app) {

	$packingSheet = $app['dao.packingSheet']->find($id);
	$packing = $app['dao.packing']->find($packingid);
	$parts_list = $app['dao.part']->findAll();
	$packing_types = $app['dao.packType']->findAll();
	$packingForm = $app['form.factory']->create(PackingType::class, $packing, array('parts_list' => $parts_list, 'packing_types' => $packing_types));
	$packingForm->handleRequest($request);


	if ($packingForm->isSubmitted() && $packingForm->isValid()) {
		//$selectedParts = $packingListForm->get('parts')->getData();
		$app['dao.packing']->save($packing);
			
		$app['session']->getFlashBag()->add('success', 'Packing succesfully updated.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('sheetEdit', array('id' => $id, 'packingSheet' => $packingSheet)));
	}
	return $app['twig']->render('/forms/packing_form.html.twig', array(
			'title' => 'Packing',
			'parts_list' => $parts_list,
			'packing_types' => $packing_types,
			'id' => $id,
			'packingid' => $packingid,
			'packingSheet' => $packingSheet,
			'packingForm' => $packingForm->createView()));

})->bind('packingDetails');

 //Packing list
 $app->match('/sheetslist/{id}', function(Request $request, $id) use ($app) {	
	 $packingList = $app['dao.packingList']->findByPackingSheet($id);
	 $packingSheet = $app['dao.packingSheet']->find($id);
	 $parts = $app['dao.part']->findAll();
	 $packingListForm = $app['form.factory']->create(PackingListType::class, $packingList, array('parts' => $parts));
	 $packingListForm->handleRequest($request);
	 
	 
	 if ($packingListForm->isSubmitted() && $packingListForm->isValid()) {
	 	//$selectedParts = $packingListForm->get('parts')->getData();
	 	$app['dao.packingList']->save($packingList);
 		
	 	$app['session']->getFlashBag()->add('success', 'Packing List succesfully updated.');
	 	//var_dump($packingList);
	 	return $app->redirect($app['url_generator']->generate('sheetList', array('id' => $id, 'packingSheet' => $packingSheet)));
	 }
	 return $app['twig']->render('/forms/packingList_form.html.twig', array(
	 		'title' => 'Packing List',
	 		'packingList' => $packingList,
	 		'parts' => $parts,
	 		'id' => $id,
	 		'packingSheet' => $packingSheet,
	 		'packingListForm' => $packingListForm->createView()));
		
 })->bind('sheetList');
 
// Logout
$app->get('/auth/logout', function () use ($app) {
    //return $app['twig']->render('auth/login.html.twig');
    return;
})->bind('logout');


//PackingSheet Search
$app->post('/search_packingsheets', function () use ($app) {
    $packingSheets = $app['dao.packingSheet']->findBySearch();
    $codes = $app['dao.code']->findAll();
    $inputs = $app['dao.imput']->findAll();
    $searchTag = 1;
    return $app['twig']->render('packingSheet.html.twig', array('packingSheets' => $packingSheets, 'codes' => $codes, 'inputs' => $inputs, 'searchTag' => $searchTag));
})->bind('searchSheets');


//Part Search
$app->post('/search_parts', function () use ($app) {
    $parts = $app['dao.part']->findBySearch();
    $searchTag = 1;
    return $app['twig']->render('parts.html.twig', array('parts' => $parts, 'searchTag' => $searchTag));
})->bind('searchParts');

//Contact Search
$app->post('/search_contacts', function () use ($app) {
    $contacts = $app['dao.contact']->findBySearch();
    $addresses = $app['dao.address']->findAll();
    $codes = $app['dao.code']->findAll();
    $searchTag = 1;
    return $app['twig']->render('contacts.html.twig', array('contacts' => $contacts, 'addresses' => $addresses, 'codes' => $codes, 'searchTag' => $searchTag));
})->bind('searchContacts');


//PackingSheet filter addresses by code with Ajax
$app->get('/sheets_ajax_address', function () use ($app) {

    if (isset($_GET["code"])) {
        $code = $_GET['code'];
    } else {
        $code = 1;
    }

    $sql = "SELECT * FROM t_address WHERE address_codeId =" . $code;
    $addresses = $app['db']->fetchAll($sql);

    //return $app['twig']->render('test.html.twig', array('addresses' => $addresses));
    //return $app->json($addresses);
    return $app->json(array('addresses' => $addresses));
})->bind('sheets_ajax_address');

//PackingSheet filter contacts by addresses with Ajax
$app->get('/sheets_ajax_contact', function () use ($app) {

    if (isset($_GET["address"])) {
        $address = $_GET['address'];
    } else {
        $address = 1;
    }

    $sql = "SELECT * FROM t_contact WHERE contact_addressId =" . $address;
    $contacts = $app['db']->fetchAll($sql);

    //return $app['twig']->render('test.html.twig', array('addresses' => $addresses));
    //return $app->json($addresses);
    return $app->json(array('contacts' => $contacts));
})->bind('sheets_ajax_contact');


// Add a new part
$app->match('/part/add', function(Request $request) use ($app) {
    $part = new Part();
    $partForm = $app['form.factory']->create(PartType::class, $part);
    $partForm->handleRequest($request);
    if ($partForm->isSubmitted() && $partForm->isValid()) {
        $app['dao.part']->save($part);
        $app['session']->getFlashBag()->add('success', 'The part was successfully created.');
        return $app->redirect($app['url_generator']->generate('parts'));
    }
    return $app['twig']->render('/forms/part_form.html.twig', array(
                'title' => 'New Part',
                'partForm' => $partForm->createView()));
})->bind('part_add');


// Edit an existing part
$app->match('/part/{id}/edit', function($id, Request $request) use ($app) {
    $part = $app['dao.part']->find($id);
    $partForm = $app['form.factory']->create(PartType::class, $part);
    $partForm->handleRequest($request);
    if ($partForm->isSubmitted() && $partForm->isValid()) {
        $app['dao.part']->save($part);
        $app['session']->getFlashBag()->add('success', 'Part succesfully updated.');
        return $app->redirect($app['url_generator']->generate('parts'));
    }
    return $app['twig']->render('/forms/part_form.html.twig', array(
                'title' => 'Edit Part',
                'partForm' => $partForm->createView()));
})->bind('part_edit');



// Remove a part
$app->get('/part/{id}/delete', function($id, Request $request) use ($app) {
    try{
        // Delete the article
        $app['dao.part']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Part was succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('parts'));
        
    } catch (Exception $e) {
        //The INSERT query failed due to a key constraint violation.
        $app['session']->getFlashBag()->add('danger', 'This part cannot be removed due to its use in an active Packing Sheet.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('parts'));
    }
    
})->bind('part_delete');

// Add a new contact
$app->match('/contact/add', function(Request $request) use ($app) {
	$contact = new Contact();
	$codes = $app['dao.code']->findAll();

	$code = $app['dao.code']->find(1);
	$address = $app['dao.address'];

	$contactForm = $app['form.factory']->create(ContactTypeAdd::class, $contact, array('codes' => $codes, 'code' => $code, 'address' => $address));

	if($request->isMethod('POST')){
		if($request->isXmlHttpRequest()){
			$id = $request->get('code');
			$addresses = $app['dao.address']->findByCode($id);
			return new JsonResponse(array('addresses' => $addresses));
		}
		else{
			$contactForm->handleRequest($request);
			if ($contactForm->isSubmitted() && $contactForm->isValid()) {
				$app['dao.contact']->save($contact);
				$app['session']->getFlashBag()->add('success', 'Contact successfully updated.');
				return $app->redirect($app['url_generator']->generate('contacts'));
			}
		}
		 
	}

	return $app['twig']->render('/forms/contact_form.html.twig', array(
			'title' => 'New Contact',
			'contactForm' => $contactForm->createView()));
})->bind('contact_add');

// Edit an existing contact
$app->match('/contact/{id}/edit', function($id, Request $request) use ($app) {
    $contact = $app['dao.contact']->find($id);
    $codes = $app['dao.code']->findAll();
  
    $code = $contact->getAddressId()->getCodeId();
    $address = $app['dao.address'];
    
    $contactForm = $app['form.factory']->create(ContactTypeEdit::class, $contact, array('codes' => $codes, 'code' => $code, 'address' => $address));
    
    if($request->isMethod('POST')){
    	if($request->isXmlHttpRequest()){
    		$id = $request->get('code');
    		$addresses = $app['dao.address']->findByCode($id);
    		return new JsonResponse(array('addresses' => $addresses));
    	}
    	else{
    		$contactForm->handleRequest($request);
    		if ($contactForm->isSubmitted() && $contactForm->isValid()) {
    			$app['dao.contact']->save($contact);
    			$app['session']->getFlashBag()->add('success', 'Contact successfully updated.');
    			return $app->redirect($app['url_generator']->generate('contacts'));
    		}
    	}
    	
    }
    
    return $app['twig']->render('/forms/contact_form.html.twig', array(
                'title' => 'Edit Contact',
                'contactForm' => $contactForm->createView()));
})->bind('contact_edit');

// Remove a contact
$app->get('/contact/{id}/delete', function($id, Request $request) use ($app) {
    try{
        // Delete the article
        $app['dao.contact']->delete($id);
        $app['session']->getFlashBag()->add('success', 'Contact succesfully removed.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('contacts'));
        
    } catch (Exception $e) {
        //The INSERT query failed due to a key constraint violation.
        $app['session']->getFlashBag()->add('danger', 'This contact cannot be removed due to its use in an active Packing Sheet.');
        // Redirect to admin home page
        return $app->redirect($app['url_generator']->generate('contacts'));
    }
})->bind('contact_delete');
