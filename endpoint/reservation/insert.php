<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    // verify input
    $json = file_get_contents('php://input');
    if (!$json) {
        RespHandler::raise("Missing body", 400);
    }
    $decoded = json_decode($json);
    if (!$decoded) {
        RespHandler::raise("Invalid body", 400);
    }
    if (!$decoded->bookid) {
        RespHandler::raise("Missing param: bookid", 400);
    }
    if (!$decoded->user) {
        RespHandler::raise("Missing param: user", 400);
    }
    if (!$decoded->start) {
        RespHandler::raise("Missing param: start", 400);
    }
    if (!$decoded->statusid) {
        RespHandler::raise("Missing param: statusid", 400);
    }

    // insert
    ReservationService::insertReservation($decoded->bookid, $decoded->user, $decoded->start,
        $decoded->end, $decoded->statusid);

    // result
    RespHandler::handleSuccess(null, "Inserted", 201);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>