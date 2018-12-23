<?php

ini_set('display_errors', 2);

require_once __DIR__.'/vendor/autoload.php';

require_once __DIR__ . '/config.php';

$bdd = new PDO(
    "mysql:host=localhost;
    dbname=".$GLOBALS['bdd']['base'].";
    charset=utf8",
    $GLOBALS['bdd']['login'],
    $GLOBALS['bdd']['mdp']
);

require_once  __DIR__.'/function.php';
require_once  __DIR__.'/crawler_function.php';

