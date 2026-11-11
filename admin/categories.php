<?php
require_once '../includes/functions.php';
require_admin();

if(isset($_GET['delete'])){
    $pdo->prepare('DELETE FROM categories WHERE id=?')->execute([(int)$_GET['delete']]);
    redirect('admin/categories.php');
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $pdo->prepare('INSERT INTO categories(name,slug,description) VALUES(?,?,?)')->execute([
        trim($_POST['name']),
        strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/','-',$_POST['name']),'-')),
        trim($_POST['description'])
    ]);
    redirect('admin/categories.php');
}

$categories=$pdo->query('SELECT c.*,COUNT(p.id) total FROM categories c LEFT JOIN places p ON p.category_id=c.id GROUP BY c.id')->fetchAll();
$page_title='Manage Categories';
require 'header.php';
?>
<section class="section">
    <h1>Manage Categories</h1>
    <form method="post" class="inline-form">
        <?=csrf_field()?>
        <input name="name" required placeholder="Category name">
        <input name="description" placeholder="Short description">
        <button class="btn btn-primary">Add Category</button>
    </form>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Description</th><th>Places</th><th>Action</th></tr></thead>
            <tbody><?php foreach($categories as $category):?>
                <tr>
                    <td><?=e($category['name'])?></td>
                    <td><?=e($category['description'])?></td>
                    <td><?=$category['total']?></td>
                    <td><a class="btn btn-danger btn-small" onclick="return confirm('Delete category?')" href="?delete=<?=$category['id']?>">Delete</a></td>
                </tr>
            <?php endforeach;?></tbody>
        </table>
    </div>
</section>
<?php require 'footer.php';?>
