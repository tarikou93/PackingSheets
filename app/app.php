<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;


//use Silex\Provider;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.

$app->register(new Silex\Provider\RoutingServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new FormServiceProvider());
$app->extend('twig', function($twig) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
$app->register(new ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
      'locale' => 'en',
      'translation.class_path' =>  __DIR__ . '/../vendor/symfony/src',
      'translator.messages' => array()
)) ;

$app->register(new Silex\Provider\AssetServiceProvider(), array(
		'assets.version' => 'v1',
		'assets.version_format' => '%s?version=%s',
		'assets.named_packages' => array(
				'css' => array('version' => 'css2', 'base_path' => '/css/'),
				'images' => array('base_path' => '/img/'),
		),
));

$app['auth.ldap.options'] =
          array(
            'host'                  => '172.30.40.190',
            'bindRequiresDn'        => false,
            'baseDn'                => 'OU=Users,OU=BRU,DC=company,DC=corp',
            'accountDomainName'     => 'company.corp',
          );

$app['auth.template.login'] = 'auth/login.html.twig';

$app->mount('/auth', new Silex\Provider\LdapAuthControllerProvider());

$app['dao.packingSheet'] = function($app) {
  $packingSheetDAO = new PackingSheets\DAO\PackingSheetDAO($app['db']);
  $packingSheetDAO->setConsignedAddressDAO($app['dao.address']);
  $packingSheetDAO->setDeliveryAddressDAO($app['dao.address']);
  $packingSheetDAO->setConsignedContactDAO($app['dao.contact']);
  $packingSheetDAO->setDeliveryContactDAO($app['dao.contact']);
  $packingSheetDAO->setServiceDAO($app['dao.service']);
  $packingSheetDAO->setContentDAO($app['dao.content']);
  $packingSheetDAO->setPriorityDAO($app['dao.priority']);
  $packingSheetDAO->setShipperDAO($app['dao.shipper']);
  $packingSheetDAO->setCustomStatusDAO($app['dao.customStatus']);
  $packingSheetDAO->setIncotermsTypeDAO($app['dao.incotermsType']);
  $packingSheetDAO->setIncotermsLocationDAO($app['dao.incotermsLocation']);
  $packingSheetDAO->setCurrencyDAO($app['dao.currency']);
  $packingSheetDAO->setImputDAO($app['dao.imput']);
  $packingSheetDAO->setPackingDAO($app['dao.packing']);
  $packingSheetDAO->setPackingListDAO($app['dao.packingList']);

  return $packingSheetDAO;
};

$app['dao.packing'] = function($app) {
  $packingDAO = new PackingSheets\DAO\PackingDAO($app['db']);
  $packingDAO->setPackingPartDAO($app['dao.packingPart']);
  $packingDAO->setPackTypeDAO($app['dao.packType']);
  return $packingDAO;
};

$app['dao.packingPart'] = function($app) {
  $packingPartDAO = new PackingSheets\DAO\PackingPartDAO($app['db']);
  $packingPartDAO->setPartDAO($app['dao.part']);
  return $packingPartDAO;
};

$app['dao.packingList'] = function($app) {
	$packingListDAO = new PackingSheets\DAO\PackingListDAO($app['db']);
	$packingListDAO->setPackingListPartDAO($app['dao.packingListPart']);
	return $packingListDAO;
};

$app['dao.packingListPart'] = function($app) {
	$packingListPartDAO = new PackingSheets\DAO\PackingListPartDAO($app['db']);
	$packingListPartDAO->setPartDAO($app['dao.part']);
	return $packingListPartDAO;
};

$app['dao.packingAssignation'] = function($app) {
	$packingAssignationDAO = new PackingSheets\DAO\PackingAssignationDAO($app['db']);
	$packingAssignationDAO->setPackingListPartDAO($app['dao.packingListPart']);
	$packingAssignationDAO->setPackingPartDAO($app['dao.packingPart']);
	return $packingAssignationDAO;
};

$app['dao.packType'] = function($app) {
  return new PackingSheets\DAO\PackTypeDAO($app['db']);
};

$app['dao.part'] = function($app) {
  return new PackingSheets\DAO\PartDAO($app['db']);
};

$app['dao.shipper'] = function($app) {
  return new PackingSheets\DAO\ShipperDAO($app['db']);
};

$app['dao.code'] = function ($app) {
    $codeDAO = new PackingSheets\DAO\CodeDAO($app['db']);
    $codeDAO->setAddressDAO($app['dao.address']);
    return $codeDAO;
};

$app['dao.address'] = function($app) {
  $addressDAO = new PackingSheets\DAO\AddressDAO($app['db']);
  $addressDAO->setContactDAO($app['dao.contact']);
  return $addressDAO;
};

$app['dao.contact'] = function($app) {
  return new PackingSheets\DAO\ContactDAO($app['db']);
};

$app['dao.content'] = function ($app) {
    return new PackingSheets\DAO\ContentDAO($app['db']);
};

$app['dao.memo'] = function ($app) {
	return new PackingSheets\DAO\MemoDAO($app['db']);
};

$app['dao.priority'] = function ($app) {
    return new PackingSheets\DAO\PriorityDAO($app['db']);
};

$app['dao.service'] = function ($app) {
    return new PackingSheets\DAO\ServiceDAO($app['db']);
};

$app['dao.customStatus'] = function ($app) {
    return new PackingSheets\DAO\CustomStatusDAO($app['db']);
};

$app['dao.currency'] = function ($app) {
    return new PackingSheets\DAO\CurrencyDAO($app['db']);
};

$app['dao.header'] = function ($app) {
	return new PackingSheets\DAO\HeaderDAO($app['db']);
};

$app['dao.footer'] = function ($app) {
	return new PackingSheets\DAO\FooterDAO($app['db']);
};

$app['dao.imput'] = function ($app) {
    return new PackingSheets\DAO\ImputDAO($app['db']);
};

$app['dao.incotermsType'] = function ($app) {
    return new PackingSheets\DAO\IncotermsTypeDAO($app['db']);
};

$app['dao.incotermsLocation'] = function ($app) {
    return new PackingSheets\DAO\IncotermsLocationDAO($app['db']);
};
