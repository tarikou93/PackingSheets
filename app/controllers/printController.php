<?php

use PackingSheets\Form\Type\PrintOptionsType;
use Symfony\Component\HttpFoundation\Request;
use PackingSheets\Domain\PrintOptions;
use PackingSheets\Domain\PackingSheetPDF;
use PackingSheets\Domain\packingSheetChecker;


// Print Options page
$app->match('/sheets/print/{psId}', function(Request $request, $psId) use ($app) {

	$packingSheet = $app['dao.packingSheet']->find($psId);
	$headers = $app['dao.header']->findAll();
	$footers = $app['dao.footer']->findAll();
	$psChecker = new packingSheetChecker();
	
	if(count($packingSheet->getPackingList()->getParts()) !== 0){
		$app['session']->getFlashBag()->add('danger', 'This Packing Sheet cannot be printed due to remaining parts in its Packing List. Please assign these ones to Packings.');
		return $app->redirect($app['url_generator']->generate('sheet', array('id' => $psId, 'status' => 'details')));
	}
	elseif(!$psChecker->checkPackingSheetCompletion($packingSheet)){
		$app['session']->getFlashBag()->add('danger', 'This Packing Sheet cannot be printed due to missing informations.');
		return $app->redirect($app['url_generator']->generate('sheetList', array('id' => $psId)));
	}

	$printOptions = new PrintOptions();
	$printOptionsForm = $app['form.factory']->create(PrintOptionsType::class, $printOptions, array('headers' => $headers, 'footers' => $footers));


	$printOptionsForm->handleRequest($request);

	if ($printOptionsForm->isSubmitted() && $printOptionsForm->isValid()) {
		
		//var_dump($printOptionsForm->getdata());exit;
		
		// Instanciation de la classe dérivée
		$pdf = new PackingSheetPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Times','',12);
		for($i=1;$i<=40;$i++)
			$pdf->Cell(0,10,'Impression de la ligne numéro '.$i,0,1);
			$pdf->Output();
		exit;
			
		/*return $app['twig']->render('sheets.html.twig', array(
				'title' => 'Sheets',
				'sheet' => $packingSheet,
				'printOptionsForm' => $printOptionsForm->createView()));*/
		
	}

	return $app['twig']->render('/forms/printOptions.html.twig', array(
			'title' => 'Sheet Printing',
			'sheet' => $packingSheet,
			'printOptionsForm' => $printOptionsForm->createView()));

})->bind('printOptions');