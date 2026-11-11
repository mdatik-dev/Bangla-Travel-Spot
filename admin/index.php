<?php require_once '../includes/functions.php';require_admin();$counts=[];foreach(['users','places','favorites','reviews'] as $t)$counts[$t]=$pdo->query("SELECT COUNT(*) FROM $t")->fetchColumn();$recent=$pdo->query('SELECT p.*,c.name category_name FROM places p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.created_at DESC LIMIT 6')->fetchAll();$page_title='Dashboard';require 'header.php';?>
<section class="admin-dashboard-page">
    <h1>Admin Dashboard</h1>
    <div class="stats-grid">
        <div class="stat-card"><span aria-hidden="true">♙</span><b><?=$counts['users']?></b><small>Total Users</small></div>
        <div class="stat-card"><span aria-hidden="true">⌖</span><b><?=$counts['places']?></b><small>Total Places</small></div>
        <div class="stat-card"><span aria-hidden="true">★</span><b><?=$counts['favorites']?></b><small>Total Favorites</small></div>
    </div>
    <div class="section-heading"><h2>Recent Places</h2><a href="<?=url('admin/places.php')?>">Manage all →</a></div>
    <div class="table-wrap"><table><thead><tr><th>Name</th><th>Category</th><th>Location</th><th>Status</th><th>Action</th></tr></thead><tbody><?php foreach($recent as $p):?><tr><td><?=e($p['name'])?></td><td><?=e($p['category_name'])?></td><td><?=e($p['district'])?></td><td><?=e($p['status'])?></td><td><a class="btn btn-outline btn-small" href="<?=url('admin/places.php?edit='.$p['id'])?>">Edit</a></td></tr><?php endforeach;?></tbody></table></div>
</section>
<?php require 'footer.php';?>
