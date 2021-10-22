<?php
const DEFAULT_APP = 'Frontend';

if (!isset($_GET['app']) || !file_exists(__DIR__.'\\..\\App\\'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

require dirname(__FILE__).'/../lib/OCFram/SplClassLoader.php';

$OCFramLoader = new SplClassLoader('OCFram', dirname(__FILE__).'/../lib');
$OCFramLoader->register();
 
$appLoader = new SplClassLoader('App', dirname(__FILE__).'/..');
$appLoader->register();
 
$modelLoader = new SplClassLoader('Model', dirname(__FILE__).'/../App/Backend');
$modelLoader->register();
 
$entityLoader = new SplClassLoader('Entity', dirname(__FILE__).'/../App/Backend');
$entityLoader->register();

$accountLoader = new SplClassLoader('App', dirname(__FILE__).'/..');
$accountLoader->register();

$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$app = new $appClass; 

$app->run();


