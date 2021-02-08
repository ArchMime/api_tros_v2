<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/utils/headers.php";
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/controllers/user.php";

$headers = getallheaders();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        if (isset($_POST['username']) && isset($_POST['password'])) {
            logIn($_POST);
        } else {
            http_response_code(400);
            echo json_encode(array('error'=>'No data'));
        }
    break;
    case 'GET':
        if (isset($headers['token'])) {
            validateSesion($headers);
        } else {
            http_response_code(400);
            echo json_encode(array('error'=>'No data'));
        }
    break;
}
?>