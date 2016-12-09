<?php

use PackingSheets\Form\Type\ContactTypeAdd;
use PackingSheets\Form\Type\ContactTypeEdit;
use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\Contact;
use Symfony\Component\HttpFoundation\JsonResponse;
//use PackingSheets\Form\Type\ContactSearchType;

// Contacts

// Contacts list page
$app->get('/contacts', function () use ($app) {
	$codes = $app['dao.code']->findAll();
	$searchTag = 0;
	return $app['twig']->render('contacts.html.twig', array('codes' => $codes, 'searchTag' => $searchTag));
})->bind('contacts');

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

/*
 // Contacts list page
 $app->match('/contacts', function(Request $request) use ($app) {

 $searchTag = 0;
 $codes = $app['dao.code']->findAll();

 $addressDAO = $app['dao.address'];
 $codeDAO = $app['dao.code'];

 $contactForm = $app['form.factory']->create(ContactSearchType::class, array('codes' => $codes, 'codeDAO' => $codeDAO, 'addressDAO' => $addressDAO));

 if($request->isMethod('POST')){
 if($request->isXmlHttpRequest()){
 $id = $request->get('code');
 $addresses = $app['dao.address']->findByCode($id);
 return new JsonResponse(array('addresses' => $addresses));
 }
 else{
 $contactForm->handleRequest($request);
 if ($contactForm->isSubmitted() && $contactForm->isValid()) {
 $searchedContacts = $app['dao.contact']->findBySearch($request);
 return $app->redirect($app['url_generator']->generate('contacts', array('codes' => $searchedContacts, 'searchTag' => 1)));
 }
 }
 	
 }

 return $app['twig']->render('/forms/contact_form.html.twig', array(
 'title' => 'Contacts',
 'codes' => $codes,
 'searchTag = 0' => $searchTag,
 'contactForm' => $contactForm->createView()));
 })->bind('contacts');*/
