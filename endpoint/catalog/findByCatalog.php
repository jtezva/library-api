<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');
$con = false;
try {
    //validate GET
    if (!isset($_GET)) {
        RespHandler::raise("Missing params", 400);
    }
    if (!isset($_GET['catalog'])) {
        RespHandler::raise("Missing param: catalog", 400);
    }
    $catalog = $_GET['catalog'];

    $data = CatalogService::findCatalogByCatalog($catalog);
    RespHandler::handleSuccess($data, "", 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>