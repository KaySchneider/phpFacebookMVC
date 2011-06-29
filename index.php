<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */
session_start();
require_once 'config/config.php';
require_once 'php/autoloader.php';
$reg = registry::getInstance();
/**
 * Hier rendern der Start und End View
 */
/*if(!$_GET['maintanance'])
    die('Entschuldigung wir sind Offline wegen Wartungsarbeiten');*/

$resolver = new FileSystemCommandResolver('controller', 'startPage');
$controller = new FrontController($resolver);

/**
 * Füge den Event Dispatcher hinzu!!
 * onException => Neues Event einfach in die Datenbank schreiben!
 */
$eventDispatcher = eventDispatcher::getInstance();


$exceptionLogger = new exceptionLogger();

$onUserLogedIn = new onUserLogedIn();

$oncheckUserId = new checkUserIdHandler();
$fbUserGetRights = new getFacebookRights();

//onLogin onDetailView  oncheckUserId onInsertNewAnzeigeHandler

$eventDispatcher->addHandler('onFBUserNoRights', $fbUserGetRights);




$eventDispatcher->addHandler('onException', $exceptionLogger);






$request = new HttpRequest();
$response = new HttpResponse();
/**
 * Add Filter to the controller
 * Post and Pre Filter
 * the first Filter is the DoPage Filter
 * it renders an HTML VIEW!
 */
$cookie = $request->getCookies();
//if(isset($cookie['utmcct']) && $cookie['utmcct'] == '/kleinanzeige/') {
   $layoutFilter = new layoutFilterFB();
   $fbLoginFilter = new facebookUser();
   $controller->addPreFilter($fbLoginFilter);
   $controller->addPreFilter($layoutFilter);
   
//}
//else
  //  $layoutFilter = new layoutFilter();
$loginFilter = new authFilter();



$postLayoutFilter = new postLayoutFilter();
$controller->addPostFilter($postLayoutFilter);


$controller->handleRequest($request, $response);
?>
