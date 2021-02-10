<?php
//run test: ./vendor/bin/phpunit
$_SERVER['DOCUMENT_ROOT'] = '/opt/lampp/htdocs';
require_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/user.php";

class UserModelTest extends \PHPUnit_Framework_TestCase {
    
    private $urlBase = 'localhost:8080/api_v2';
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
        $res = $client->request('POST', $this->urlBase.'/login', [ 
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
        $res = $client->request('POST', $this->urlBase.'/login', [ 
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
        $res = $client->request('POST', $this->urlBase.'/login', [
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
     * @depends test_loginCheckpointOk
     */
    function test_validateSesionOk($auxData){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/login', [
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
        
        $res = $client->request('GET', $this->urlBase.'/login', [
            'http_errors' => false, 
            'headers' => [
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        $this->assertEquals(400, $res->getStatusCode());
        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('No data', $data['error']);
    }
    /**
     *      
     * @depends test_loginCheckpointOk
     */
    function test_validateSesionBadData($auxData){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/login', [
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

    /**
     *      
     * @depends test_loginCheckpointOk
     */
    function test_validateSesionExpiredToken($auxData){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/login', [
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

    /**
     * verifica el funcionamiento del chekpoint /users/
     * metodo get
     * se espera un nuevo token y una lista de usersname/id de los usuarios
     * @depends test_loginCheckpointOk
    */
    function test_getAllUserOk($auxData){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/users', [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ]
        ]);

        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('newtoken', $data);
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('username', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
    }

    /**
     * metodo get
     * se espera un nuevo token y un los datos de un usuario especifico
     * @depends test_loginCheckpointOk
    */
    function test_getUserByIdOk($auxData){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/users/2', [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ]
        ]);

        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('newtoken', $data);
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('username', $data['response']);
        $this->assertArrayHasKey('id', $data['response']);
    }

    /**
     * method post
     * @depends test_loginCheckpointOk
     */
    function test_postNewUser($auxData){
        $username = "username" . rand(0,255) . "rand" . rand(0,255);
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', $this->urlBase.'/users', [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ], 
            'form_params' =>[
                'username'=>$username,
                'password'=>'passwordtest',
                'email' => $username.'@mail.com',
                'admin'=>'0'
            ]
        ]);

        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('newtoken', $data);
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('message', $data['response']);
        $this->assertEquals('success', $data['response']['message']);
        $this->assertArrayHasKey('insert', $data['response']);
        //$this->assertEquals('44', $data['response']['insert']);

        //eliminar los usuarios test para no llenar la bd
        $client->request('DELETE', $this->urlBase.'/users/'.$data['response']['insert'], [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ]
        ]);
    }

    /**
     * delete metohd
     * @depends test_loginCheckpointOk
     */
    function test_deleteUser($auxData){
        $username = "username" . rand(0,255) . "rand" . rand(0,255);
        $client = new GuzzleHttp\Client();
        $auxRes = $client->request('POST', $this->urlBase.'/users', [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ], 
            'form_params' =>[
                'username'=>$username,
                'password'=>'passwordtest',
                'email' => $username.'@mail.com',
                'admin'=>'0'
            ]
        ]);

        $deleteData = json_decode($auxRes->getBody(), true);

        $res = $client->request('DELETE', $this->urlBase.'/users/'.$deleteData['response']['insert'], [
            'http_errors' => false, 
            'headers' => [
                'token'=> $auxData['token'],
                'id'=> $auxData['id'],
                'username'=> $auxData['username']
            ]
        ]);

        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('newtoken', $data);
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('message', $data['response']);
        $this->assertEquals('success', $data['response']['message']);
    }
    
}
?>