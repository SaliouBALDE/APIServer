<?php

class Videos
{
    //Connection
    private $connection;
    private $table = "videos";

    //Object properties
    public $id_video;
    public $name;
    public $id_site;


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
        $sql = "SELECT id_video, name, id_site
                FROM ".$this->table."
                ORDER BY id_video";
                
        $query = $this->connection->prepare($sql);

        $query->execute();

        return $query;
    }

    public function creer() {

        $sql = "INSERT INTO ".$this->table." SET name=:name, id_site=:id_site";

        $query = $this->connection->prepare($sql);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id_site = htmlspecialchars(strip_tags($this->id_site));

        $query->bindParam(":name", $this->name);
        $query->bindParam(":id_site", $this->id_site);

        if($query->execute()) {
            return true;
        }

        return false;
    }

    public function supprimer() {
        $sql = "DELETE 
                FROM ".$this->table."
                WHERE id_video = ?
                LIMIT 1";
        
        $query = $this->connection->prepare($sql);
        $this -> id_video = htmlspecialchars(strip_tags($this->id_video));
        $query -> bindParam(1, $this->id_video);

        if($query -> execute()) {
            return true;
        }

        return false;
    }

    public function modifier () {

        $sql = "UPDATE".$this->table."SET name=".$this->name.", id_site=".$this->id_site." WHERE id_video=".$this->id_video."";
        $query = $this->connection->prepare($sql);
      
        $this->id_video = htmlspecialchars(strip_tags($this->id_video));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id_site = htmlspecialchars(strip_tags($this->id_site));

        $query->bindParam(":id_video", $this->id_video);
        $query->bindParam(":name", $this->name);
        $query->bindParam(":id_site", $this->id_site);
        
        if($query->execute()) {
            return true;
        }

        return false;
        
    }

}
