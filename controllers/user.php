<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/user.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/authjwt.php";

function returnAllUsers($credentialData){
    try {
        $token = Authjwt::Check($credentialData['token']);
        $response = User::getAllUsers();
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}
function returnOneUsers($credentialData, $id){
    try {
        $token = Authjwt::Check($credentialData['token']);
        $response = User::getUserById($id);
        if(!$response){
            $response['message'] = 'user not found'; 
        }
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}

function addNewUser($credentialData, $postData){
    try {
        $adminResponse = User::getUserById($credentialData['id']);
        if(!$adminResponse['admin']){
            http_response_code(401);
            throw new Exception('Unauthorized');
        }
        $token = Authjwt::Check($credentialData['token']);
        $response = User::createUser($postData);
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}
function deleteUser($credentialData, $id){
    try {
        $adminResponse = User::getUserById($credentialData['id']);
        if(!$adminResponse['admin']){
            http_response_code(401);
            throw new Exception('Unauthorized');
        }
        $token = Authjwt::Check($credentialData['token']);
        $response = User::deleteUserById($id);
        http_response_code(200);
        echo json_encode(["newtoken" => $token, "response" => $response]);
    }  catch (Exception $e) {
        $auxArr = array('error' => $e->getMessage());
        echo json_encode($auxArr);
    }
}
?>