<?php
const DEFAULT_APP = 'Frontend';

if (!isset($_GET['app']) || !file_exists(__DIR__.'\\..\\App\\'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;
 
require dirname(__FILE__) . '\\..\\lib\\OCFram\\SplClassLoader.php';

$OCFramLoader = new SplClassLoader('OCFram', __DIR__.'\\..\\lib');
$OCFramLoader->register();

$appLoader = new SplClassLoader('App', __DIR__.'\\..');
$appLoader->register();

$modelLoader = new SplClassLoader('Model',  __DIR__.'\\..\\App\\Backend\\Model');
$modelLoader->register();

$entityLoader = new SplClassLoader('Entity', __DIR__.'\\..\\App\\Entity');
$entityLoader->register();

$accountLoader = new SplClassLoader('Account', __DIR__.'\\..\\App\\Frontend\\Modules\\Account');
$accountLoader->register();

/*$OCFramLoader = new SplClassLoader('OCFram', __DIR__.'\\oie\\..\\lib');
$OCFramLoader->register();

$appLoader = new SplClassLoader('App', __DIR__.'\\oia\\..');
$appLoader->register();

$modelLoader = new SplClassLoader('Model',  __DIR__.'\\oib\\..\\App\\Backend\\Model');
$modelLoader->register();

$entityLoader = new SplClassLoader('Entity', __DIR__.'\\oic\\..\\App\\Entity');
$entityLoader->register();

$accountLoader = new SplClassLoader('Account', __DIR__.'\\oid\\..\\App\\Frontend\\Modules\\Account');
$accountLoader->register();*/

$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$app = new $appClass;

$app->run();


