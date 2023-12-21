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
    include_once '../models/Videos.php';
    //on instancie la BD
    $database = new Database();
    $db = $database->getConnection();

    //on instancie les produits
    $video = new Videos($db);

    //Onrecupère les données
    $stmt = $video->lire();

    //on vérifie si on a au mois 1 produit
    if ($stmt->rowCount() > 0) {
        //on initialise un tableau associatif
        $tableauVideos = [];
        $tableauVideos['videos'] = [];

        //on parcourt les users
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $video = [
                "id_video" => $id_video,
                "name" => $name,
                "id_site" => $id_site
            ];

            $tableauVideos['videos'][] = $video;
        }
        //on envoie le code responce 200 OK
        http_response_code(200);

        //On encode en json et on envoie
        echo json_encode($tableauVideos);
    }
} else {
    //on gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => " La mathode n'est pas autorisée"]);
}
