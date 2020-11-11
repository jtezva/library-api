<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');
$con = false;
try {
    if (!isset($_GET)) {
        RespHandler::raise("Missing params", 400);
    }
    if (!isset($_GET['id'])) {
        RespHandler::raise("Missing param: id", 400);
    }
    $id = $_GET['id'];
    
    $message = BookService::deleteBook($id);
    RespHandler::handleSuccess(null, $message, 200);
    echo "Hola mundo";
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>