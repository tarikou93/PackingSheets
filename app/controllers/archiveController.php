<?php

use PackingSheets\Domain\Archive;
use PackingSheets\Domain\ArchiveSearch;
use PackingSheets\Form\Type\ArchiveSearchType;
use Symfony\Component\HttpFoundation\Request;

// Archives list page
$app->match('/archives', function(Request $request) use ($app) {

	$archives = $app['dao.archive']->findAll();
	
	$archiveSearch = new ArchiveSearch();
	$archiveSearchForm = $app['form.factory']->create(ArchiveSearchType::class, $archiveSearch);
	
	$archiveSearchForm->handleRequest($request);
	
	if ($archiveSearchForm->isSubmitted() && $archiveSearchForm->isValid()) {
			
		$searchedArchives = $app['dao.archive']->findBySearch($archiveSearch);

		return $app['twig']->render('archives.html.twig', array(
				'title' => 'Archives',
				'archives' => $searchedArchives,
				'searchTag' => 1,
				'archiveSearchForm' => $archiveSearchForm->createView()));
	}
		
	return $app['twig']->render('archives.html.twig', array(
			'title' => 'Archives',
			'searchTag' => 0,
			'archives' => $archives,
			'archiveSearchForm' => $archiveSearchForm->createView()
	));

})->bind('archives');

// Archive download
$app->match('/download/archive/{idArchive}', function($idArchive) use ($app) {

	$archive = $app['dao.archive']->find($idArchive);
	
	$serializedPdf = $archive->getSerializedPdf();
	
	file_put_contents('temp/dlpdf.pdf', unserialize($serializedPdf));
	
	$file = 'temp/dlpdf.pdf';
	$filename = 'dlpdf.pdf';
	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="' . $filename . '"');
	header('Content-Transfer-Encoding: binary');
	header('Accept-Ranges: bytes');
	@readfile($file);

})->bind('downloadArchive');