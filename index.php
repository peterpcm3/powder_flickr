<?php

include 'autoload.php';

define('DEFAULT_CONTROLLER', 'List');
define('DEFAULT_ACTION', 'index');
define('FEED_TYPE', 'json');
define('TEMPLATE_DIR', __DIR__ . '/App/View/templates/');

try
{
    $controller = isset($_GET['controller'])  ? $_GET['controller'] : '';
    $action     = isset($_GET['action']) ? $_GET['action'] : '';
    
    if($controller === '')
    {
        $controller = constant('DEFAULT_CONTROLLER');
    }
    
    if($action === '')
    {
        $action = constant('DEFAULT_ACTION');
    }
    
    $controller = ucfirst( $controller ) . 'Controller';
    $action     = $action . 'Action';
    
    if( class_exists( $controller ) )
    {
        throw new \Exception('Controller class doesnt exist', 5);
    }
    
    $controller = 'App\Controller\\'.$controller;
    $controller = new $controller();
    
    if( ! method_exists( $controller, $action ) )
    {
        throw new \Exception('Action method doesnt exist', 6);
    }
    
    call_user_func_array(array($controller, $action), array());
}
catch( \Exception $e )
{
    $message    = $e->getMessage() . ':' . $e->getCode() . "\r\n";
    error_log($message, 3, __DIR__ . '/Log/error.log');
    error_log($e->getTraceAsString(), 3, __DIR__ . '/Log/error.log');
    print_r('Error occured');
}