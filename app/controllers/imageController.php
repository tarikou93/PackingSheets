<?php

use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\ImageForm;
use PackingSheets\Form\Type\ImageType;

// Display all images for a packing

$app->get('/images/sheets/{id}/packing/{packingId}', function($id, $packingId) use ($app) {
	
	$images = $app['dao.image']->findAllByPacking($packingId);
	
	return $app['twig']->render('images.html.twig', array(
			'title' => 'Images',
			'idSheet' => $id,
			'idPacking' => $packingId,
			'images' => $images));
	
})->bind('images');


// Add Images form 

$app->match('images/add/sheets/{id}/packing/{packingId}', function(Request $request, $id, $packingId) use ($app) {
	
	$imageFormObject = new ImageForm();
	
	$imageForm = $app['form.factory']->create(ImageType::class, $imageFormObject);
	$imageForm->handleRequest($request);
	
	if ($imageForm->isSubmitted() && $imageForm->isValid()) {
		
		// Uploading Files
		$images = $app['dao.image']->upload($imageFormObject, $packingId);
		
		// Saving in DB
		$app['dao.image']->save($images);
		
		$app['session']->getFlashBag()->add('success', 'The images have been successfully uploaded.');
		
		return $app->redirect($app['url_generator']->generate('images', array('id' => $id, 'packingId' => $packingId)));
	}
	
	return $app['twig']->render('/forms/image_form.html.twig', array(
			'title' => 'New Images',
			'imageForm' => $imageForm->createView()));
	
})->bind('images_add');

// Remove an Image

$app->get('/images/delete/sheets/{id}/packing/{packingId}/image/{imageId}', function(Request $request, $id, $packingId, $imageId) use ($app) {
	
	try{
		// Delete the image
		$app['dao.image']->delete($imageId);
		
		$app['session']->getFlashBag()->add('success', 'Image succesfully removed.');
		
		// Redirect to admin home page
		return $app->redirect($app['url_generator']->generate('images', array('id' => $id, 'packingId' => $packingId)));

	} catch (Exception $e) {
		//The INSERT query failed due to a key constraint violation.
		$app['session']->getFlashBag()->add('danger', 'This Image cannot be removed.');
		// Redirect to admin home page
		return $app->redirect($app['url_generator']->generate('images', array('id' => $id, 'packingId' => $packingId)));
	}

})->bind('images_delete');