<?php
use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// PackingSheets list page
$app->get('/sheets', function () use ($app) {
  $packingSheets = $app['dao.packingSheet']->findAll();
  return $app['twig']->render('packingSheet.html.twig', array('packingSheets' => $packingSheets));
})->bind('sheets');

// Parts list page
$app->get('/parts', function () use ($app) {
    $parts = $app['dao.part']->findAll();
    return $app['twig']->render('parts.html.twig', array('parts' => $parts));
})->bind('parts');

// PackingSheet details with Packings and detailed parts
$app->get('/sheets/{id}', function ($id) use ($app) {
    $packingSheet = $app['dao.packingSheet']->find($id);
    $packings = $app['dao.packing']->findAllByPackingSheet($id);
    $packingParts = $app['dao.packingPart']->findAll();
    $parts = $app['dao.part']->findAll();
    return $app['twig']->render('packingSheetDetails.html.twig', array('packingSheet' => $packingSheet, 'packings' => $packings, 'packingParts'=> $packingParts, 'parts'=>$parts));
})->bind('sheetDetails');

// Login form
$app->get('/auth/login',function () use ($app) {
    return $app['twig']->render('auth/login.html.twig');
})->bind('login2');
