<?php

class Sites
{
    //Connection
    private $connection;
    private $table = "sites";

    //Object properties
    public $id_site;
    public $name;
    public $coord_x;
    public $coord_y;
    public $id_user;

    /**
     * Constructeur avec $db pour la connection de la base de donnée
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->connection = $db;
    }

    /**
     * Lecture des users
     *
     * //@return void
     */
    public function lire(){
        $sql = "SELECT id_site, name, coord_x, coord_y, id_user
                FROM ".$this->table."
                ORDER BY id_site";
        $query = $this->connection->prepare($sql);

        $query->execute();

        return $query;
    }

    public function creer() {

        $sql = "INSERT INTO ".$this->table." SET name=:name, coord_x=:coord_x, coord_y=:coord_y, id_user=:id_user";

        $query = $this->connection->prepare($sql);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->coord_x = htmlspecialchars(strip_tags($this->coord_x));
        $this->coord_y= htmlspecialchars(strip_tags($this->coord_y));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));

        $query->bindParam(":name", $this->name);
        $query->bindParam(":coord_x", $this->coord_x);
        $query->bindParam(":coord_y", $this->coord_y);
        $query->bindParam(":id_user", $this->id_user);

        if($query->execute()) {
            return true;
        }

        return false;
    }

    public function supprimer() {
        $sql = "DELETE 
                FROM ".$this->table."
                WHERE id_site = ?
                LIMIT 1";
        
        $query = $this->connection->prepare($sql);
        $this -> id_site = htmlspecialchars(strip_tags($this->id_site));
        $query -> bindParam(1, $this->id_site);

        if($query -> execute()) {
            return true;
        }

        return false;
    }



    public function modifier () {

        $sql = "UPDATE".$this->table."SET name=".$this->name.", coord_x=".$this->coord_x.", coord_y=".$this->coord_y.", id_user=".$this->id_user." WHERE id_site=".$this->id_site."";
        $query = $this->connection->prepare($sql);
      
        $this->id_site = htmlspecialchars(strip_tags($this->id_site));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->coord_x = htmlspecialchars(strip_tags($this->coord_x));
        $this->coord_y= htmlspecialchars(strip_tags($this->coord_y));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));

        $query->bindParam(":id_site", $this->id_site);
        $query->bindParam(":name", $this->name);
        $query->bindParam(":coord_x", $this->coord_x);
        $query->bindParam(":coord_y", $this->coord_y);
        $query->bindParam(":id_user", $this->id_user);
        
        if($query->execute()) {
            return true;
        }

        return false;
        
    }

}
