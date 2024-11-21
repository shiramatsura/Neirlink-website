<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/back/db_connect.php');
require_once(__DIR__ . '/back/functions.php');

$json = file_get_contents('php://input');
$data = json_decode($json);

if (!isset($data->identifier) || !isset($data->password) || empty($data->identifier) || empty($data->password)) {
    echo json_encode([
        'success' => false,
        'error' => 'Missing required fields'
    ]);
    exit;
}

$identifier = $data->identifier;
$password = hash('sha256', $data->password);

try {
    $query = "SELECT * FROM users WHERE account_name = :identifier or email = :identifier LIMIT 1";
    $statement = $mysqlClient->prepare($query);
    $statement->bindParam(':identifier', $identifier);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $password === $user['password']) {//password_verify($password, $user['password'])) {
        //regenerate SID to avoid session fixation attacks
        session_regenerate_id(true);
    
        //store user data in session
        $_SESSION['LOGGED_USER'] = [
            'user_id' => $user['user_id'],
            'email' => $user['email'],
            'account_name' => $user['account_name'],
            'username' => $user['username']
        ];
    
        //redirects to the page if referer is valid
        $referer = $_SERVER['HTTP_REFERER'] ?? '/'; // Fallback if HTTP_REFERER is not set
    
        if (strpos($referer, 'neirlink.com') === false) {
            $referer = '/'; // Set default redirection if referer is invalid
        }
    


        //json response if login successful
        echo json_encode([
            'success' => true,
            'redirect_url' => $referer
        ]);
    } else {
        //generic failure response
        echo json_encode([
            'success' => false,
            'error' => 'Incorrect identifier or password'
        ]);
        exit;
    }
} catch (Exception $e) {
    error_log('Database error: ', $e->getMessage());

    //failure response in case of internal error
    echo json_encode([
        'success' => false,
        'error' => 'Something went wrong. Please try again later'
    ]);
    exit;
}
