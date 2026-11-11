<?php
require_once '../includes/functions.php';
require_admin();

if(isset($_GET['approve'])){
    $pdo->prepare('UPDATE reviews SET status="approved" WHERE id=?')->execute([(int)$_GET['approve']]);
}
if(isset($_GET['delete'])){
    $pdo->prepare('DELETE FROM reviews WHERE id=?')->execute([(int)$_GET['delete']]);
}

$reviews=$pdo->query('SELECT r.*,u.name user_name,p.name place_name FROM reviews r JOIN users u ON u.id=r.user_id JOIN places p ON p.id=r.place_id ORDER BY r.created_at DESC')->fetchAll();
$page_title='Manage Reviews';
require 'header.php';
?>
<section class="section">
    <h1>Manage Reviews</h1>
    <div class="table-wrap">
        <table>
            <thead><tr><th>User</th><th>Destination</th><th>Rating</th><th>Comment</th><th>Status</th><th>Action</th></tr></thead>
            <tbody><?php foreach($reviews as $review):?>
                <tr>
                    <td><?=e($review['user_name'])?></td>
                    <td><?=e($review['place_name'])?></td>
                    <td>★ <?=$review['rating']?></td>
                    <td><?=e($review['comment'])?></td>
                    <td><?=e($review['status'])?></td>
                    <td><?php if($review['status']!=='approved'):?>
                        <a class="btn btn-primary btn-small" href="?approve=<?=$review['id']?>">Approve</a>
                    <?php endif;?>
                        <a class="btn btn-danger btn-small" onclick="return confirm('Delete review?')" href="?delete=<?=$review['id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach;?></tbody>
        </table>
    </div>
</section>
<?php require 'footer.php';?>
