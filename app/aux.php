<?php
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $body = file_get_contents('php://input');
        echo $body['var'];
        break;

    case 'GET':
        $body = file_get_contents('php://input');
        echo $body['var'];
        break;

    case 'PUT':
        $body = file_get_contents('php://input');
        echo $body['var'];
        break;

    case 'DELETE':
        /*$postdata = file_get_contents('php://input');
        $body = json_decode($postdata);
        echo $body->{'var'};*/
        parse_str(file_get_contents("php://input"),$post_vars);
        echo $post_vars['var'];
        break;
}
