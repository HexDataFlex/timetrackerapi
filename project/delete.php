<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");

if (Token::check(Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->projectId)) {
            http_response_code(400);
            die(trigger_error('Please fill out the projectId', E_USER_WARNING));
        }

        $token = Token::getFromHeaders();

        if (DB::query('SELECT * FROM projects WHERE id=:projectId AND user_id=:userId', array(':projectId' => htmlspecialchars($data->projectId), ':userId' => Token::getUserId($token)))) {
            deleteProject(htmlspecialchars($data->projectId));
            echo json_encode(array('success' => 'Project deleted'));
        } else {
            trigger_error('Project does not exist', E_USER_WARNING);
        }
    }
} else {
    trigger_error('Access denied', E_USER_WARNING);;
    http_response_code(401);
}

//End of file