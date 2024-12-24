<?php
// functions.php

// Respond with JSON
function respond($status, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
    exit;
}

// Parse JSON input
function getJsonInput() {
    return json_decode(file_get_contents('php://input'), true);
}
