<?php
    class Items {
        //Connection
        private $connection;
        private $table = "items";

        //Object properties
        public $id_item;
        public $name;
        public $description;
        public $price;
        public $maker;

        public function __construct($db) {
            $this->connection = $db;
        }

        public function lire () {
            $sql = "SELECT id_item, name, description, price, maker
                    FROM ".$this->table."
                    ORDER BY id_item";

            $query = $this->connection->prepare($sql);
            $query->execute();

            return $query;
        }

        public function supprimer () {
            $sql = "DELETE 
                    FROM ".$this->table."
                    WHERE id_item = ?
                    LIMIT 1";

            $query = $this->connection->prepare($sql);

            $this -> id_item = htmlspecialchars(strip_tags($this->id_item));
            $query -> bindParam(1, $this->id_item);


            if($query->execute()) {
                return true;
            }

            return false;
        }

        public function creer() {

            $sql = "INSERT INTO ".$this->table." SET name=:name, description=:description, price=:price, maker=:maker";

            $query = $this->connection->prepare($sql);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->maker = htmlspecialchars(strip_tags($this->maker));

            $query->bindParam(":name", $this->name);
            $query->bindParam(":description", $this->description);
            $query->bindParam(":price", $this->price);
            $query->bindParam(":maker", $this->maker);

            if($query->execute()) {
                return true;
            }

            return false;
        }

        public function modifier () {
            $sql = "UPDATE".$this->table."SET name=".$this->name.", description=".$this->description.", price=".$this->price.", maker=".$this->price;
            //$sql = "UPDATE users SET firstname=".$this->firstname.", lastname=".$this->lastname.", email=".$this->email.", password=".$this->password.", language=".$this->language.", role=".$this->role." WHERE id_user=".$this->id_user."";
    
            //$sql = "INSERT INTO ".$this->table." SET id_user = :id_user, firstname = :firstname, lastname = :lastname, email = :email, password = :password, language = :language, role = :role WHERE id_user = :id_user";
         
            $query = $this->connection->prepare($sql);
          
            $this->id_item = htmlspecialchars(strip_tags($this->id_item));
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->maker = htmlspecialchars(strip_tags($this->maker));
            

            $query->bindParam(':id_item', $this->id_item);
            $query->bindParam(':name', $this->name);
            $query->bindParam(':description', $this->description);
            $query->bindParam(':price', $this->price);  
            $query->bindParam(':maker', $this->maker); 
            
            if($query->execute()) {
                return true;
            }
    
            return false;
        }
    }
?>