<?php
require_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/user.php";

echo json_encode(User::getUserByUsername('mimo3'));
?>