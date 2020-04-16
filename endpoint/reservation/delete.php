<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    if (!isset($_GET)) {
        RespHandler::raise("Missing params", 400);
    }
    if (!isset($_GET['id'])) {
        RespHandler::raise("Missing param: id", 400);
    }
    $id = $_GET['id'];
    $message = ReservationService::deleteReservation($id);
    RespHandler::handleSuccess(null, $message, 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>