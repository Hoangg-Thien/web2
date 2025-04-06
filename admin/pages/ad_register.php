<?php
session_start();
require_once 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $district = $_POST['district'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    
}
?>