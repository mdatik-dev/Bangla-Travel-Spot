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
require '../includes/header.php';
?>
<section class="auth-layout">
    <div class="auth-photo" style="background-image:linear-gradient(0deg,rgba(3,34,27,.56),rgba(3,34,27,.2)),url('https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=1200')">
        <h1>Admin<br>Portal</h1>
        <p>Manage destinations and keep Bangla Travel Spot running smoothly.</p>
    </div>
    <div class="auth-panel">
        <span class="green"><b>Restricted access</b></span>
        <h2>Administrator Login</h2>
        <p class="muted">Sign in with an active administrator account.</p>
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
        <p class="center">Traveller? <a href="<?=url('auth/login.php')?>">Go to user login</a></p>
    </div>
</section>
<?php require '../includes/footer.php';?>
