<?php

// Ajax Routes

//PackingSheet filter addresses by code with Ajax
$app->get('/sheets_ajax_address', function () use ($app) {

	var_dump('test');exit;

	if (isset($_GET["code"])) {
		$code = $_GET['code'];
	} else {
		$code = 1;
	}

	$sql = "SELECT * FROM t_address WHERE address_codeId =" . $code;
	$addresses = $app['db']->fetchAll($sql);

	//return $app['twig']->render('test.html.twig', array('addresses' => $addresses));
	//return $app->json($addresses);
	return $app->json(array('addresses' => $addresses));
})->bind('sheets_ajax_address');

//PackingSheet filter contacts by addresses with Ajax
$app->get('/sheets_ajax_contact', function () use ($app) {

	if (isset($_GET["address"])) {
		$address = $_GET['address'];
	} else {
		$address = 1;
	}

	$sql = "SELECT * FROM t_contact WHERE contact_addressId =" . $address;
	$contacts = $app['db']->fetchAll($sql);

	//return $app['twig']->render('test.html.twig', array('addresses' => $addresses));
	//return $app->json($addresses);
	return $app->json(array('contacts' => $contacts));
})->bind('sheets_ajax_contact');