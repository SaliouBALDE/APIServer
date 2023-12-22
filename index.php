<?php
//Impoter la clé privée

use Random\Engine\Secure;

require_once 'includes/config.php';
require_once 'models/JWT.php';
// On crée le header
$header = [
    'typ' => 'JWT',
    'alg' => 'HS256',
];

//On crée le contenu (payload)
$payload = [
    'id_user' => 1,
    'roles' => [
        'ROLE_ADMIN',
        'ROLE_CRAFTMEN',
        'ROLE_VISITOR'
    ]
];

$jwt = new JWT();

$token =$jwt->generate($header, $payload, SECRET);//token valide pour 24heures

echo $token;
