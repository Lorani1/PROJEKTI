<?php

class Dbh {
    protected function connect() {
        try {
            $username = "root";
            $password = "";
            $dbh = new PDO('mysql:host=localhost;dbname=projekt', $username, $password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            return $dbh;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
?>
