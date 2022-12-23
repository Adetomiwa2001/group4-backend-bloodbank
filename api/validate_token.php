<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to decode jwt
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// retrieve gieve jwt here

// get posted data
$data = json_decode(file_get_contents("php://input"));

// decode jwt here
// if jwt is not empty
// get jwt
$jwt = $data->jwt;
// echo ($jwt);
// echo (isset($jwt));

if (isset($jwt)) {
// get jwt
    echo (isset($jwt));

    // if decode succeed, show user details
    try {
        // decode jwt
        // $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $decoded = JWT::urlsafeB64Decode($jwt, 'HS256');

// show user details
        echo ($decoded);

        // echo json_encode(array(
        //     "message" => "Access granted.",
        //     "data" => $decoded,
        // ));

        // set response code
        http_response_code(200);

    } catch (Exception $e) {

        // set response code
        http_response_code(401);

        // tell the user access denied  & show error message
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage(),
        ));
    }

}

// error if jwt is empty will be here
// show error message if jwt is empty
else {

    // set response code
    http_response_code(401);

    // tell the user access denied
    echo json_encode(array("message" => "Access denied."));
}
