<?php
const DEFAULT_APP = 'Frontend';
<<<<<<< HEAD
 
if (!isset($_GET['app']) || !file_exists(dirname(__FILE__).'/../App/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;
=======
>>>>>>> cad0604fbb2db10ccb82ae264c34103e66b0ea8b

if (!isset($_GET['app']) || !file_exists(__DIR__.'\\..\\App\\'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;
 
<<<<<<< HEAD
require dirname(__FILE__).'/../lib/OCFram/SplClassLoader.php';
 
// On va ensuite enregistrer les autoloads correspondant à chaque vendor (OCFram, App, Model, etc.)
$OCFramLoader = new SplClassLoader('OCFram', dirname(__FILE__).'/../lib');
$OCFramLoader->register();
 
$appLoader = new SplClassLoader('App', dirname(__FILE__).'/..');
$appLoader->register();
 
$modelLoader = new SplClassLoader('Model', dirname(__FILE__).'/../lib/vendors');
$modelLoader->register();
 
$entityLoader = new SplClassLoader('Entity', dirname(__FILE__).'/../lib/vendors');
$entityLoader->register();

$employeesLoader = new SplClassLoader('Employees', dirname(__FILE__).'/../App/Frontend/Modules');
$employeesLoader->register();
 
=======
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
>>>>>>> cad0604fbb2db10ccb82ae264c34103e66b0ea8b

//require = ... puis instanciation
$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$app = new $appClass;

$app->run();


