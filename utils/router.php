<?php
require_once $_SERVER['DOCUMENT_ROOT']."/api_v2/app/login.php";
require_once $_SERVER['DOCUMENT_ROOT']."/api_v2/app/users.php";

class Router{
    private $method;
    private $uri;
    private $headersData;
    private $postData;

    function __construct()
    {
        $this->uri = explode('/', $_SERVER['REQUEST_URI']);
        $this->uri = array_values(array_filter($this->uri));

        $this->method = $_SERVER['REQUEST_METHOD'];
        
        $this->headersData = getallheaders();
        $this->postData = $_POST;

        $this->routerSelector();
    }
    
    private function routerSelector(){
        
        switch ($this->uri[1]) {
            case 'login':
                LoginView::loginManager($this->method, $this->uri, $this->headersData, $this->postData);
                break;
            
            case 'users':
                UsersView::usersManager($this->method, $this->uri, $this->headersData, $this->postData);
                break;
            default:
                http_response_code(404);
                echo json_encode(array('error'=>'Not found'));
                break;
        }
    }
}
?>