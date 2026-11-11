<?php
require_once '../includes/functions.php';
require_admin();

$messages=$pdo->query('SELECT * FROM contact_messages ORDER BY created_at DESC')->fetchAll();
$page_title='Messages';
require 'header.php';
?>
<section class="section">
    <h1>Contact Messages</h1>
    <?php if(!$messages):?>
        <div class="empty-state">No messages yet.</div>
    <?php else:?>
        <?php foreach($messages as $message):?>
            <article class="review">
                <b><?=e($message['subject'])?> · <?=e($message['name'])?> (<?=e($message['email'])?>)</b>
                <p><?=nl2br(e($message['message']))?></p>
                <small><?=e($message['created_at'])?></small>
            </article>
        <?php endforeach;?>
    <?php endif;?>
</section>
<?php require 'footer.php';?>
