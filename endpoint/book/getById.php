<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');
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

    $data = BookService::getById($id);
    RespHandler::handleSuccess($data, "", 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>