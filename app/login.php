<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/login.php";

class LoginView{


    public static function loginManager($method, $uri, $headersData, $postData){

        switch ($method) {
            case 'POST':
                if (isset($postData['username']) && isset($postData['password'])) {
                    logIn($postData);
                } else {
                    http_response_code(400);
                    echo json_encode(array('error'=>'No data'));
                }
            break;
            case 'GET':
                if (isset($headersData['username']) && isset($headersData['token']) && isset($headersData['id'])) {
                    validateSesion($headersData);
                } else {
                    http_response_code(400);
                    echo json_encode(array('error'=>'No data'));
                }
            break;
        
        }
    }

}

?>