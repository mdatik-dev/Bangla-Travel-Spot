<?php
require_once '../includes/functions.php';
if(logged_in())redirect_to_dashboard();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $account=authenticate_account($_POST['email']??'',$_POST['password']??'','admin');
    if($account){
        session_regenerate_id(true);
        $_SESSION['user']=['id'=>$account['id'],'name'=>$account['name'],'email'=>$account['email'],'role'=>$account['role']];
        redirect('admin/index.php');
    }
    $error='Incorrect email or password, or this account is not an administrator account.';
}
$page_title='Admin Login';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$page_title?> | Bangla Travel Spot</title>
    <link rel="stylesheet" href="<?=url('assets/css/style.css')?>">
    <link rel="stylesheet" href="<?=url('admin/admin.css')?>">
    <script defer src="<?=url('assets/js/app.js')?>"></script>
</head>
<body class="admin-login-body">
    <main class="admin-login-card">
        <a class="admin-login-brand" href="<?=url('index.php')?>">
            <span class="admin-login-brand-mark" aria-hidden="true">◆</span>
            <span>Bangla Travel Spot</span>
        </a>
        <div class="admin-login-kicker">ADMIN CONSOLE</div>
        <h1>Welcome back</h1>
        <p class="admin-login-description">Sign in with an active administrator account to manage the website.</p>
        <?php if($error):?><div class="alert"><?=e($error)?></div><?php endif;?>
        <form method="post" class="form-card">
            <?=csrf_field()?>
            <label>Admin Email<input type="email" name="email" required autocomplete="username"></label>
            <label>Password
                <div class="password-field">
                    <input id="admin-login-password" type="password" name="password" required autocomplete="current-password">
                    <button class="password-toggle" type="button" aria-controls="admin-login-password" aria-label="Show password" aria-pressed="false">Show</button>
                </div>
            </label>
            <button class="btn btn-primary btn-block" type="submit">Login as Admin</button>
        </form>
        <p class="admin-login-back">Traveller? <a href="<?=url('auth/login.php')?>">Go to user login</a></p>
    </main>
</body>
</html>
