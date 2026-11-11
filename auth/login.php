<?php
require_once '../includes/functions.php';
if(logged_in())redirect_to_dashboard();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $account=authenticate_account($_POST['email']??'',$_POST['password']??'','user');
    if($account){
        session_regenerate_id(true);
        $_SESSION['user']=['id'=>$account['id'],'name'=>$account['name'],'email'=>$account['email'],'role'=>$account['role']];
        redirect('user/dashboard.php');
    }
    $error='Incorrect email or password, or this account is not a user account.';
}
$page_title='User Login';
require '../includes/header.php';
?>
<section class="auth-layout">
    <div class="auth-photo" style="background-image:url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=1200')">
        <h1>Welcome<br>back.</h1>
        <p>Sign in to save places and plan your Bangladesh adventures.</p>
    </div>
    <div class="auth-panel">
        <span class="green"><b>Traveller account</b></span>
        <h2>User Login</h2>
        <p class="muted">Access your favourites, trip plans and reviews.</p>
        <?php if($error):?><div class="alert"><?=e($error)?></div><?php endif;?>
        <form method="post" class="form-card">
            <?=csrf_field()?>
            <label>Email Address<input type="email" name="email" required autocomplete="username"></label>
            <label>Password
                <div class="password-field">
                    <input id="login-password" type="password" name="password" required autocomplete="current-password">
                    <button class="password-toggle" type="button" aria-controls="login-password" aria-label="Show password" aria-pressed="false">Show</button>
                </div>
            </label>
            <button class="btn btn-primary btn-block" type="submit">Login as User</button>
        </form>
        <p class="center">New here? <a href="register.php">Create a user account</a></p>
        <p class="center">Administrator? <a href="<?=url('admin/login.php')?>">Go to admin login</a></p>
    </div>
</section>
<?php require '../includes/footer.php';?>
