<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/subServices.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/authjwt.php";

function returnSubServicesByServiceId($id){
    try {
        $response = SubServices::getSubServicesByServiceId($id);
        http_response_code(200);
        return  $response;
    }  catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
}

function returnSubServiceById($id){
    try {
        $response = SubServices::getSubServiceById($id);
        http_response_code(200);
        echo json_encode(["response" => $response]);
    }  catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
}

function addNewSubService($credentialData, $postData, $serviceId){
    try {
        $token = Authjwt::Check($credentialData['token']);
        $response = SubServices::createNewSubService($postData, $serviceId);
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
}

function removeSubService($credentialData, $serviceId){
    try {
        $token = Authjwt::Check($credentialData['token']);
        $response = SubServices::deleteSubService($serviceId);
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        echo json_encode(array('error' => $e->getMessage()));
    }
}

