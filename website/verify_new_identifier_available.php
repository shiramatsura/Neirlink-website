<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/back/db_connect.php');
require_once(__DIR__ . '/back/functions.php');

$json = file_get_contents('php://input');
$data = json_decode($json);

//check if identifier exists
if (!isset($data->identifier)) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required fields'
    ]);
    exit;
}

$identifier = $data->identifier;

//for funny champs trying their luck
if (strlen($identifier) < 4) {
    echo json_encode([
        'success' => false,
        'message' => 'Identifiers must be at least 4 character long'
    ]);
    exit;
}

if (strlen($identifier) > 50) {
    echo json_encode([
        'success' => false,
        'message' => 'Identifier too long. Limit: 50 characters'
    ]);
    exit;
}

//actual availability verification
try {
    $query = "SELECT * FROM users WHERE account_name = :identifier LIMIT 1";
    $statement = $mysqlClient->prepare($query);
    $statement->bindParam(':identifier', $identifier);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        //json failure response if account_name already exist
        echo json_encode([
            'success' => false,
            'message' => 'Identifier unavailable'
        ]);
    } else {
        //account_name available
        echo json_encode([
            'success' => true,
            'message' => 'Identifier is available'
        ]);
        exit;
    }
} catch (Exception $e) {
    error_log('Database error: ', $e->getMessage());

    //failure response in case of internal error
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong. Please try again later'
    ]);
    exit;
}
