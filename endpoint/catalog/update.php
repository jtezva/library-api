<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    //validate GET
    if (!isset($_GET)) {
        RespHandler::raise("Missing params", 400);
    }
    if (!isset($_GET['value'])) {
        RespHandler::raise("Missing param: value", 400);
    }
    $value = $_GET['value'];

    //validate Body
    // verify input
    $json = file_get_contents('php://input');
    if (!$json) {
        RespHandler::raise("Missing body", 400);
    }
    $decoded = json_decode($json);
    if (!$decoded) {
        RespHandler::raise("Invalid body", 400);
    }

    $message = CatalogService::updateCatalog($value, $decoded);
    RespHandler::handleSuccess(null, $message, 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>