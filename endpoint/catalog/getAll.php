<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    $data = CatalogService::getAllCatalogs();
    RespHandler::handleSuccess($data, "", 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>