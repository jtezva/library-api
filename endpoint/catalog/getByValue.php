<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');
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

    $data = CatalogService::getCatalogByValue($value);
    RespHandler::handleSuccess($data, "", 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>