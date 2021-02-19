<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/headers.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/subServices.php";

class SubServicesView{
    
    public static function servicesManager($method, $uri, $headersData, $postData){
        switch ($method) {
            case 'GET':
                if (count($uri)==4 && $uri[3]=='subservices') {
                    http_response_code(200);
                    echo json_encode(["response" =>returnSubServicesByServiceId($uri[2])]);
                } elseif (count($uri)==5 && $uri[3]=='subservices') {
                    http_response_code(200);
                    returnSubServiceById($uri[4]);
                } else {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                }
                break;
            case 'POST':
                if (count($uri)==4 && $uri[3]=='subservices') {
                    http_response_code(200);
                    addNewSubService($headersData, $postData, $uri[2]);
                } else {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                }
                break;
            case 'DELETE':
                if (count($uri)==5 && $uri[3]=='subservices') {
                    http_response_code(200);
                    removeSubService($headersData, $uri[4]);
                } else {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                }
                break;
            default:
                # code...
                break;
        }
    }
}
?>