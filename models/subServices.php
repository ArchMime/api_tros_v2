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
}
?>