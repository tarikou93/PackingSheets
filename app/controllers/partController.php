<?php

use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Form\Type\PartType;
use PackingSheets\Domain\Part;

// Parts list page
$app->get('/parts', function () use ($app) {
	$parts = $app['dao.part']->findAll();
	$searchTag = 0;
	return $app['twig']->render('parts.html.twig', array('parts' => $parts, 'searchTag' => $searchTag));
})->bind('parts');

// Parts

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
