<?php
const DEFAULT_APP = 'Frontend';

if (!isset($_GET['app']) || !file_exists(__DIR__.'\\..\\App\\'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;
 
require dirname(__FILE__) . '\\..\\lib\\OCFram\\SplClassLoader.php';
 
//On va ensuite enregistrer les autoloads correspondant à chaque vendor (OCFram, App, Model, etc.)
$OCFramLoader = new SplClassLoader('OCFram', __DIR__.'\\..\\lib');
$OCFramLoader->register();

$appLoader = new SplClassLoader('App', __DIR__.'\\..');
$appLoader->register();
 
$modelLoader = new SplClassLoader('Model', __DIR__.'\\..\\lib\\vendors\\Model');
$modelLoader->register();
 
$entityLoader = new SplClassLoader('Entity', __DIR__.'\\..\\lib\\vendors');
$entityLoader->register();

$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$app = new $appClass;

$app->run();


