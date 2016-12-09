<?php

use PackingSheets\Form\Type\PackingListType;
use PackingSheets\Domain\PackingList;
use Symfony\Component\HttpFoundation\Request;

//Packing list
$app->match('/sheetslist/{id}', function(Request $request, $id) use ($app) {
	$packingList = $app['dao.packingList']->findByPackingSheet($id);
	$psRef = $app['dao.packingSheet']->find($id)->getRef();
	$parts_list = $app['dao.part']->findAll();
	$packingListForm = $app['form.factory']->create(PackingListType::class, $packingList, array('parts_list' => $parts_list));
	$packingListForm->handleRequest($request);


	if ($packingListForm->isSubmitted() && $packingListForm->isValid()) {
		//$selectedParts = $packingListForm->get('parts')->getData();
		$app['dao.packingList']->save($packingList);
			
		$app['session']->getFlashBag()->add('success', 'Packing List succesfully updated.');
		//var_dump($packingList);
		return $app->redirect($app['url_generator']->generate('sheetList', array('id' => $id)));
	}
	return $app['twig']->render('/forms/packingList_form.html.twig', array(
			'title' => 'Packing List',
			'packingList' => $packingList,
			'parts_list' => $parts_list,
			'id' => $id,
			'psRef' => $psRef,
			'packingListForm' => $packingListForm->createView()));

})->bind('sheetList');