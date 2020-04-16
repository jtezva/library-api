<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    if (!isset($_GET)) {
        RespHandler::raise("Missing params", 400);
    }
    if (!isset($_GET['value'])) {
        RespHandler::raise("Missing param: value", 400);
    }
    $value = $_GET['value'];
    $message = CatalogService::deleteCatalog($value);
    RespHandler::handleSuccess(null, $message, 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>