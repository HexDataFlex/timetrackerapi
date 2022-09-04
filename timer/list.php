<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if (Token::check($token = Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->name)) {
            http_response_code(400);
            die(trigger_error('Please fill out the name', E_USER_WARNING));
        }
        if (DB::query("SELECT * FROM time WHERE id=:timerId AND user_id=:userId LIMIT 1", array(':timerId'=>htmlspecialchars($data->timerId), ':userId'=>Token::getUserId($token))) != null) {
            //TODO: get the list 
            //TODO: foreach loop and display list
        } else {
            trigger_error('Timer does not exist', E_USER_WARNING);
            http_response_code(404);
        }
    }
} else {
    trigger_error('Access denied', E_USER_WARNING);
    http_response_code(401);
}

//End of file