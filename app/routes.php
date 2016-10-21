<?php
use Symfony\Component\HttpFoundation\Request;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// PackingSheets list page
$app->get('/sheets', function () use ($app) {
  $packingSheets = $app['dao.packingSheet']->findAll();
  $codes = $app['dao.code']->findAll();
  $inputs = $app['dao.imput']->findAll();
  return $app['twig']->render('packingSheet.html.twig', array('packingSheets' => $packingSheets, 'codes' => $codes, 'inputs' => $inputs));
})->bind('sheets');

// Parts list page
$app->get('/parts', function () use ($app) {
    $parts = $app['dao.part']->findAll();
    return $app['twig']->render('parts.html.twig', array('parts' => $parts));
})->bind('parts');

// Contacts list page
$app->get('/contacts', function () use ($app) {
    $contacts = $app['dao.contact']->findAll();
    $addresses = $app['dao.address']->findAll();
    $codes = $app['dao.code']->findAll();
    return $app['twig']->render('contacts.html.twig', array('contacts' => $contacts, 'addresses' => $addresses, 'codes' => $codes));
})->bind('contacts');

// PackingSheet details with Packings and detailed parts
$app->get('/sheets/{id}', function ($id) use ($app) {
    $packingSheet = $app['dao.packingSheet']->find($id);
    $packings = $app['dao.packing']->findAllByPackingSheet($id);
    $packingParts = $app['dao.packingPart']->findAll();
    $parts = $app['dao.part']->findAll();
    return $app['twig']->render('packingSheetDetails.html.twig', array('packingSheet' => $packingSheet, 'packings' => $packings, 'packingParts'=> $packingParts, 'parts'=>$parts));
})->bind('sheetDetails');


// Logout
$app->get('/auth/logout',function () use ($app) {
    //return $app['twig']->render('auth/login.html.twig');
    return;
})->bind('logout');

//PackingSheet Search
$app->post('/search_packingsheets', function () use ($app) {
  $packingSheets = $app['dao.packingSheet']->findBySearch();
  $codes = $app['dao.code']->findAll();
  $inputs = $app['dao.imput']->findAll();
  return $app['twig']->render('packingSheet.html.twig', array('packingSheets' => $packingSheets, 'codes' => $codes, 'inputs' => $inputs));
})->bind('searchSheets');


//PackingSheet filter addresses by code with Ajax
$app->get('/sheets_ajax_address', function () use ($app) {
    
    if(isset($_GET["code"])){
        $code = $_GET['code'];
    }
    else {
        $code = 1;
    }
    
    $sql = "SELECT * FROM t_address WHERE address_codeId =".$code;
    $addresses = $app['db']->fetchAll($sql);
    
    //return $app['twig']->render('test.html.twig', array('addresses' => $addresses));
    
    //return $app->json($addresses);
    return $app->json(array('addresses' => $addresses));
    
})->bind('sheets_ajax_address'); 

//PackingSheet filter contacts by addresses with Ajax
$app->get('/sheets_ajax_contact', function () use ($app) {
    
    if(isset($_GET["address"])){
        $address = $_GET['address'];
    }
    else {
        $address = 1;
    }
    
    $sql = "SELECT * FROM t_contact WHERE contact_addressId =".$address;
    $contacts = $app['db']->fetchAll($sql);
    
    //return $app['twig']->render('test.html.twig', array('addresses' => $addresses));
    
    //return $app->json($addresses);
    return $app->json(array('contacts' => $contacts));
    
})->bind('sheets_ajax_contact'); 