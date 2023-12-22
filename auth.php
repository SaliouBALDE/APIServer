<?php
header("Access-Control-Allow-Origin: *"); //restrindre l'acces à l'API à cetaine sources
header("Content-Type: application/json; charset=UTF-8"); //definir le contenu de la rep: JSON, utf8
header("Access-Control-Allow-Methods: POST"); //Methodes accepées: POST

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //On verifie si on reçoit un token

    //Verification sur le serveur gloabal
    if (isset($_SERVER['Authorization'])) 
    { //Verification sur le serveur gloabal
        $token = trim($_SERVER['Authorization']);
    } 
    elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) 
    {
        $token = trim($_SERVER['HTTP_AUTHORIZATION']);
    }
    elseif (function_exists('apache_request_headers')) 
    { //On verifie si la fonction apache
        $requestHeaders = apache_request_headers();
        if (isset($requestHeaders['Authorization'])) 
        {
            $token = trim($requestHeaders['Authorization']);
        }
    }

    if(!isset($token) || !preg_match('/Bearer\s(\S+)/', $token, $matches)) {
        http_response_code(400);
        echo json_encode(['message' => 'Token introuvable']);
        exit;
    }
    
    //On extrait le token
    $token = str_replace('Bearer ', '', $token);

    require_once 'includes/config.php';
    require_once 'models/JWT.php';
    
    $jwt = new JWT();

    //On verifie la validité
    if(!$jwt -> isValide($token)) {
        http_response_code(400);
        echo json_encode(["message" => "Token invalide"]);
        exit;
    }

    //Onverifie la signature
    if(!$jwt -> check($token, SECRET)) {
        http_response_code(403);
        echo json_encode(["message" => "Le token a invalide"]);
        exit;
    }

    //on verifie l'expiration
    if($jwt -> isExpired($token)) {
        http_response_code(403);
        echo json_encode(["message" => "Le token a expiré"]);
        exit;
    }

    echo json_encode($jwt->getPayload(($token)));

} else {
    //On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => " La mathode n'est pas autorisée"]);
}
