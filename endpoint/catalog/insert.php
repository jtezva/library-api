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
    if (!$decoded->catalog) {
        RespHandler::raise("Missing param: catalog", 400);
    }
    if (!$decoded->value) {
        RespHandler::raise("Missing param: value", 400);
    }
    if (!$decoded->display) {
        RespHandler::raise("Missing param: display", 400);
    }

    // insert
    CatalogService::insertCatalog($decoded->catalog, $decoded->value, $decoded->display);

    // result
    RespHandler::handleSuccess(null, "Inserted", 201);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>