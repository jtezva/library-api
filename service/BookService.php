<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');

class BookService {
    static function getAllBooks () {
        $data;
        try {
            $con = Conector::getConection();
            $query = "select b.id, b.name, b.author, b.categoryid, ".
                             "b.editorid, b.statusid, ".
                             "c.display \"categoryname\", ".
                             "e.display \"editorname\", ".
                             "s.display \"statusname\" ".
                        "from tbook b ".
                        "join tcatalog c on c.value= b.categoryid ".
                        "join tcatalog e on e.value = b.editorid ".
                        "join tcatalog s on s.value = b.statusid ".
                       "order by b.id;";
            $res = $con->query($query) or RespHandler::raise("Query error", 500);
            $data = array();
            while ($row = $res->fetch_assoc()) {
                array_push($data, $row);
            }
            $res->close();
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $data;
    }

    static function insertBook ($name, $author, $categoryid, $editorid, $statusid) {
        try {
            $con = Conector::getConection();
            $stmt = $con->prepare("insert into tbook (name, author, categoryid, editorid, statusid) ".
                                "values (?, ?, ?, ?, ?)")
                or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('sssss', $name, $author, $categoryid, $editorid,
                $statusid) or RespHandler::raise("Error binding", 500);
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

    static function updateBook($id, $requestBody) {
        $message;
        try {
            $data = BookService::getById($id);

            //get current record from DB
            $con = Conector::getConection();
            
            // update the current object
            if (property_exists($requestBody, 'name')) {
                $data['name'] = $requestBody->name;
            }

            if (property_exists($requestBody,'author')) {
                $data['author'] = $requestBody->author;
            }

            if (property_exists($requestBody, 'categoryid')) {
                $data['categoryid'] = $requestBody->categoryid;
            }

            if (property_exists($requestBody, 'editorid')) {
                $data['editorid'] = $requestBody->editorid;
            }

            if (property_exists($requestBody, 'statusid')) {
                $data['statusid'] = $requestBody->statusid;
            }

            // update
            $query = "update tbook set name = ?, author = ?, ".
                            "categoryid = ?, editorid = ?, statusid = ? ".
                    "where id = ?";
            $stmt = $con->prepare($query)
                or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('sssssi',
                $data['name'],
                $data['author'],
                $data['categoryid'],
                $data['editorid'],
                $data['statusid'],
                $id)
                or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $message = "Books updated: ". $con->affected_rows;
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $message;
    }

    static function deleteBook($id) {
        $message;
        try {
            $query = "delete from tbook where id = ?";
    
            $con = Conector::getConection();
            $stmt = $con->prepare($query) or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('i', $id) or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $message = "Books deleted: ".$con->affected_rows;
            $stmt->close();
            $con->close();
        } catch (Excepion $e) {
            throw $e;
        }
        return $message;
    }

    static function getById($id) {
        $data;
        try {
            $con = Conector::getConection();
            $query = "select b.id, b.name, b.author, b.categoryid, b.editorid, b.statusid ".
                    "from tbook b ".
                    "where b.id = ?";
            $stmt = $con->prepare($query) or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('i', $id);
            $res = $stmt->execute();
            if (!$res) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $res = $stmt->get_result();
            if (!$res) {
                RespHandler::raise("Book with id $id not found", 404);
            }
            $data = $res->fetch_assoc();
            if (!$data) {
                RespHandler::raise("Book with id $id not found", 404);
            }
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $data;
    }
}
?>