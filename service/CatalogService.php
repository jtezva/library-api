<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');

class CatalogService {

    static function getAllCatalogs() {
        $data = array();
        try {
            $con = Conector::getConection();
            $query = "select c.catalog, c.value, c.display ".
                    "from tcatalog c ".
                    "order by c.catalog, c.value;";
            $res = $con->query($query) or RespHandler::raise("Query error", 500);
            while ($row = $res->fetch_assoc()) {
                array_push($data, $row);
            }
            $res->close();
            $con->close();
        } catch(Exception $e) {
            throw $e;
        }
        return $data;
    }

    static function insertCatalog($catalog, $value, $display) {
        try {
            $con = Conector::getConection();
            $stmt = $con->prepare("insert into tcatalog (catalog, value, display) values (?, ?, ?)")
                or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('sss', $catalog, $value, $display)
                or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            if ($con->affected_rows < 1) {
                RespHandler::raise("Not inserted", 500);
            }
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
    }

    static function getCatalogByValue($value) {
        $catalog;
        try {
            $con = Conector::getConection();
            $query = "select c.catalog, c.value, c.display ".
                       "from tcatalog c ".
                      "where c.value = ?";
            $stmt = $con->prepare($query) or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('s', $value);
            $res = $stmt->execute();
            if (!$res) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $res = $stmt->get_result();
            if (!$res) {
                RespHandler::raise("Catalog with value $value not found", 404);
            }
            $catalog = $res->fetch_assoc();
            if (!$catalog) {
                RespHandler::raise("Catalog with value $value not found", 404);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $catalog;
    }

    static function updateCatalog($value, $requestBody) {
        $message;
        try {
            $data = CatalogService::getCatalogByValue($value);

            //get current record from DB
            $con = Conector::getConection();

            // create the updated object
            if (property_exists($requestBody, 'catalog')) {
                $data['catalog'] = $requestBody->catalog;
            }

            if (property_exists($requestBody, 'display')) {
                $data['display'] = $requestBody->display;
            }

            // update
            $stmt = $con->prepare("update tcatalog set catalog = ?, display = ? where value = ?")
                or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('sss', $data['catalog'], $data['display'], $value)
                or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $message = "Catalog entries updated: ". $con->affected_rows;

            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $message;
    }

    static function deleteCatalog($value) {
        $message;
        try {
            $query = "delete from tcatalog where value = ?";
    
            $con = Conector::getConection();
            $stmt = $con->prepare($query) or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('s', $value) or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $message = "Catalog entries deleted: ".$con->affected_rows;
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $message;
    }

    static function findCatalogByCatalog($catalog) {
        $data = array();
        try {
            $con = Conector::getConection();
            $query = "select c.catalog, c.value, c.display ".
                    "from tcatalog c ".
                    "where c.catalog = ? ".
                    "order by c.catalog, c.value;";
            $stmt = $con->prepare($query)  or RespHandler::raise("Error Preparing", 500);
            $stmt->bind_param('s', $catalog) or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $res = $stmt->get_result();
            if (!$res) {
                RespHandler::raise("Error getting result", 500);
            }
            while ($row = $res->fetch_assoc()) {
                array_push($data, $row);
            }
            $stmt->close();
            $con->close();
        } catch(Exception $e) {
            throw $e;
        }
        return $data;
    }
}
?>