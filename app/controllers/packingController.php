<?php

use PackingSheets\Form\Type\PackingType;
use PackingSheets\Form\Type\PackingAssignationType;
use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\PackingAssignation;
use PackingSheets\Domain\Packing;
use Symfony\Component\HttpFoundation\File\File;


// Packings list page
$app->get('/sheets/{id}/packings', function ($id) use ($app) {
	$packings = $app['dao.packing']->findAllByPackingSheet($id);
	$psRef = $app['dao.packingSheet']->find($id)->getRef();
	//var_dump($packings);exit;
	return $app['twig']->render('packings.html.twig', array(
			'title' => 'Packings',
			'packings' => $packings,
			'idSheet' => $id,
			'psRef' => $psRef));
})->bind('packings');


//Packing Page
$app->match('/sheets/{id}/packings/{packingid}/{status}', function(Request $request, $id, $packingid, $status) use ($app) {
	
	if($status === "create"){
		$packing = new Packing();
		$packing->setPSid($id);
		
		$packing->setImg(new File($_SERVER['DOCUMENT_ROOT'].'/img/imgNotFound.png'));
		//$packing->setImg(new File('C:/xampp/htdocs/PackingSheets/web/img/imgNotFound.png'));
	}
	else{
		
		$packing = $app['dao.packing']->find($packingid);
		
		if(file_exists($_SERVER['DOCUMENT_ROOT'].'/img/'.$packing->getImg())){
			$file = new File($_SERVER['DOCUMENT_ROOT'].'/img/'.$packing->getImg());
		}
		else{ $file = new File($_SERVER['DOCUMENT_ROOT'].'/img/imgNotFound.png');}
		
		$packing->setImg($file);	
		
	}

	$packingSheet = $app['dao.packingSheet']->find($id);
	$parts_list = $app['dao.part']->findAll();
	$packing_types = $app['dao.packType']->findAll();
	$packingForm = $app['form.factory']->create(PackingType::class, $packing, array('parts_list' => $parts_list, 'packing_types' => $packing_types, 'context' => 'packingForm'));
	$packingForm->handleRequest($request);


	if ($packingForm->isSubmitted() && $packingForm->isValid()) {
		//$selectedParts = $packingListForm->get('parts')->getData();
		
		$file = $packing->getImg();
		
		// Generate a unique name for the file before saving it
		$fileName = md5(uniqid()).'.'.$file->guessExtension();
		
		// Move the file to the directory where brochures are stored
		$file->move('C:/xampp/htdocs/PackingSheets/web/img',$fileName);
		
		// Update the 'brochure' property to store the PDF file name
		// instead of its contents
		$packing->setImg($fileName);

		$app['dao.packing']->save($packing);
			
		$app['session']->getFlashBag()->add('success', 'Packing succesfully updated.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('packings', array('id' => $id)));
	}
	
	//var_dump($packing->getImg());exit;
	return $app['twig']->render('/forms/packing_form.html.twig', array(
			'title' => 'Packing',
			'id' => $id,
			'image' => ($packing->getImg() === null) ? 'imgNotFound.png' : $packing->getImg()->getFilename(),
			'psRef' => $packingSheet->getRef(),
			'status' => $status,
			'packingid' => $packingid,
			'packingForm' => $packingForm->createView()));

})->value('packingid', 0)->bind('packing');


//Packing Assignation
$app->match('/sheets/{id}/packings_assignation', function(Request $request, $id) use ($app) {

	$packingSheet = $app['dao.packingSheet']->find($id);
	$packings = $packingSheet->getPackings();
	$psRef = $packingSheet->getRef();
	$packingListParts = $packingSheet->getPackingList()->getParts();
	$packingAssignation = new PackingAssignation();

	$packingAssignationForm = $app['form.factory']->create(PackingAssignationType::class, $packingAssignation, array('packingListParts' => $packingListParts, 'packings' => $packings));
	$packingAssignationForm->handleRequest($request);


	if ($packingAssignationForm->isSubmitted() && $packingAssignationForm->isValid()) {
		//$selectedParts = $packingListForm->get('parts')->getData();

		$app['dao.packingAssignation']->assignPacking($packingAssignation);
			
		$app['session']->getFlashBag()->add('success', 'Packing List Part succesfully added to Packing.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('packings', array('id' => $id)));
	}
	return $app['twig']->render('/forms/packingAssignation_form.html.twig', array(
			'title' => 'Packing Assignation',
			'id' => $id,
			'psRef' => $psRef,
			'packingAssignationForm' => $packingAssignationForm->createView()));

})->bind('packingAssignation');

// Remove a Packing
$app->match('/sheets/{id}/delete_packing/{packingid}', function(Request $request, $id, $packingid) use ($app) {

	try{
		//Delete the Packing
		$app['dao.packing']->delete($packingid);
		$app['session']->getFlashBag()->add('success', 'Packing succesfully removed.');
		// Redirect to admin home page
		return $app->redirect($app['url_generator']->generate('packings', array('id' => $id)));

	} catch (Exception $e) {
		//The INSERT query failed due to a key constraint violation.
		$app['session']->getFlashBag()->add('danger', 'This packing cannot be removed.');
		// Redirect to admin home page
		return $app->redirect($app['url_generator']->generate('packings', array('id' => $id)));
	}

})->bind('packing_delete');