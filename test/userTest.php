<?php
$_SERVER['DOCUMENT_ROOT'] = '/opt/lampp/htdocs';
require_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/user.php";
//use app\models\User;

class UserModelTest extends \PHPUnit_Framework_TestCase {
    
    private $urlBase = 'localhost:8080/api_v2/app';
    /**
     * checkponit login
     * metodo post
     * funcion login(),
     * parametros obligatorios 'username'/'password',
     * valida las credenciales para hacer inicio de sistema,
     * se espera un token, un id y un username en caso de credenciales validas
     * y un mensaje de error en caso de credenciales invalidas.
    */
    /**
     * valida el funcionamiento correcto del checkpoint 'login' al ingresar credenciales validas
     */
    function test_loginCheckpointOk(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', $this->urlBase.'/login.php', [ 
            'form_params' =>[
                'username'=>'mimo5',
                'password'=>'passwordtest'
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('username', $data);
        
        return $data;
    }

    /**
     * verifica el funcionamiento del checkpoint 'login' al ingresar una contraseña incorrecta
     */
    function test_loginCheckpointNotOkPassword(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', $this->urlBase.'/login.php', [ 
            'http_errors' => false,
            'form_params' =>[
                'username'=>'mimo5',
                'password'=>'asdas'
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(401, $res->getStatusCode());
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Invalid credentials', $data['error']);
    }

    /**
     * verifica el funcionamiento del checkpoint 'login' al usarlo sin parametros
     */
    function test_loginCheckpointNoData(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', $this->urlBase.'/login.php', [
            'http_errors' => false, 
            'form_params' =>[]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(400, $res->getStatusCode());
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('No data', $data['error']);
    }


    /**
     * Checkpoint login
     * metodo get
     * funcion validateSesion()
     * parametro obligatorio token
     * valida la vigencia del token
     * se espera un token en caso de credenciales validas
     * y un mensaje de error en caso de credenciales invalidas.
    */
    /**
     * 
    */
    function test_validateSesionOk(){
        $client = new GuzzleHttp\Client();
        $auxRes = $client->request('POST', $this->urlBase.'/login.php', [ 
            'form_params' =>[
                'username'=>'mimo5',
                'password'=>'passwordtest'
            ]
        ]);
        $auxData=json_decode($auxRes->getBody(), true);

        $res = $client->request('GET', $this->urlBase.'/login.php', [
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('token', $data);
    }

    function test_validateSesionNoData(){
        $client = new GuzzleHttp\Client();
        
        $res = $client->request('GET', $this->urlBase.'/login.php', [
            'http_errors' => false, 
            'headers' => [
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(400, $res->getStatusCode());
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('No data', $data['error']);
    }

    function test_validateSesionBadData(){
        $client = new GuzzleHttp\Client();
        $auxRes = $client->request('POST', $this->urlBase.'/login.php', [ 
            'form_params' =>[
                'username'=>'mimo5',
                'password'=>'passwordtest'
            ]
        ]);
        $auxData=json_decode($auxRes->getBody(), true);

        $res = $client->request('GET', $this->urlBase.'/login.php', [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> 'username'
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(401, $res->getStatusCode());
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Invalid credentials', $data['error']);
    }

    function test_validateSesionExpiredToken(){
        $client = new GuzzleHttp\Client();
        $auxRes = $client->request('POST', $this->urlBase.'/login.php', [ 
            'form_params' =>[
                'username'=>'mimo5',
                'password'=>'passwordtest'
            ]
        ]);
        $auxData=json_decode($auxRes->getBody(), true);

        $res = $client->request('GET', $this->urlBase.'/login.php', [
            'http_errors' => false, 
            'headers' => [
                'token'=> 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MTI0MTc1ODIsImV4cCI6MTYxMjQxODQ4MiwiYXVkIjoiOTAxZTk0YjczMWJmNTVjZTE3YTAxMmY4ZmIyN2QyYzkyMWRlNjlhMSIsImRhdGEiOnsidXNlcm5hbWUiOiJtaW1vNSIsImlkIjo1fX0.iQnxBg9TRgkcG8tQu1Y39GtB9kFkd4GSXAB2SyCGg_w',
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(401, $res->getStatusCode());
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Expired token', $data['error']);
    }
    /*
    verifica el funcionamiento del chekpoint /users/
    function test_getAllUser(){
         
         $client = new GuzzleHttp\Client();
         $res = $client->request()
         $this->assertEquals($res);
        }
        */
    }

?>