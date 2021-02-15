<?php
//run test: ./vendor/bin/phpunit
$_SERVER['DOCUMENT_ROOT'] = '/opt/lampp/htdocs';

class servicesTest extends \PHPUnit_Framework_TestCase {
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

    function test_getAllServicesOk(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/services', [
            'http_errors' => false
        ]);

        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('name', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
        $this->assertArrayHasKey('subServices', $data['response'][0]);
    }

    function test_getAllServicesByIdOk(){
        $client = new GuzzleHttp\Client();
        $res = $client->request('GET', $this->urlBase.'/services/1', [
            'http_errors' => false
        ]);

        $data=json_decode($res->getBody(), true);
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertArrayHasKey('response', $data);
        $this->assertArrayHasKey('name', $data['response'][0]);
        $this->assertArrayHasKey('id', $data['response'][0]);
        $this->assertArrayHasKey('subServices', $data['response'][0]);
    }
}