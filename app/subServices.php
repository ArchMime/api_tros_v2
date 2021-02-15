<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/headers.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/subServices.php";

class SubServicesView{
    
    public static function servicesManager($method, $uri, $headersData, $postData){
        switch ($method) {
            case 'GET':
                if (count($uri)==2) {
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