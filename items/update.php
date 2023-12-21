<?php
    // Headers requis
    header("Access-Control-Allow-Origin: *");//restrindre l'acces à l'API à cetaine sources
    header("Content-Type: application/json; charset=UTF-8");//definir le contenu de la rep: JSON, utf8
    header("Access-Control-Allow-Methods: PUT");//Methodes accepées: GET
    header("Access-Control-Max-Age: 3600");//durée de vide la requete
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");//Header autorisés

    //Onverife la methode
    if($_SERVER['REQUEST_METHOD'] == 'PUT') {
        // Ondirect les fichiers de configuration et d'accès aux données
        include_once '../config/Database.php';
        include_once '../models/Items.php';

        //on instancie la BD
        $database = new Database();
        $db = $database->getConnection();

        //on instancie les produits
        $item = new Items($db);

        //On recupere les informations envoyées
        $donnees = json_decode(file_get_contents("php://input"));
        
        if(!empty($donnees->id_item) && !empty($donnees->name) && !empty($donnees->description) && !empty($donnees->price) && !empty($donnees->maker)) {

            //on a reçu les données
            //On va hydrater notre objet
            $item->id_item = $donnees->id_item;
            $item->name = $donnees->name;
            $item->description = $donnees->description;
            $item->price = $donnees->price;
            $item->maker = $donnees->maker;

            if($item->modifier()) {
                // Ici la modeification a fonctionné
                //On envoie un code 200
                http_response_code(200);
                echo json_encode(["messsage" => "La modeification a été effectuée"]);
            } else {
                // Ici la modeification n'a pas fonctionné
                //On envoie un code 503
                http_response_code(503);
                echo json_encode(["messsage" => "La modeification n'a pas été effectuée"]);
            }
        }
    }else {
        //On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => " La mathode n'est pas autorisée"]);
    }

?>