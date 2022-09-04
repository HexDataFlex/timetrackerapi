<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->name)) {
            http_response_code(400);
            die(trigger_error('Please fill out the name', E_USER_WARNING));
        }

        $token = Token::getFromHeaders();

        echo json_encode(array('tagId' => getTag(Token::getUserId($token), htmlspecialchars($data->name))));
    }
} else {
    trigger_error('Access denied', E_USER_WARNING);
    http_response_code(401);
}

//End of file