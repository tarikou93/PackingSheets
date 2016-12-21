<?php

use PackingSheets\Form\Type\PrintOptionsType;
use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\PrintOptions;
use PackingSheets\Domain\PackingSheetPDF;
use PackingSheets\Domain\PackingListPDF;
use PackingSheets\Domain\packingSheetChecker;


// Print Options page
$app->match('/sheets/print/{psId}', function(Request $request, $psId) use ($app) {

	
	$packingSheet = $app['dao.packingSheet']->find($psId);
	$headers = $app['dao.header']->findAll();
	$footers = $app['dao.footer']->findAll();
	$psChecker = new packingSheetChecker();
	
	if(count($packingSheet->getPackingList()->getParts()) !== 0){
		$app['session']->getFlashBag()->add('danger', 'This Packing Sheet cannot be printed due to remaining parts in its Packing List. Please assign these ones to Packings.');
		return $app->redirect($app['url_generator']->generate('sheetList', array('id' => $psId)));
	}
	if(!$psChecker->checkPackingSheetCompletion($packingSheet)){
		$app['session']->getFlashBag()->add('danger', 'This Packing Sheet cannot be printed due to missing informations.');
		return $app->redirect($app['url_generator']->generate('sheets'));
	}

	$printOptions = new PrintOptions();
	$printOptionsForm = $app['form.factory']->create(PrintOptionsType::class, $printOptions, array('headers' => $headers, 'footers' => $footers));


	$printOptionsForm->handleRequest($request);

	if ($printOptionsForm->isSubmitted() && $printOptionsForm->isValid()) {
		
		//var_dump($printOptionsForm->getdata());exit;
		
		// Instanciation de la classe d�riv�e
		
		$pdf = new PackingSheetPDF();
		$pdf->setPs($packingSheet);
		$pdf->setHeader($printOptions->getHeader());
		$pdf->setFooter($printOptions->getFooter());
		$pdf->setHsCodesStatus($printOptions->getHscodesStatus());
		$pdf->setLogo('logo.png');
		
		$pdf->AddPage();
		$pdf->build();
		$pdf->Output();
	
		exit;
			
	}

	return $app['twig']->render('/forms/printOptions.html.twig', array(
			'title' => 'Sheet Printing',
			'sheet' => $packingSheet,
			'printOptionsForm' => $printOptionsForm->createView()));
	

})->bind('printOptions');

// Print List
$app->match('/print/list/{id}', function($id) use ($app) {

	$packingSheet = $app['dao.packingSheet']->find($id);
	
	//var_dump($printOptionsForm->getdata());exit;

	$pdf = new PackingListPDF();
	$pdf->setPl($packingSheet->getPackingList());
	$pdf->setRef($packingSheet->getRef());
	$pdf->setLogo('logo.png');

	$pdf->AddPage();
	$pdf->build();
	$pdf->Output();

	exit;
	
})->bind('printList');