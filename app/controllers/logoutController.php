<?php

// Logout
$app->get('/auth/logout', function () use ($app) {
	//return $app['twig']->render('auth/login.html.twig');
	return;
})->bind('logout');