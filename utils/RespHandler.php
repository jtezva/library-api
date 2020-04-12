<?php
class RespHandler {
    static function handleError(Exception $e, $connection) {
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, ".
               "Content-Type, Accept, Access-Control-Request-Method");
        if ($connection) {
            try {
                $connection->close();
            } catch (Exception $e2) {}
        }
        http_response_code(200);
        $json = new stdClass();
        $json->success = false;
        $json->message = $e->getMessage();
        echo json_encode($json);
    }
    
    static function handleSuccess($data, $message, $htmlcode) {
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, ".
               "Content-Type, Accept, Access-Control-Request-Method");
        http_response_code($htmlcode);
        $json = new stdClass();
        $json->success = true;
        $json->message = $message;
        $json->data = $data;
        echo json_encode($json);
    }

    static function raise ($message, $code) {
        throw new Exception($message, $code);
    }
}
?>