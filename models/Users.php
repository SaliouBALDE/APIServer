<?php
header('Content-Type: application/json');
class Users
{
    //Connection
    private $connection;
    private $table = "users";

    //Object properties
    public $id_user;
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $language;
    public $role;

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
    public function lire()
    {
        //$sql = "SELECT * FROM db_booking.users";
        $sql = "SELECT id_user, firstname, lastname, email, password,language, role
                FROM " . $this->table . "
                ORDER BY id_user";
        $query = $this->connection->prepare($sql);

        $query->execute();

        return $query;
    }

    public function creer()
    {

        $sql = "INSERT INTO " . $this->table . " SET firstname=:firstname, lastname=:lastname, email=:email, password=:password, language=:language, role=:role ";

        $query = $this->connection->prepare($sql);

        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->language = htmlspecialchars(strip_tags($this->language));
        $this->role = htmlspecialchars(strip_tags($this->role));

        $query->bindParam(":firstname", $this->firstname);
        $query->bindParam(":lastname", $this->lastname);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":password", $this->password);
        $query->bindParam(":language", $this->language);
        $query->bindParam(":role", $this->role);

        if ($query->execute()) {
            return true;
        }

        return false;
    }

    public function supprimer()
    {
        $sql = "DELETE
                FROM " . $this->table . "
                WHERE id_user = ?
                LIMIT 1";

        $query = $this->connection->prepare($sql);
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));
        $query->bindParam(1, $this->id_user);

        if ($query->execute()) {
            return true;
        }

        return false;
    }

    public function checkEmail()
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE email=?";

        $stm = $this->connection->prepare($sql);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stm->bindParam(1, $this->email);

        if ($stm->execute()) {
            //$donnee = $stm->mysqli_stmt_get_result();

            //return $donnee->fetch_assoc();
        }

        return array();
    }

    public function modifier()
    {

        $sql = "UPDATE" . $this->table . "SET firstname=" . $this->firstname . ", lastname=" . $this->lastname . ", email=" . $this->email . ", password=" . $this->password . ", language=" . $this->language . ", role=" . $this->role . " WHERE id_user=" . $this->id_user . "";
        //$sql = "UPDATE users SET firstname=".$this->firstname.", lastname=".$this->lastname.", email=".$this->email.", password=".$this->password.", language=".$this->language.", role=".$this->role." WHERE id_user=".$this->id_user."";

        //$sql = "INSERT INTO ".$this->table." SET id_user = :id_user, firstname = :firstname, lastname = :lastname, email = :email, password = :password, language = :language, role = :role WHERE id_user = :id_user";

        $query = $this->connection->prepare($sql);

        $this->firstname = htmlspecialchars(strip_tags($this->firstname));
        $this->lastname = htmlspecialchars(strip_tags($this->lastname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->language = htmlspecialchars(strip_tags($this->language));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id_user = htmlspecialchars(strip_tags($this->id_user));

        $query->bindParam(':firstname', $this->firstname, PDO::PARAM_STR);
        $query->bindParam(':lastname', $this->lastname, PDO::PARAM_STR);
        $query->bindParam(':email', $this->email, PDO::PARAM_STR);
        $query->bindParam(':password', $this->password, PDO::PARAM_STR);
        $query->bindParam(':language', $this->language, PDO::PARAM_STR);
        $query->bindParam(':role', $this->role, PDO::PARAM_STR);
        $query->bindParam(':id_user', $this->id_user, PDO::PARAM_STR);

        if ($query->execute()) {
            return true;
        }

        return false;

    }

}
