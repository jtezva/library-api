<?php
class Conector {
    static function getConection() {
        $mysqli = new mysqli("localhost", "emmanuel", "12345", "libray");
        if (mysqli_connect_errno()) {
            throw new Exception("Conection error: " . mysqli_connect_error(), 500);
        }
        return $mysqli;
    }
}
?>