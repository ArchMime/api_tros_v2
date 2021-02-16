<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/subServices.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/authjwt.php";

function returnSubServicesByServiceId($id){
    try {
        $response = SubServices::getSubServicesByServiceId($id);
        http_response_code(200);
        return  $response;
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}

function returnSubServiceById($id){
    try {
        $response = SubServices::getSubServiceById($id);
        http_response_code(200);
        echo json_encode(["response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}