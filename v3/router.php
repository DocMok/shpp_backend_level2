<?php
require_once 'headers.php';
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

new Router();

class Router
{
    private static array $actions = array('login',
        'logout',
        'register',
        'addItem',
        'changeItem',
        'getItems',
        'deleteItem');

    public function __construct()
    {
        $action = $_GET['action'];
        if (in_array($action, self::$actions)) {
            require_once "$action.php";
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(array("error" => "404"));
        }
    }
}