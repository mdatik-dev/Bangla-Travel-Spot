<?php
require_once '../includes/functions.php';
require_admin();

if(isset($_GET['toggle'])){
    $id=(int)$_GET['toggle'];
    if($id!==user()['id']){
        $pdo->prepare("UPDATE users SET status=IF(status='active','blocked','active') WHERE id=?")->execute([$id]);
    }
    redirect('admin/users.php');
}

$users=$pdo->query('SELECT id,name,email,role,status,created_at FROM users ORDER BY created_at DESC')->fetchAll();
$page_title='Manage Users';
require 'header.php';
?>
<section class="section">
    <h1>Manage Users</h1>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th><th>Action</th></tr></thead>
            <tbody><?php foreach($users as $account):?>
                <tr>
                    <td><?=e($account['name'])?></td>
                    <td><?=e($account['email'])?></td>
                    <td><?=e($account['role'])?></td>
                    <td><?=e($account['status'])?></td>
                    <td><?=e($account['created_at'])?></td>
                    <td><?php if($account['id']!==user()['id']):?>
                        <a class="btn btn-outline btn-small" href="?toggle=<?=$account['id']?>"><?=$account['status']==='active'?'Block':'Activate'?></a>
                    <?php endif;?></td>
                </tr>
            <?php endforeach;?></tbody>
        </table>
    </div>
</section>
<?php require 'footer.php';?>
