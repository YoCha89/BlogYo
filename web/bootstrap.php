<?php
const DEFAULT_APP = 'Frontend';
 
if (!isset($_GET['app']) || !file_exists(dirname(__FILE__).'/../App/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

 
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
 

//require = ... puis instanciation
$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
$app = new $appClass;

$app->run();


