<?php
require_once __DIR__.'/../includes/functions.php';
require_admin();
$admin_page=basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=e($page_title??'Admin')?> | Bangla Travel Spot Admin</title>
    <link rel="stylesheet" href="<?=url('assets/css/style.css')?>">
    <link rel="stylesheet" href="<?=url('admin/admin.css')?>">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="<?=url('admin/index.php')?>">
            <span class="admin-brand-mark" aria-hidden="true">◆</span>
            <span>Bangla Travel Spot<small>ADMIN CONSOLE</small></span>
        </a>
        <div class="admin-account">
            <span class="admin-avatar" aria-hidden="true"><?=e(strtoupper(substr(user()['name'],0,1)))?></span>
            <span><b><?=e(user()['name'])?></b><small>Main administrator</small></span>
        </div>
        <span class="admin-nav-label">WORKSPACE</span>
        <nav class="admin-nav" aria-label="Admin navigation">
            <a class="<?=$admin_page==='index.php'?'active':''?>" href="<?=url('admin/index.php')?>"><span aria-hidden="true">▦</span>Dashboard</a>
            <a class="<?=$admin_page==='places.php'?'active':''?>" href="<?=url('admin/places.php')?>"><span aria-hidden="true">⌖</span>Manage Places</a>
            <a class="<?=$admin_page==='categories.php'?'active':''?>" href="<?=url('admin/categories.php')?>"><span aria-hidden="true">▤</span>Categories</a>
            <a class="<?=$admin_page==='users.php'?'active':''?>" href="<?=url('admin/users.php')?>"><span aria-hidden="true">♙</span>Manage Users</a>
            <a class="<?=$admin_page==='reviews.php'?'active':''?>" href="<?=url('admin/reviews.php')?>"><span aria-hidden="true">★</span>Manage Reviews</a>
            <a class="<?=$admin_page==='messages.php'?'active':''?>" href="<?=url('admin/messages.php')?>"><span aria-hidden="true">✉</span>Messages</a>
        </nav>
        <div class="admin-sidebar-bottom">
            <a href="<?=url('index.php')?>"><span aria-hidden="true">↗</span>View website</a>
            <a class="admin-logout" href="<?=url('auth/logout.php')?>"><span aria-hidden="true">↪</span>Logout</a>
        </div>
    </aside>
    <div class="admin-workspace">
        <header class="admin-topbar">
            <div><span class="admin-topbar-label">ADMINISTRATION</span><b><?=e($page_title??'Admin Dashboard')?></b></div>
            <a class="admin-topbar-account" href="<?=url('admin/users.php')?>"><span class="admin-topbar-avatar" aria-hidden="true"><?=e(strtoupper(substr(user()['name'],0,1)))?></span><span><?=e(user()['name'])?></span></a>
        </header>
        <main class="admin-main">
            <?=flash()?>
