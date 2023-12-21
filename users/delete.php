<?php 
        // Headers requis
        header("Access-Control-Allow-Origin: *");//restrindre l'acces à l'API à cetaine sources
        header("Content-Type: application/json; charset=UTF-8");//definir le contenu de la rep: JSON, utf8
        header("Access-Control-Allow-Methods: DELETE");//Methodes accepées: GET
        header("Access-Control-Max-Age: 3600");//durée de vide la requete
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");//Header autorisés
    
        //Onverife la methode
        if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            // Ondirect les fichiers de configuration et d'accès aux données
            include_once '../config/Database.php';
            include_once '../models/Users.php';
    
            //on instancie la BD
            $database = new Database();
            $db = $database->getConnection();
    
            //on instancie les produits
            $user = new Users($db);

            // On recupère l'id du user
            $donnees = json_decode(file_get_contents("php://input"));

            if(!empty($donnees->id_user)) {
                $user->id_user = $donnees->id_user;
                if($user->supprimer()) {
                    // Ici la suppression a fonctionné
                    //On envoie un code 200
                    http_response_code(200);
                    echo json_encode(["messsage" => "La suppression a été effectué"]);
                }else {
                    // Ici la suppresison n'a pas fonctionné
                    //On envoie un code 503
                    http_response_code(503);
                    echo json_encode(["messsage" => "La suppression n'a pas été effectué"]);
                }
            }
        }else {
            //On gère l'erreur
            http_response_code(405);
            echo json_encode(["message" => " La mathode n'est pas autorisée"]);
        }
?>