<?php
// Explore Bangladesh - Core PHP configuration
if (session_status() === PHP_SESSION_NONE) session_start();
date_default_timezone_set('Asia/Dhaka');
define('BASE_URL', '/Bangla-Travel-Spot'); // Change if your folder name/path differs.
$db_host='localhost'; $db_name='bangla_travel_spot'; $db_user='root'; $db_pass='';
try { $pdo=new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",$db_user,$db_pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch(PDOException $e){ http_response_code(500); die('Database connection failed. Import database.sql and check config.php.'); }
