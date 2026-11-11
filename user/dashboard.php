<?php
require_once '../includes/functions.php';
require_user();

$uid=user()['id'];
$count=$pdo->prepare('SELECT COUNT(*) FROM favorites WHERE user_id=?');
$count->execute([$uid]);
$fav=(int)$count->fetchColumn();
$count=$pdo->prepare('SELECT COUNT(*) FROM trips WHERE user_id=?');
$count->execute([$uid]);
$tripcount=(int)$count->fetchColumn();
$count=$pdo->prepare('SELECT COUNT(*) FROM reviews WHERE user_id=?');
$count->execute([$uid]);
$reviewcount=(int)$count->fetchColumn();

$query=$pdo->prepare('SELECT p.* FROM favorites f JOIN places p ON p.id=f.place_id WHERE f.user_id=? ORDER BY f.created_at DESC LIMIT 3');
$query->execute([$uid]);
$favorites=$query->fetchAll();

$query=$pdo->prepare('SELECT t.*,p.name,p.cover_image FROM trips t JOIN places p ON p.id=t.place_id WHERE t.user_id=? AND t.trip_date>=CURDATE() ORDER BY t.trip_date LIMIT 3');
$query->execute([$uid]);
$trips=$query->fetchAll();

$page_title='My Dashboard';
$page_stylesheet='assets/css/user-dashboard.css';
require '../includes/header.php';
?>
<section class="dashboard-layout user-dashboard-layout">
    <aside class="sidebar">
        <div class="profile-mini">
            <div class="avatar" aria-hidden="true">☺</div>
            <b>Welcome, <?=e(user()['name'])?></b>
            <small><?=e(user()['email'])?></small>
        </div>
        <a class="selected" href="dashboard.php">▦ Dashboard</a>
        <a href="favorites.php">♡ My Favorites</a>
        <a href="trips.php">▣ My Trip Plan</a>
        <a href="reviews.php">★ Reviews</a>
        <a href="profile.php">⚙ Profile Settings</a>
        <a href="<?=url('auth/logout.php')?>">↪ Logout</a>
    </aside>

    <div class="dashboard-main user-dashboard-main">
        <div class="user-dashboard-heading">
            <div>
                <span class="dashboard-eyebrow">YOUR TRAVEL SPACE</span>
                <h1>Welcome back, <?=e(user()['name'])?>!</h1>
                <p>Your next Bangladesh adventure starts with a little inspiration.</p>
            </div>
            <a class="btn btn-primary" href="<?=url('destinations.php')?>">Explore destinations <span aria-hidden="true">→</span></a>
        </div>

        <div class="stats-grid user-stats-grid">
            <a class="stat-card" href="favorites.php"><span aria-hidden="true">♡</span><b><?=$fav?></b><small>Saved favourites</small></a>
            <a class="stat-card" href="trips.php"><span aria-hidden="true">▣</span><b><?=$tripcount?></b><small>Planned trips</small></a>
            <a class="stat-card" href="reviews.php"><span aria-hidden="true">★</span><b><?=$reviewcount?></b><small>Your reviews</small></a>
        </div>

        <section class="dashboard-panel" aria-labelledby="favorite-heading">
            <div class="dashboard-panel-heading">
                <div>
                    <span class="dashboard-eyebrow">YOUR SHORTLIST</span>
                    <h2 id="favorite-heading">My Favorites</h2>
                    <p>Keep the places you love close at hand.</p>
                </div>
                <a class="dashboard-view-link" href="favorites.php">View all <span aria-hidden="true">→</span></a>
            </div>
            <?php if($favorites):?>
                <div class="mini-grid user-favorite-grid">
                    <?php foreach($favorites as $place):?>
                        <a class="place-card" href="<?=url('place.php?slug='.urlencode($place['slug']))?>">
                            <div class="place-image"><img src="<?=e(image_url($place['cover_image']))?>" alt="<?=e($place['name'])?>" loading="lazy"></div>
                            <div class="place-info"><b><?=e($place['name'])?></b><small><?=e($place['district'])?></small></div>
                        </a>
                    <?php endforeach;?>
                </div>
            <?php else:?>
                <div class="dashboard-empty-state">
                    <span class="dashboard-empty-icon" aria-hidden="true">♡</span>
                    <div>
                        <h3>Your next favourite place is out there</h3>
                        <p>Save destinations that catch your eye and they’ll show up here.</p>
                    </div>
                    <a class="btn btn-outline btn-small" href="<?=url('destinations.php')?>">Discover places <span aria-hidden="true">→</span></a>
                </div>
            <?php endif;?>
        </section>

        <section class="dashboard-panel" aria-labelledby="trips-heading">
            <div class="dashboard-panel-heading">
                <div>
                    <span class="dashboard-eyebrow">THE JOURNEY AHEAD</span>
                    <h2 id="trips-heading">Upcoming Trips</h2>
                    <p>Your plans, all in one place.</p>
                </div>
                <a class="dashboard-view-link" href="trips.php">View all <span aria-hidden="true">→</span></a>
            </div>
            <?php if($trips):?>
                <div class="user-trip-list">
                    <?php foreach($trips as $trip):?>
                        <a class="user-trip-card" href="<?=url('user/trips.php')?>">
                            <img src="<?=e(image_url($trip['cover_image']))?>" alt="" loading="lazy">
                            <span class="user-trip-details">
                                <b><?=e($trip['name'])?></b>
                                <small><?=e(date('M j, Y',strtotime($trip['trip_date'])))?> · <?=$trip['people']?> people · <?=money($trip['budget'])?></small>
                            </span>
                            <span class="user-trip-arrow" aria-hidden="true">→</span>
                        </a>
                    <?php endforeach;?>
                </div>
            <?php else:?>
                <div class="dashboard-empty-state trip-empty-state">
                    <span class="dashboard-empty-icon" aria-hidden="true">✈</span>
                    <div>
                        <h3>Give your next getaway a date</h3>
                        <p>Start a trip plan to keep your destination, date and budget together.</p>
                    </div>
                    <a class="btn btn-primary btn-small" href="<?=url('user/trips.php')?>">Plan a trip <span aria-hidden="true">→</span></a>
                </div>
            <?php endif;?>
        </section>
    </div>
</section>
<?php require '../includes/footer.php';?>
