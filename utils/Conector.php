<?php
class Conector {
    static function getConection() {
        $mysqli = new mysqli("3.135.19.156:3306", "emmanuel", "SO76699737427", "library");
        if (mysqli_connect_errno()) {
            throw new Exception("Conection error: " . mysqli_connect_error(), 500);
        }
        return $mysqli;
    }
}
?>