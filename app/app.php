<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

// Register services.
$app['dao.packingSheet'] = $app->share(function ($app) {
    $packingSheetDAO = new PackingSheets\DAO\PackingSheetDAO($app['db']);
    $packingSheetDAO->setGroupDAO($app['dao.group']);
    $packingSheetDAO->setConsignedCodeDAO($app['dao.code']);
    $packingSheetDAO->setDeliveryCodeDAO($app['dao.code']);
    $packingSheetDAO->setServiceDAO($app['dao.service']);
    $packingSheetDAO->setContentDAO($app['dao.content']);
    $packingSheetDAO->setPriorityDAO($app['dao.priority']);
    $packingSheetDAO->setShipperDAO($app['dao.shipper']);
    $packingSheetDAO->setAutorityDAO($app['dao.autority']);
    $packingSheetDAO->setCustomStatusDAO($app['dao.customStatus']);
    $packingSheetDAO->setIncotermsTypeDAO($app['dao.incotermsType']);
    $packingSheetDAO->setIncotermsLocationDAO($app['dao.incotermsLocation']);
    $packingSheetDAO->setCurrencyDAO($app['dao.currency']);
    $packingSheetDAO->setImputDAO($app['dao.imput']);
    return $packingSheetDAO;
});

$app['dao.packing'] = $app->share(function ($app) {
    $packingDAO = new PackingSheets\DAO\PackingDAO($app['db']);
    $packingDAO->setPackingSheetDAO($app['dao.packingSheet']);
    $packingDAO->setPackTypeDAO($app['dao.packType']);
    return $packingDAO;
});

$app['dao.packingPart'] = $app->share(function ($app) {
    $packingPartDAO = new PackingSheets\DAO\PackingPartDAO($app['db']);
    $packingPartDAO->setPackingDAO($app['dao.packing']);
    $packingPartDAO->setPartDAO($app['dao.part']);
    return $packingPartDAO;
});

$app['dao.packType'] = $app->share(function ($app) {
    return new PackingSheets\DAO\PackTypeDAO($app['db']);
});

$app['dao.part'] = $app->share(function ($app) {
    return new PackingSheets\DAO\PartDAO($app['db']);
});

$app['dao.shipper'] = $app->share(function ($app) {
    return new PackingSheets\DAO\ShipperDAO($app['db']);
});

$app['dao.code'] = $app->share(function ($app) {
    return new PackingSheets\DAO\CodeDAO($app['db']);
});

$app['dao.autority'] = $app->share(function ($app) {
    return new PackingSheets\DAO\AutorityDAO($app['db']);
});

$app['dao.content'] = $app->share(function ($app) {
    return new PackingSheets\DAO\ContentDAO($app['db']);
});

$app['dao.priority'] = $app->share(function ($app) {
    return new PackingSheets\DAO\PriorityDAO($app['db']);
});

$app['dao.service'] = $app->share(function ($app) {
    return new PackingSheets\DAO\ServiceDAO($app['db']);
});

$app['dao.customStatus'] = $app->share(function ($app) {
    return new PackingSheets\DAO\CustomStatusDAO($app['db']);
});

$app['dao.currency'] = $app->share(function ($app) {
    return new PackingSheets\DAO\CurrencyDAO($app['db']);
});

$app['dao.imput'] = $app->share(function ($app) {
    return new PackingSheets\DAO\ImputDAO($app['db']);
});

$app['dao.group'] = $app->share(function ($app) {
    return new PackingSheets\DAO\GroupDAO($app['db']);
});

$app['dao.incotermsType'] = $app->share(function ($app) {
    return new PackingSheets\DAO\IncotermsTypeDAO($app['db']);
});

$app['dao.incotermsLocation'] = $app->share(function ($app) {
    return new PackingSheets\DAO\IncotermsLocationDAO($app['db']);
});
