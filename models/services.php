<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/api_v2/utils/dbConnection.php";

class Services
{
    public static function getAllServices()
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT * FROM `services`";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $name, $description, $value);
            $servicesArray = array();
            while (mysqli_stmt_fetch($result)) {
                $auxArr = array(
                    "id" => $id,
                    "name" => $name,
                    "description" => $description,
                    "value" => $value
                );
                array_push($servicesArray, $auxArr);
            }
            return $servicesArray;
        }
    }
    public static function getServiceById($id)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT * FROM `services` WHERE `id` = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'i', $id);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $name, $description, $value);
            $servicesArray = array();
            while (mysqli_stmt_fetch($result)) {
                $auxArr = array(
                    "id" => $id,
                    "name" => $name,
                    "description" => $description,
                    "value" => $value
                );
                array_push($servicesArray, $auxArr);
            }
            return $servicesArray;
        }
    }

    public static function createNewService($data)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "INSERT INTO `services`(`id`, `name`, `description`, `value`) VALUES (null, ?,?,?)";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'ssi', $data['name'],  $data['description'], $data['value']);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            return array("message" => "success", "insert"=>mysqli_insert_id($conn));
        } else {
            $arr = array("resp" => "error", "error" => mysqli_error($conn));
            return $arr;
        }
    }
}
?>