<?php

const TOKEN = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF91c2VyIjoxLCJyb2xlcyI6WyJST0xFX0FETUlOIiwiUk9MRV9DUkFGVE1FTiIsIlJPTEVfVklTSVRPUiJdLCJpYXQiOjE3MDMxOTcyODQsImV4cCI6MTcwMzE5NzM0NH0.FZF7rnJAN-44NBJeP5YHbgObDfoCiE9NAnmgPHMHvDw';

require_once 'includes/config.php';
require_once 'models/JWT.php';

$jwt = new JWT();
var_dump($jwt->isValide(TOKEN));