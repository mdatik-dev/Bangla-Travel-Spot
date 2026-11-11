<?php
require_once 'includes/functions.php';
$page_title='Contact';
$page_stylesheet='assets/css/contact.css';
if($_SERVER['REQUEST_METHOD']==='POST'){
    verify_csrf();
    $s=$pdo->prepare('INSERT INTO contact_messages(name,email,subject,message) VALUES(?,?,?,?)');
    $s->execute([trim($_POST['name']),trim($_POST['email']),trim($_POST['subject']),trim($_POST['message'])]);
    $_SESSION['flash']='Your message has been sent. Thank you!';
    redirect('contact.php');
}
require 'includes/header.php';
?>
<section class="contact-hero">
    <div class="contact-hero-inner">
        <span class="contact-kicker"><span aria-hidden="true">✦</span> WE’RE HERE TO HELP</span>
        <h1>Let’s talk about<br>your next journey.</h1>
        <p>Questions, suggestions, or a destination you think we should know about? Send us a message.</p>
    </div>
</section>
<section class="contact-layout">
    <div class="contact-intro">
        <span class="contact-section-label">Get in touch</span>
        <h2>We’d love to hear from you.</h2>
        <p class="contact-description">Use the form to share your question or idea. Our team will get back to you as soon as possible.</p>
        <div class="contact-info-card">
            <span class="contact-info-icon" aria-hidden="true">✉</span>
            <div><h3>Send us a message</h3><p>Have a question about a destination or using the site? We’re listening.</p></div>
        </div>
        <div class="contact-info-card">
            <span class="contact-info-icon" aria-hidden="true">⌖</span>
            <div><h3>Share a local tip</h3><p>Know a hidden gem or have an idea that could help fellow travellers? Tell us about it.</p></div>
        </div>
        <div class="contact-note"><span aria-hidden="true">♡</span> Every great trip starts with a conversation.</div>
    </div>
    <form method="post" class="contact-form">
        <div class="contact-form-heading"><span class="contact-section-label">Write to us</span><h2>Send a message</h2><p>Fill in the details below and we’ll be in touch.</p></div>
        <?=csrf_field()?>
        <div class="contact-form-row">
            <label>Your name<input name="name" required autocomplete="name" placeholder="How should we address you?"></label>
            <label>Email address<input type="email" name="email" required autocomplete="email" placeholder="you@example.com"></label>
        </div>
        <label>Subject<input name="subject" required placeholder="What would you like to talk about?"></label>
        <label>Message<textarea name="message" rows="5" required placeholder="Write your message here..."></textarea></label>
        <button class="btn btn-primary contact-submit" type="submit">Send message <span aria-hidden="true">→</span></button>
    </form>
</section>
<?php require 'includes/footer.php';?>
