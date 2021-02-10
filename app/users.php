<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/headers.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/user.php";

class UsersView{

    public static function usersManager($method, $uri, $headersData, $postData){

        switch ($method) {
            case 'POST':
                if (!isset($headersData['token'])) {
                    http_response_code(401);
                    return json_encode(array('error'=>'unauthorized'));
                } 
                if (count($uri)>2) {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                } elseif (count($uri)==2) {
                    addNewUser($headersData, $postData);
                }
            break;
            case 'GET':
                if (!isset($headersData['token'])) {
                    http_response_code(401);
                    return json_encode(array('error'=>'Unauthorized'));
                }
                if (count($uri)>3){
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                } elseif (count($uri)==3) {
                    returnOneUsers($headersData, $uri[2]);
                } else {
                    returnAllUsers($headersData);
                }
            break;
            case 'DELETE':
                if (count($uri)==3){
                    deleteUser($headersData, $uri[2]);
                } else {
                    http_response_code(404);
                    echo json_encode(array('error'=>'No found'));
                }
            break;
        }
    }
}
?>