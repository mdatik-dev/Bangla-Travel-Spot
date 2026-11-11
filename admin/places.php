<?php
require_once '../includes/functions.php';
require_admin();

$categories=$pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
$edit=null;
if(isset($_GET['edit'])){
    $query=$pdo->prepare('SELECT * FROM places WHERE id=?');
    $query->execute([(int)$_GET['edit']]);
    $edit=$query->fetch();
}
if(isset($_GET['delete'])){
    $pdo->prepare('DELETE FROM places WHERE id=?')->execute([(int)$_GET['delete']]);
    redirect('admin/places.php');
}
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $id=(int)($_POST['id']??0);
    $name=trim($_POST['name']);
    $slug=trim($_POST['slug'])?:strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/','-',$name),'-'));
    $data=[
        $name,$slug,(int)$_POST['category_id'],trim($_POST['district']),trim($_POST['description']),
        trim($_POST['how_to_go']),trim($_POST['where_to_stay']),trim($_POST['things_to_do']),
        trim($_POST['best_time']),(float)$_POST['estimated_budget'],trim($_POST['cover_image']),
        $_POST['status'],isset($_POST['featured'])?1:0
    ];
    if($id){
        $data[]=$id;
        $pdo->prepare('UPDATE places SET name=?,slug=?,category_id=?,district=?,description=?,how_to_go=?,where_to_stay=?,things_to_do=?,best_time=?,estimated_budget=?,cover_image=?,status=?,featured=? WHERE id=?')->execute($data);
    }else{
        $pdo->prepare('INSERT INTO places(name,slug,category_id,district,description,how_to_go,where_to_stay,things_to_do,best_time,estimated_budget,cover_image,status,featured) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)')->execute($data);
    }
    redirect('admin/places.php');
}

$places=$pdo->query('SELECT p.*,c.name category_name FROM places p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.created_at DESC')->fetchAll();
$page_title='Manage Places';
require 'header.php';
?>
<section class="section">
    <h1>Manage Places</h1>
    <div class="admin-form">
        <h2><?=$edit?'Edit':'Add New'?> Destination</h2>
        <form method="post" class="form-grid">
            <?=csrf_field()?>
            <input type="hidden" name="id" value="<?=e($edit['id']??'')?>">
            <label>Place Name<input name="name" required value="<?=e($edit['name']??'')?>"></label>
            <label>URL Slug<input name="slug" value="<?=e($edit['slug']??'')?>" placeholder="auto-generated if blank"></label>
            <label>Category<select name="category_id" required><?php foreach($categories as $category):?>
                <option value="<?=$category['id']?>" <?=($edit['category_id']??'')==$category['id']?'selected':''?>><?=e($category['name'])?></option>
            <?php endforeach;?></select></label>
            <label>District<input name="district" required value="<?=e($edit['district']??'')?>"></label>
            <label class="full">Description<textarea name="description" rows="3"><?=e($edit['description']??'')?></textarea></label>
            <label class="full">How to Go<textarea name="how_to_go"><?=e($edit['how_to_go']??'')?></textarea></label>
            <label class="full">Where to Stay<textarea name="where_to_stay"><?=e($edit['where_to_stay']??'')?></textarea></label>
            <label class="full">Things to Do<textarea name="things_to_do"><?=e($edit['things_to_do']??'')?></textarea></label>
            <label>Best Time<input name="best_time" value="<?=e($edit['best_time']??'October – March')?>"></label>
            <label>Estimated Budget (৳)<input type="number" name="estimated_budget" min="0" value="<?=e($edit['estimated_budget']??0)?>"></label>
            <label class="full">Cover Image URL or uploads path<input name="cover_image" value="<?=e($edit['cover_image']??'')?>" placeholder="https://... or uploads/places/image.jpg"></label>
            <label>Status<select name="status">
                <option value="published" <?=($edit['status']??'published')==='published'?'selected':''?>>Published</option>
                <option value="draft" <?=($edit['status']??'')==='draft'?'selected':''?>>Draft</option>
            </select></label>
            <label class="check-label"><input type="checkbox" name="featured" <?=($edit['featured']??0)?'checked':''?>> Featured destination</label>
            <div class="full">
                <button class="btn btn-primary">Save Destination</button>
                <?php if($edit):?><a class="btn btn-outline" href="places.php">Cancel</a><?php endif;?>
            </div>
        </form>
    </div>
    <h2>All Destinations</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Category</th><th>District</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody><?php foreach($places as $place):?>
                <tr>
                    <td><?=e($place['name'])?></td>
                    <td><?=e($place['category_name'])?></td>
                    <td><?=e($place['district'])?></td>
                    <td><?=e($place['status'])?></td>
                    <td><a class="btn btn-outline btn-small" href="?edit=<?=$place['id']?>">Edit</a>
                        <a class="btn btn-danger btn-small" onclick="return confirm('Delete this place?')" href="?delete=<?=$place['id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach;?></tbody>
        </table>
    </div>
</section>
<?php require 'footer.php';?>
