<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/services.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/authjwt.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/subServices.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/authjwt.php";


function returnAllServices(){
    try {
        $response = Services::getAllServices();
        $auxArr = [];
        foreach ($response as $key => $value) {
            $auxResp = returnSubServicesByServiceId($value['id']);
            $value['subServices']= $auxResp;
            $auxArr[$key] = $value;
        }
        http_response_code(200);
        echo json_encode(["response" => $auxArr]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}

function returnServiceById($id){
    try {
        $response = Services::getServiceById($id);
        $auxArr = [];
        foreach ($response as $key => $value) {
            $auxResp = returnSubServicesByServiceId($value['id']);
            $value['subServices']= $auxResp;
            $auxArr[$key] = $value;
        }
        http_response_code(200);
        echo json_encode(["response" => $auxArr]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}

function addNewService($credentialData, $postData){
    try {
        $token = Authjwt::Check($credentialData['token']);
        $response = Services::createNewService($postData);
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}

function removeService($credentialData, $id){
    try {
        $token = Authjwt::Check($credentialData['token']);
        $response = Services::deleteService($id);
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}