<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/api_v2/utils/dbConnection.php";

class SubServices
{
    public static function getSubServicesByServiceId($id)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT * FROM `subservices` WHERE `service` = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'i', $id);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $service, $name, $description, $value);
            $servicesArray = array();
            while (mysqli_stmt_fetch($result)) {
                $auxArr = array(
                    "id" => $id,
                    "service" => $service,
                    "name" => $name,
                    "description" => $description,
                    "value" => $value
                );
                array_push($servicesArray, $auxArr);
            }
            return $servicesArray;
        }
    }
    public static function getSubServiceById($id)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "SELECT * FROM `subservices` WHERE `id` = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'i', $id);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $validate = mysqli_stmt_bind_result($result, $id, $service, $name, $description, $value);
            $servicesArray = array();
            while (mysqli_stmt_fetch($result)) {
                $auxArr = array(
                    "id" => $id,
                    "service" => $service,
                    "name" => $name,
                    "description" => $description,
                    "value" => $value
                );
                array_push($servicesArray, $auxArr);
            }
            return $servicesArray;
        }
    }

    public static function createNewSubService($data, $service)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "INSERT INTO `subservices`(`id`,`service`, `name`, `description`, `value`) VALUES (null, ?,?,?,?)";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'issi', $service, $data['name'],  $data['description'], $data['value']);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $arr = array("message" => "success", "insert"=>mysqli_insert_id($conn));
            return $arr;
        } else {
            $arr = array("message" => "error", "error" => mysqli_error($conn));
            return $arr;
        }
    }

    public static function deleteSubService($id)
    {
        $conexion = new DbConnection;
        $conn = $conexion->get_connection();
        $stm = "DELETE FROM `subservices` WHERE `id` = ?";
        $result = mysqli_prepare($conn, $stm);
        $validate = mysqli_stmt_bind_param($result, 'i', $id);
        $validate = mysqli_stmt_execute($result);
        if ($validate) {
            $arr = array("message" => "success");
            return $arr;
        } else {
            $arr = array("message" => "error", "error" => mysqli_error($conn));
            return $arr;
        }
    }

}
?>