<?php


use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Form\Type\TableType;

// Companies list page
$app->match('/tables/{selectedTable}', function(Request $request, $selectedTable) use ($app) {

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
			'selectedItems' => ($selectedTable === 'home') ? array() : $itemsList
	));

})->value('selectedTable', 'home')->bind('tables');

// General table form

$app->match('/tables/{selectedTable}/{itemId}/{status}', function(Request $request, $selectedTable, $itemId, $status) use ($app) {
		
	$selectedTableUc = ucfirst($selectedTable);
	$className = 'PackingSheets\\Domain\\'.$selectedTableUc;

	//var_dump($className);exit;
	
	if($status === 'create'){
		$tableObject = new $className();
	}
	else{
		$tableObject = $app['dao.'.$selectedTable]->find($itemId);
	}
		
	$tableForm = $app['form.factory']->create(TableType::class, $tableObject, array(
			'mapped' => ($selectedTable === 'address') ? true : false, 
			'codes' => ($selectedTable === 'address') ? $app['dao.code']->findAll() : null,
			'selectedTable' => $selectedTable,
			'labelField' => ($selectedTable !== 'header' && $selectedTable !== 'footer') ? true : false,
			'textField' => ($selectedTable === 'customStatus') ? true : false, 
	));
	
	$tableForm->handleRequest($request);
	
	if ($tableForm->isSubmitted() && $tableForm->isValid()) {
		
		//var_dump($tableForm);exit;
		
		$app['dao.'.$selectedTable]->save($tableObject);
		$app['session']->getFlashBag()->add('success', 'The '.$selectedTableUc.' entry was successfully created.');
		
		return $app['twig']->render('tables.html.twig', array('selectedTable' => $selectedTable, 'selectedTableDisplay' => $selectedTableUc, 'selectedItems' => $app['dao.'.$selectedTable]->findAll()));
	}
	
	return $app['twig']->render('/forms/table_form.html.twig', array(
			'title' => 'New '.$selectedTableUc,
			'selectedTable' => $selectedTable,
			'selectedTableDisplay' => $selectedTableUc,
			'status' => $status,
			'tableForm' => $tableForm->createView()));

})->value('itemId', 0)->bind('table');


// Delete entry in table
$app->match('/tables/{selectedTable}/delete', function(Request $request, $selectedTable) use ($app) {


})->bind('deleteInTable');