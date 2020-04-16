<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/library-api/utils/requires.php');
$con = false;
try {
    $data = BookService::getAllBooks();
    RespHandler::handleSuccess($data, null, 200);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>