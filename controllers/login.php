<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/user.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/authjwt.php";

function logIn($data){
    try {
        $user = User::getUserForLogin($data['username']);
        if (!empty($user['userpass']) && password_verify($data['password'], $user['userpass'])){
            $auxArr = array('token' => Authjwt::createToken($user['username'], $user['id']), 'username'=>$user['username'], 'id'=>$user['id']);
            http_response_code(200);
            echo json_encode($auxArr);
        } else {
            throw new Exception('Invalid credentials');
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array('error' => $e->getMessage()));
    }
}

function validateSesion($data){
    try {
        $user = User::getUserForLogin($data['username']);
        if (!empty($user['id']) && $user['id'] == $data['id']){
            $auxArr = array('token' => Authjwt::ValidateData($data['token'],$data['id'],$data['username']));
            http_response_code(200);
            echo json_encode($auxArr);
        } else {
            throw new Exception('Invalid credentials');
        }
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array('error' => $e->getMessage()));
    }
}

?>