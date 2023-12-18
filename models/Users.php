<?php 

class Users {
    //Connection
    private $connection;
    private $table = "users"

    //Object properties
    public $id;
    public $firtname;
    public $lastname;
    public $email;
    public $password;
    public $role;

    /**
     * Constructeur avec $db pour la connection de la base de donnée
     * 
     * @param $db
     */
    public function __construct($db) {
        $this->connection = $db;
    }

    /**
     * Lecture des users
     * 
     * @return void
     */
    public function lire() {
        $sql = "SELECT * FROM db_booking.users";

        $query = $this->connexion->prepare($sql);

        $query->execute();

        return $query;
    }

}