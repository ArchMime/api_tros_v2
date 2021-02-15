<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/services.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/authjwt.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/subServices.php";


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
    }}