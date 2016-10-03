<?php

class MySQLDB {


    /**
    * @var string, DB connection string.
    */
    private $connStr;

    private $dbuser;

    private $dbpass;

    private $conn;

    private $cursor;

    public function __construct($connectStr, $user, $password) {
        $this->connStr = $connectStr;
        $this->dbuser = $user;
        $this->dbpass = $password;
        //echo $this->connStr;
    }

    public function connect() {
        try {
            $this->conn = new PDO($this->connStr, $this->dbuser, $this->dbpass);
        } catch (PDOException $e) {
            echo "<p> An error occurred while connecting to the database:".$e->getMessage(). "</p>";
            $this->conn = null;
        }
    }


    /**
     * Get the result set from DB.
     */
    public function query($sql) {
        $this->cursor = $this->conn->query($sql);
        return $this->cursor;
    }


    public function exec($sql) {
        $this->conn->exec($sql);
    }


    public function disconnect() {
        $this->cursor = null;
        $this->conn = null;
    }

}

?>
