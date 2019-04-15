<?php

// ---- Initialize Default
include_once '../../_config/settings.php';
include_once '../../_config/core.php';
include_once '../../_config/headers.php';
include_once '../../_config/database.php';
include_once '../../_config/validate.php';
include_once '../../_config/libraries/php-jwt-master/src/BeforeValidException.php';
include_once '../../_config/libraries/php-jwt-master/src/ExpiredException.php';
include_once '../../_config/libraries/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../_config/libraries/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
$database = new Database();
$db = $database->connect($db_conf);
$data = json_decode(file_get_contents("php://input"));
// ---- End of Initialize Default

// ---- Get needed Objects
include_once '../../_config/objects/user.php';
$user = new User($db);
// ---- End of Get needed Objects

try {

    $user->firstname = val_string($data->firstname, 1, 255);
    $user->lastname = val_string($data->lastname, 1, 255);
    $user->email = val_email($data->email, 1, 89);
    $user->language = val_string($data->language, 1, 3);
    $user->password = val_string($data->password, 1, 255);
    $confirm_code = $user->create();

    if($api_conf['environment'] === "test"){
        returnSuccess($confirm_code);
    } else {

        $subject = 'Please confirm your Account';
        $message = 'Please confirm your account with this code: <b>'.$confirm_code. "</b> \r\n https://minska.osis.io/#/confirm";
        $header = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($user->email, $subject, $message, $header);
        returnSuccess();

    }

} catch (Exception $e) {
    returnBadRequest($e->getMessage());
}
