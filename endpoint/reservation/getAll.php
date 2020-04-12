<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');
$con = false;
try {
    $data = ReservationService::getAllReservations();
    RespHandler::handleSuccess($data, "", 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>