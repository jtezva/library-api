<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    //validate GET
    if (!isset($_GET)) {
        RespHandler::raise("Missing params", 400);
    }
    if (!isset($_GET['id'])) {
        RespHandler::raise("Missing param: id", 400);
    }
    $id = $_GET['id'];

    //validate body
    $json = file_get_contents('php://input');
    if (!$json) {
        RespHandler::raise("Missing body", 400);
    }
    $decoded = json_decode($json);
    if (!$decoded) {
        RespHandler::raise("Invalid body", 400);
    }

    $message = BookService::updateBook($id, $decoded);
    RespHandler::handleSuccess(null, $message, 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>