<?php
// index.php
require_once './includes/database.php';
require_once './includes/functions.php';

// Get the request method
$method = $_SERVER['REQUEST_METHOD'];

$name = isset($_POST['name']) ? $_POST['name'] : null;
$type = isset($_POST['type']) ? $_POST['type'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$country = isset($_POST['country']) ? $_POST['country'] : null;
$message = isset($_POST['message']) ? $_POST['message'] : null;

// Determine the resource and ID if provided
$resource = $type;
switch ($resource) {
    case 'barcode_scan':
        handleUsers($method);
        break;
    default:
        respond('error', 'Invalid endpoint');
}

// Handle Users API
function handleUsers($method) {
    global $pdo;

    switch ($method) {
        case 'POST': // Create a user
           // $data = getJsonInput();

            $name = isset($_POST['name']) ? $_POST['name'] : null;
            $type = isset($_POST['type']) ? $_POST['type'] : null;
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
            $country = isset($_POST['country']) ? $_POST['country'] : null;
            $message = isset($_POST['message']) ? $_POST['message'] : null;


            $stmt = $pdo->prepare("INSERT INTO tbl_barcode_scaned_users(name,type,email,phone,country,message) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $type, $email,$phone,$country, $message])) {
                respond('success', 'User created', ['id' => $pdo->lastInsertId()]);
            } else {
                respond('error', 'Failed to create user');
            }
            break;
        default:
            respond('error', 'Invalid request method');
    }
}
?>