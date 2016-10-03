<?php

// Return all PackingSheets
function getPackingSheets() {
    $bdd = new PDO('mysql:host=localhost;dbname=packingsheets;charset=utf8', 'packingsheets_user', 'secret');
    $packingSheets = $bdd->query('select * from t_packingsheet order by ps_id desc');
    return $packingSheets;
}
