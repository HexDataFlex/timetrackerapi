<?php

require_once '../utils/timer_fns.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");

if (@Token::check(@Token::getFromHeaders())) {
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        // get posted data
        $data = json_decode(file_get_contents("php://input", true));

        if (!isset($data->projectId) || !isset($data->name)) {
            http_response_code(400);
            die(trigger_error('Please fill out the projectId and name', E_USER_WARNING));
        }

        $token = Token::getFromHeaders();
        
        if (DB::query('SELECT * FROM projects WHERE id=:projectId AND user_id=:userId', array(':projectId' => htmlspecialchars($data->projectId), ':userId' => Token::getUserId($token)))) {
            editProject(htmlspecialchars($data->projectId), htmlspecialchars($data->name));
            echo json_encode(array('success' => 'Project edited'));
        } else {
            trigger_error('Project does not exist', E_USER_WARNING);
        }
    }
} else {
    trigger_error('Access denied', E_USER_WARNING);
    die(http_response_code(401));
}

//End of file