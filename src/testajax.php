<?php
$code = isset($_POST['code']) ? $_POST['code'] : '';

$bdd = new PDO('mysql:host=localhost;dbname=packingsheets;charset=utf8', 'packingsheets_user', 'secret');
$addresses = $bdd->query('select address_id, address_label from t_address where address_codeId = '.$code);
echo var_dump($addresses);