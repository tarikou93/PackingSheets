<?php

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// PackingSheets list page
$app->get('/sheets', function () use ($app) {
  $packingSheets = $app['dao.packingSheet']->findAll();
  return $app['twig']->render('packingsheet.html.twig', array('packingSheets' => $packingSheets));
})->bind('sheets');

// Parts list page
$app->get('/parts', function () use ($app) {
    $parts = $app['dao.part']->findAll();
    return $app['twig']->render('parts.html.twig', array('parts' => $parts));
})->bind('parts');

// PackingSheet details with packings
$app->get('/sheets/{id}', function ($id) use ($app) {
    $packingSheet = $app['dao.packingSheet']->find($id);
    $packings = $app['dao.packing']->findAllByPackingSheet($id);
    return $app['twig']->render('packingSheetDetails.html.twig', array('packingSheet' => $packingSheet, 'packings' => $packings));
})->bind('sheetDetails');

// PackingSheet details with Packings and detailed parts
$app->get('/sheets/{idSheet}/{idPack}', function ($idSheet, $idPack) use ($app) {
    $packingSheet = $app['dao.packingSheet']->find($idSheet);
    $packings = $app['dao.packing']->findAllByPackingSheet($idSheet);
    $packingParts = $app['dao.packingPart']->findAllByPacking($idPack);
    $parts = $app['dao.part']->findAll();
    $idPacking = $idPack;
    return $app['twig']->render('packingSheetDetailsParts.html.twig', array('packingSheet' => $packingSheet, 'packings' => $packings, 'packingParts'=> $packingParts, 'parts'=>$parts, 'idPacking'=>$idPacking));
})->bind('sheetDetailsParts');
