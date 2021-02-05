<?php
include_once $_SERVER['DOCUMENT_ROOT']."/api_v2/models/dbConnection.php";

class User{
    
    public static function getUserForLogin($username)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT * FROM `usersweb` WHERE username = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 's', $username);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $username, $userpass);
            while (mysqli_stmt_fetch($result)) {
                $userArray = array(
                    "username" => $username,
                    "userpass" => $userpass,
                    "id" => $id
                );
            }
            if (isset($userArray)) {
                return $userArray;
            }
        }
    }

    public static function getAllUsers(){
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT `id`, `username` FROM `usersweb`";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $username);
            $usersArray = array();
            while (mysqli_stmt_fetch($result)) {
                $auxArr = array(
                    "username" => $username,
                    "id" => $id
                );
                array_push($usersArray, $auxArr);
            }
            return $usersArray;
        }
    }

}

?>