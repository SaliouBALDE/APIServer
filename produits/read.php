<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Onverifie que ma méthode utilisée est correct
if($_SERVER['REQUEST_METHODE'] = 'GET') {

} else {
    http_response_code(405);
    echo json_encode(["message" => " La mathode n'est pas autorisée"]);
}