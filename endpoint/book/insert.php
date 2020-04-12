<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');
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
    if (!$decoded->name) {
        RespHandler::raise("Missing param: name", 400);
    }
    if (!$decoded->author) {
        RespHandler::raise("Missing param: author", 400);
    }
    if (!$decoded->categoryid) {
        RespHandler::raise("Missing param: categoryid", 400);
    }
    if (!$decoded->editorid) {
        RespHandler::raise("Missing param: editorid", 400);
    }
    if (!$decoded->statusid) {
        RespHandler::raise("Missing param: statusid", 400);
    }

    // insert
    BookService::insertBook($decoded->name, $decoded->author, $decoded->categoryid,
         $decoded->editorid, $decoded->statusid);

    // result
    RespHandler::handleSuccess(null, "Inserted", 201);
} catch (Exception $e) {
    RespHandler::handleError($e, $con);
}
?>