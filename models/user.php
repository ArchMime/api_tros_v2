<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/api_v2/utils/dbConnection.php";

class User
{
    public static function getUserForLogin($username)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT * FROM `usersweb` WHERE username = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 's', $username);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $username, $userpass, $email, $admin);
            while (mysqli_stmt_fetch($result)) {
                $userArray = array(
                    "username" => $username,
                    "userpass" => $userpass,
                    "email" => $email,
                    "id" => $id,
                    "admin" => $admin,
                );
            }
            if (isset($userArray)) {
                return $userArray;
            }
        }
    }

    public static function getAllUsers()
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT `id`, `username`, `email`, `admin` FROM `usersweb`";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $username, $email, $admin);
            $usersArray = array();
            while (mysqli_stmt_fetch($result)) {
                $auxArr = array(
                    "username" => $username,
                    "email" => $email,
                    "id" => $id,
                    "admin" => $admin,
                );
                array_push($usersArray, $auxArr);
            }
            return $usersArray;
        }
    }

    public static function getUserById($id)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT `id`, `username`, `email`, `admin` FROM `usersweb` WHERE id = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 's', $id);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $username, $email, $admin);
            while (mysqli_stmt_fetch($result)) {
                $userArray = array(
                    "username" => $username,
                    "email" => $email,
                    "id" => $id,
                    "admin" => $admin,
                );
            }
            if (isset($userArray)) {
                return $userArray;
            }
        }
    }

    public static function createUser($data)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "INSERT INTO `usersweb`(`id`, `username`, `userpass`, `email`, `admin`) VALUES (null,?,?,?,?)
        ";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'sssi', $data['username'], $data['password'], $data['email'], $data['admin']);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            return array("message" => "success", "insert"=>mysqli_insert_id($conn));
        } else {
            return array("error" => mysqli_error($conn));
        }
    }

    public static function deleteUserById($id)
    {
        $response = User::getUserById($id);
        if (!isset($response['username'])) {
            return array("message" => "user not found");
        } else {
            $conexion = new DbConnection;
            $conn = $conexion->get_connection();
            $stm = "DELETE FROM `usersweb` WHERE id = ?";
            $result = mysqli_prepare($conn, $stm);
            $validate = mysqli_stmt_bind_param($result, 'i', $id);
            $validate = mysqli_stmt_execute($result);
            if ($validate) {
                return array("message" => "success");
            } else {
                return array("error" => mysqli_error($conn));
            }
        }
    }
}
?>