<?php

namespace AryanDev\UrlShorter;

use PDO;

class UrlShorter
{
    private $DB_Error;
    private $db;
    private $db_info;

    public function __construct(array $db_info)
    {
        if (!$this->connect_TO_DB($db_info)) {
            echo $this->DB_Error;
        } else {
            $this->db_info = $db_info;
        }
    }

    public function insertNewUrl($url,$docURL,$host)
    {
        $id = $this->generateId();
        $db = $this->db;
        $stmt = $db->prepare("INSERT INTO `urls` (`id`, `url`) VALUES ('$id', '$url')");
        $stmt->execute();
        return $host.$docURL.$id;
    }
    public function getUrl($url)
    {
        $db = $this->db;
        $sql = "SELECT * FROM `urls` WHERE `id` = '$url'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    private function connect_TO_DB(array $db_details)
    {
        try {
            $this->db = new \PDO("mysql:host=localhost;dbname=" . $db_details["dbname"], $db_details["username"], $db_details["password"]);
            return true;
        } catch (\PDOException $exception) {
            $this->DB_Error = $exception->getMessage();
            return false;
        }
    }

    public function create_table()
    {
        $db = $this->db;
        $stmt = $db->prepare("CREATE TABLE `" . $this->db_info["dbname"] . "`.`urls` ( `id` VARCHAR(5) NOT NULL , `url` VARCHAR(500) NOT NULL ) ENGINE = InnoDB;");
        $stmt->execute();
    }

    private function generateId()
    {
        $chars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $start = 0;
        $end = sizeof($chars) - 1;
        return $chars[rand($start, $end)] . $chars[rand($start, $end)] . $chars[rand($start, $end)] . $chars[rand($start, $end)] . $chars[rand($start, $end)];
    }
}