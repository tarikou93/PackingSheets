<?php


use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Form\Type\TableType;
use PackingSheets\Domain\Address;

// General display of tables

$app->match('/tables/view/{selectedTable}', function(Request $request, $selectedTable) use ($app) {

	if($selectedTable !== 'home'){
		if($selectedTable === 'address' || $selectedTable === 'company'){
			$itemsList = $app['dao.code']->findAll();
		}
		else{
			$itemsList = $app['dao.'.$selectedTable]->findAll();
		}
	}
	
	//var_dump($options[$selectedTable]);exit;

	return $app['twig']->render('tables.html.twig', array(
			'title' => $selectedTable,
			'selectedTable' => $selectedTable,
			'selectedTableDisplay' => ucfirst($selectedTable),
			'selectedItems' => ($selectedTable === 'home') ? array() : $itemsList,
			'labelField' => ($selectedTable !== 'header' && $selectedTable !== 'footer') ? true : false,
			'textField' => ($selectedTable === 'customStatus' || $selectedTable === 'header' || $selectedTable === 'footer' || $selectedTable === 'imput') ? true : false
	));

})->value('selectedTable', 'home')->bind('tables');

// General table form

$app->match('/tables/edit/{selectedTable}/{itemId}/{status}', function(Request $request, $selectedTable, $itemId, $status) use ($app) {
		
	$selectedTableUc = ucfirst($selectedTable);
	$className = 'PackingSheets\\Domain\\'.$selectedTableUc;

	//var_dump($className);exit;
	
	if($status === 'create'){
		$tableObject = new $className();
		$endString = "created";
	}
	else{
		$tableObject = $app['dao.'.$selectedTable]->find($itemId);
		$endString = "edited";
	}
	
	$labelField = ($selectedTable !== 'header' && $selectedTable !== 'footer') ? true : false;
	$textField = ($selectedTable === 'customStatus' || $selectedTable === 'header' || $selectedTable === 'footer' || $selectedTable === 'imput') ? true : false;
			
	$tableForm = $app['form.factory']->create(TableType::class, $tableObject, array(
			'selectedTable' => $selectedTable,
			'labelField' => $labelField,
			'textField' => $textField, 
	));
	
	$tableForm->handleRequest($request);
	
	if ($tableForm->isSubmitted() && $tableForm->isValid()) {
		
		//var_dump($tableForm->getData());exit;
			
		$app['dao.'.$selectedTable]->save($tableObject);
		$app['session']->getFlashBag()->add('success', 'The '.$selectedTableUc.' entry was successfully '.$endString);
		
		return $app['twig']->render('tables.html.twig', array(
				'selectedTable' => $selectedTable, 
				'selectedTableDisplay' => $selectedTableUc, 
				'selectedItems' => $app['dao.'.$selectedTable]->findAll(),
				'labelField' => $labelField,
				'textField' => $textField
			));
	}
	
	return $app['twig']->render('/forms/table_form.html.twig', array(
			'title' => 'New '.$selectedTableUc,
			'selectedTable' => $selectedTable,
			'selectedTableDisplay' => $selectedTableUc,
			'status' => $status,
			'labelField' => $labelField,
			'textField' => $textField,
			'tableForm' => $tableForm->createView()));

})->value('itemId', 0)->bind('table');

//Manage Addresses for a Company

$app->match('/company/{codeId}/addresses', function(Request $request, $codeId) use ($app) {

	$addresses = $app['dao.address']->findByCode($codeId);
	$codeLabel = $app['dao.code']->find($codeId)->getlabel();

	return $app['twig']->render('tables.html.twig', array(
			'title' => 'Address',
			'selectedTable' => 'address',
			'selectedTableDisplay' => 'Address',
			'selectedItems' => $addresses,
			'labelField' => true,
			'textField' => false,
			'codeId' => $codeId,
			'codeLabel' => $codeLabel
	));

})->bind('companyAddresses');

// Address List for a Company

