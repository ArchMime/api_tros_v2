<?php
//run test: ./vendor/bin/phpunit
$_SERVER['DOCUMENT_ROOT'] = '/opt/lampp/htdocs';

class servicesTest extends \PHPUnit_Framework_TestCase
{
    private $urlBase = 'localhost:8080/api_v2';
    /*
    function loginOk(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('POST', $this->urlBase.'/login', [ 
            'form_params' =>[
                'username'=>'mimo5',
                'password'=>'passwordtest'
            ]
        ]);
        $data=json_decode($res->getBody(), true);
        
        return $data;
    }*/

    function test_getAllServicesOk()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase . '/services', [
            'http_errors' => false
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('name', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
        $this->assertArrayHasKey('subServices', $data['response'][0]);
    }

    function test_getAllServicesByIdOk()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase . '/services/1', [
            'http_errors' => false
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('name', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
        $this->assertArrayHasKey('subServices', $data['response'][0]);
    }

    function test_getAllSubservicesOfServiceOk()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase . '/services/1/subservices', [
            'http_errors' => false
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('name', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
        $this->assertArrayHasKey('service', $data['response'][0]);
    }

    function test_getSubservicesOfServiceByIdOk()
    {
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase . '/services/1/subservices/1', [
            'http_errors' => false
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('name', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
        $this->assertArrayHasKey('service', $data['response'][0]);
    }

    function test_postNewServiceOk()
    {
        $client = new GuzzleHttp\Client();

        $loginRes = $client->request('POST', $this->urlBase . '/login', [
            'form_params' => [
                'username' => 'mimo5',
                'password' => 'passwordtest'
            ]
        ]);
        $loginData = json_decode($loginRes->getBody(), true);

        $res = $client->request('POST', $this->urlBase . '/services', [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ],
            'form_params' => [
                'name' => 'new servicesTest',
                'description' => 'description test',
                'value' => '123'
            ]
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('message', $data['response']);
        $this->assertEquals('success', $data['response']['message']);
        $this->assertArrayHasKey('insert', $data['response']);

        $res = $client->request('DELETE', $this->urlBase . '/services/' . $data['response']['insert'], [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ]
        ]);
    }

    function test_deleteServiceOk()
    {
        $client = new GuzzleHttp\Client();

        $loginRes = $client->request('POST', $this->urlBase . '/login', [
            'form_params' => [
                'username' => 'mimo5',
                'password' => 'passwordtest'
            ]
        ]);
        $loginData = json_decode($loginRes->getBody(), true);

        $serviceData = $client->request('POST', $this->urlBase . '/services', [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ],
            'form_params' => [
                'name' => 'delete services test',
                'description' => 'description test',
                'value' => '123'
            ]
        ]);


        $auxData = json_decode($serviceData->getBody(), true);

        $res = $client->request('DELETE', $this->urlBase . '/services/' . $auxData['response']['insert'], [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ]
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('newtoken', $data);
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('message', $data['response']);
        $this->assertEquals('success', $data['response']['message']);
    }

    function test_deleteSubServiceOk()
    {
        $client = new GuzzleHttp\Client();

        $loginRes = $client->request('POST', $this->urlBase . '/login', [
            'form_params' => [
                'username' => 'mimo5',
                'password' => 'passwordtest'
            ]
        ]);
        $loginData = json_decode($loginRes->getBody(), true);

        $serviceData = $client->request('POST', $this->urlBase . '/services', [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ],
            'form_params' => [
                'name' => 'delete services test',
                'description' => 'description test',
                'value' => '123'
            ]
        ]);

        $auxServiceData = json_decode($serviceData->getBody(), true);

        $subServiceData = $client->request('POST', $this->urlBase . '/services/' . $auxServiceData['response']['insert'].'/subservices', [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ],
            'form_params' => [
                'name' => 'delete services test',
                'description' => 'description test',
                'value' => '123'
            ]
        ]);

        $auxSubServiceData = json_decode($subServiceData->getBody(), true);

        $res = $client->request('DELETE', $this->urlBase . '/services/' . $auxServiceData['response']['insert'] . '/subservices/' . $auxSubServiceData['response']['insert'], [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ]
        ]);

        $data = json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('newtoken', $data);
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('message', $data['response']);
        $this->assertEquals('success', $data['response']['message']);


        $client->request('DELETE', $this->urlBase . '/services/' . $auxServiceData['response']['insert'], [
            'http_errors' => false,
            'headers' => [
                'token' => $loginData['token'],
                'id' => $loginData['id'],
                'username' => $loginData['username']
            ]
        ]);
    }
}
