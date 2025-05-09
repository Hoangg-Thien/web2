<?php
session_start();
header('Content-Type: application/json');

$response = ['isCurrentUser' => false];

if (isset($_SESSION['user_name'], $_POST['user_name'])) {
    if ($_SESSION['user_name'] === $_POST['user_name']) {
        $response['isCurrentUser'] = true;
    }
}

echo json_encode($response);
?>
