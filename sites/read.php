<?php
// Headers requis
header("Access-Control-Allow-Origin: *"); //restrindre l'acces à l'API à cetaine sources
header("Content-Type: application/json; charset=UTF-8"); //definir le contenu de la rep: JSON, utf8
header("Access-Control-Allow-Methods: GET"); //Methodes accepées: GET
header("Access-Control-Max-Age: 3600"); //durée de vide la requete
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); //Header autorisés

//Onverifie que ma méthode utilisée est correct
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include_once '../config/Database.php';
    include_once '../models/Sites.php';
    //on instancie la BD
    $database = new Database();
    $db = $database->getConnection();

    //on instancie les produits
    $site = new Sites($db);

    //Onrecupère les données
    $stmt = $site->lire();

    //on vérifie si on a au mois 1 produit
    if ($stmt->rowCount() > 0) {
        //on initialise un table associatif
        $tableauSites = [];
        $tableauSites['sites'] = [];

        //on parcourt les users
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $site = [
                "id_site" => $id_site,
                "name" => $name,
                "coord_x" => $coord_x,
                "coord_y" => $coord_y,
                "id_user" => $id_user
            ];

            $tableauSites['sites'][] = $site;
        }
        //on envoie le code responce 200 OK
        http_response_code(200);

        //On encode en json et on envoie
        echo json_encode($tableauSites);
    }
} else {
    //on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => " La mathode n'est pas autorisée"]);
}
