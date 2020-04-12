<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/libraryapi/utils/requires.php');

class ReservationService {
    static function getAllReservations() {
        $data;
        try {
            $con = Conector::getConection();
            $query = "select r.id, r.bookid, r.user, r.start, r.end, ".
                            "r.statusid, ".
                            "b.name \"bookname\", ".
                            "s.display \"statusname\" ".
                    "from treservation r ".
                    "join tbook b on b.id = r.bookid ".
                    "join tcatalog s on s.value = r.statusid ".
                    "order by r.id;";
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

    static function insertReservation($bookid, $user, $start, $end, $statusid) {
        try {
            $con = Conector::getConection();
            $stmt = $con->prepare("insert into treservation (bookid, user, start, end, statusid) ".
                                "values (?, ?, ?, ?, ?)")
                or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('issss',
                $bookid,
                $user,
                $start,
                $end,
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

    static function updateReservation($id,$requestBody) {
        $message;
        try {
            $data = ReservationService::getById($id);
            
            // update the current object
            if (property_exists($requestBody, 'bookid')) {
                $data['bookid'] = $requestBody->bookid;
            }
            
            if (property_exists($requestBody, 'user')) {
                $data['user'] = $requestBody->user;
            }
            
            if (property_exists($requestBody, 'start')) {
                $data['start'] = $requestBody->start;
            }
            
            if (property_exists($requestBody, 'end')) {
                $data['end'] = $requestBody->end;
            }
            
            if (property_exists($requestBody, 'statusid')) {
                $data['statusid'] = $requestBody->statusid;
            }
            
            // update
            $con = Conector::getConection();
            $query = "update treservation set bookid = ?, user = ?, ".
                            "start = ?, end = ?, statusid = ? ".
                    "where id = ?";
            $stmt = $con->prepare($query)
                or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('issssi',
                $data['bookid'],
                $data['user'],
                $data['start'],
                $data['end'],
                $data['statusid'],
                $id)
                or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $message = "Reservations updated: ". $con->affected_rows;
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $message;
    }

    static function deleteReservation($id) {
        $message;
        try {
            $query = "delete from treservation where id = ?";
    
            $con = Conector::getConection();
            $stmt = $con->prepare($query) or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('i', $id) or RespHandler::raise("Error binding", 500);
            $executed = $stmt->execute();
            if (!$executed) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            /*if ($con->affected_rows == 0) {
                RespHandler::raise("Reservation with id ".$id. " not found", 404);
            }*/
            $message = "Reservations deleted: ".$con->affected_rows;
            $stmt->close();
            $con->close();
        } catch (Exception $e) {
            throw $e;
        }
        return $message;
    }

    static function getById($id){
        $data;
        try {
            $con = Conector::getConection();
            $query = "select r.id, r.bookid, r.user, r.start, r.end, r.statusid ".
                    "from treservation r ".
                    "where r.id = ?";
            $stmt = $con->prepare($query) or RespHandler::raise("Error preparing", 500);
            $stmt->bind_param('i', $id);
            $res = $stmt->execute();
            if (!$res) {
                RespHandler::raise("SQL Error: ".$stmt->error, 500);
            }
            $res = $stmt->get_result();
            if (!$res) {
                RespHandler::raise("Reservation with id $id not found", 404);
            }
            $data = $res->fetch_assoc();
            if (!$data) {
                RespHandler::raise("Reservation with id $id not found", 404);
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