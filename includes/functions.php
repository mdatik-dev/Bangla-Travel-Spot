<?php
require_once __DIR__.'/../config.php';
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function url($path=''){return rtrim(BASE_URL,'/').'/'.ltrim($path,'/');}
function redirect($path){header('Location: '.url($path));exit;}
function user(){return $_SESSION['user']??null;}
function logged_in(){return (bool)user();}
function require_login(){if(!logged_in()){$_SESSION['flash']='Please login to continue.';redirect('auth/login.php');}}
function require_admin(){require_login();if(user()['role']!=='admin'){http_response_code(403);exit('Access denied');}}
function flash(){if(!empty($_SESSION['flash'])){$m=$_SESSION['flash'];unset($_SESSION['flash']);return '<div class="alert">'.e($m).'</div>';}return '';}
function csrf_token(){if(empty($_SESSION['csrf']))$_SESSION['csrf']=bin2hex(random_bytes(32));return $_SESSION['csrf'];}
function csrf_field(){return '<input type="hidden" name="csrf" value="'.e(csrf_token()).'">';}
function verify_csrf(){if($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['csrf']??'',$_POST['csrf']??'')){http_response_code(419);exit('Invalid security token. Refresh and try again.');}}
function setting($key,$default=''){global $pdo;static $s=[];if(!array_key_exists($key,$s)){try{$q=$pdo->prepare('SELECT setting_value FROM settings WHERE setting_key=?');$q->execute([$key]);$s[$key]=$q->fetchColumn()?:$default;}catch(Throwable $t){$s[$key]=$default;}}return $s[$key];}
function image_url($path){if(!$path)return 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=900';if(str_starts_with($path,'http'))return $path;return url($path);}
function money($n){return '৳'.number_format((float)$n);}