$app->match('/company/{codeId}/addresses/{addressId}/{status}', function(Request $request, $codeId, $addressId, $status) use ($app) {

	//var_dump($className);exit;

	if($status === 'create'){
		$address = new Address();
		$endString = "created";
	}
	else{
		$address = $app['dao.address']->find($addressId);
		$endString = "edited";
	}

	$labelField = true;
	$textField = false;
	
	$codeLabel = $app['dao.code']->find($codeId)->getLabel();
		
	$addressForm = $app['form.factory']->create(TableType::class, $address, array(
			'selectedTable' => 'address',
			'labelField' => $labelField,
			'textField' => $textField,
	));

	$addressForm->handleRequest($request);

	if ($addressForm->isSubmitted() && $addressForm->isValid()) {

		//var_dump($tableForm->getData());exit;
		
		$app['dao.address']->save($address, $codeId);
		$app['session']->getFlashBag()->add('success', 'The Address entry was successfully '.$endString);
			
		return $app['twig']->render('tables.html.twig', array(
				'title' => 'Address',
				'selectedTable' => 'address',
				'selectedTableDisplay' => 'Address',
				'selectedItems' => $app['dao.address']->findByCode($codeId),
				'labelField' => true,
				'textField' => false,
				'codeId' => $codeId,
				'codeLabel' => $codeLabel
		));		
	}

	return $app['twig']->render('/forms/table_form.html.twig', array(
			'title' => 'New Address',
			'selectedTable' => 'address',
			'selectedTableDisplay' => 'Address',
			'status' => $status,
			'labelField' => $labelField,
			'textField' => $textField,
			'codeId' => $codeId,
			'codeLabel' => $codeLabel,
			'tableForm' => $addressForm->createView()));

})->value('codeId', 0)->value('addressId', 0)->bind('companyAddress');

// Delete entry in table
$app->match('/tables/delete/{selectedTable}/{itemId}', function(Request $request, $selectedTable, $itemId) use ($app) {
	
	try{
		// Delete the article
		$app['dao.'.$selectedTable]->delete($itemId);
		$app['session']->getFlashBag()->add('success', 'The '.ucfirst($selectedTable).' entry was succesfully removed.');
		
	} catch (Exception $e) {
		//The INSERT query failed due to a key constraint violation.
		$app['session']->getFlashBag()->add('danger', 'This '.ucfirst($selectedTable).' entry cannot be removed due to its use in an active Packing Sheet.');
	}
		
	if($selectedTable !== 'home'){
		if($selectedTable === 'address' || $selectedTable === 'company'){
			$itemsList = $app['dao.code']->findAll();
		}
		else{
			$itemsList = $app['dao.'.$selectedTable]->findAll();
		}
	}
	
	// Redirect to admin home page
	return $app['twig']->render('tables.html.twig', array(
			'title' => $selectedTable,
			'selectedTable' => $selectedTable,
			'selectedTableDisplay' => ucfirst($selectedTable),
			'selectedItems' => ($selectedTable === 'home') ? array() : $itemsList,
			'labelField' => ($selectedTable !== 'header' && $selectedTable !== 'footer') ? true : false,
			'textField' => ($selectedTable === 'customStatus' || $selectedTable === 'header' || $selectedTable === 'footer' || $selectedTable === 'imput') ? true : false
	));

})->bind('deleteEntry');

// Delete a Company
$app->match('/company/delete/{codeId}', function(Request $request, $codeId) use ($app) {
	
	$addresses = $app['dao.code']->find($codeId)->getAddresses();
	
	try{
		foreach($addresses as $address){
			$app['dao.address']->delete($address->getId());
		}
		// Delete the article
		$app['dao.code']->delete($codeId);
		$app['session']->getFlashBag()->add('success', 'The Code entry was succesfully removed.');

	} catch (Exception $e) {
		//The INSERT query failed due to a key constraint violation.
		$app['session']->getFlashBag()->add('danger', 'This Code entry cannot be removed due to its use in an active Packing Sheet.');
	}


	// Redirect to admin home page
	return $app['twig']->render('tables.html.twig', array(
			'title' => 'Code',
			'selectedTable' => 'code',
			'selectedTableDisplay' => 'Code',
			'selectedItems' => $app['dao.code']->findAll(),
			'labelField' => true,
			'textField' => false
	));

})->bind('deleteCode');

// Delete an address
$app->match('/company/{codeId}/address/delete/{addressId}', function(Request $request, $codeId, $addressId) use ($app) {

	$code = $app['dao.code']->find($codeId);

	try{
		// Delete the article
		$app['dao.address']->delete($addressId);
		$app['session']->getFlashBag()->add('success', 'The Address entry was succesfully removed.');

	} catch (Exception $e) {
		//The INSERT query failed due to a key constraint violation.
		$app['session']->getFlashBag()->add('danger', 'This Address entry cannot be removed due to its use in an active Packing Sheet.');
	}


	// Redirect to admin home page
	return $app['twig']->render('tables.html.twig', array(
			'title' => 'Address',
			'selectedTable' => 'address',
			'selectedTableDisplay' => 'Address',
			'selectedItems' => $app['dao.address']->findByCode($codeId),
			'labelField' => true,
			'textField' => false,
			'codeId' => $codeId,
			'codeLabel' => $code->getLabel()
	));

})->bind('deleteAddress');