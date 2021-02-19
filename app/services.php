<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/headers.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/services.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/app/subServices.php";

class ServicesView{
    public static function servicesManager($method, $uri, $headersData, $postData){
        switch ($method) {
            case 'GET':
                if (count($uri)==2) {
                    returnAllServices();
                } elseif(count($uri)==3){
                    returnServiceById($uri[2]);
                }  elseif(count($uri)>=4 && $uri[3]=='subservices'){
                    SubServicesView::servicesManager($method, $uri, $headersData, $postData);
                } else {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                }
                break;
            case 'POST':
                if (count($uri)==2) {
                    addNewService($headersData, $postData);
                }  elseif(count($uri)>=4 && $uri[3]=='subservices'){
                    SubServicesView::servicesManager($method, $uri, $headersData, $postData);
                } else {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                }
                break;
            case 'DELETE':
                if (count($uri)==3) {
                    removeService($headersData, $uri[2]);
                }  elseif(count($uri)>=4 && $uri[3]=='subservices'){
                    SubServicesView::servicesManager($method, $uri, $headersData, $postData);
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