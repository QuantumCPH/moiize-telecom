<?php
var_dump($_SERVER);
die;
if($_SERVER['HTTP_HOST']!="localhost" &&$_SERVER['HTTP_HOST']=="moiize.com"&&$_SERVER['REQUEST_URI']=="backend.php" ){
Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: http://admin.moiize.com" );

}


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('backend', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
