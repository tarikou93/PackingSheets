<?php

use PackingSheets\Form\Type\ContactTypeAdd;
use PackingSheets\Form\Type\ContactTypeEdit;
use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\Contact;
use Symfony\Component\HttpFoundation\JsonResponse;
use PackingSheets\Form\Type\ContactSearchType;
use PackingSheets\Domain\ContactSearch;

// Contacts

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

	$addressOld = $app['dao.address']->find($contact->getAddressId());
	$codeOld = $app['dao.code']->find($addressOld->getCodeId());

	$addressDAO = $app['dao.address'];
	$codeDAO = $app['dao.code'];

	$contactForm = $app['form.factory']->create(ContactTypeEdit::class, $contact, array('codes' => $codes, 'codeOld' => $codeOld, 'codeDAO' => $codeDAO, 'addressDAO' => $addressDAO));

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


 // Contacts list page
 $app->match('/contacts/{id}', function(Request $request, $id) use ($app) {
 	
 	$codesComplete = $app['dao.code']->findAll();
 	
	$contactSearch = new ContactSearch();
	$contactSearchForm = $app['form.factory']->create(ContactSearchType::class, $contactSearch);	 	 
		 
 	$contactSearchForm->handleRequest($request);
 	if ($contactSearchForm->isSubmitted() && $contactSearchForm->isValid()) {
 		$searchedCodes = $app['dao.code']->findBySearch($contactSearch);
 		//var_dump($searchedCodes);exit;
 		return $app['twig']->render('contacts.html.twig', array(
 			'title' => 'Contacts',
 			'codes' => $searchedCodes,
 			'codesComplete' => $codesComplete,
 			'contactSearchForm' => $contactSearchForm->createView()));	
 	}
	
	 return $app['twig']->render('contacts.html.twig', array(
	 'title' => 'Contacts',
	 'codes' => ($id === 0) ? array() : $app['dao.code']->findAllById($id),
	 'codesComplete' => $codesComplete,
	 'contactSearchForm' => $contactSearchForm->createView()));
	 
 })->value('id', 0)->bind('contacts');
