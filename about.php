<?php $page_title='About Us';$page_stylesheet='assets/css/about.css';require 'includes/header.php';?>
<section class="about-hero" style="background-image:linear-gradient(90deg,rgba(3,34,27,.76),rgba(3,34,27,.24)),url('https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=2000&auto=format&fit=crop')">
    <div class="about-hero-inner">
        <span class="about-kicker"><span aria-hidden="true">✦</span> ABOUT BANGLA TRAVEL SPOT</span>
        <h1>Every journey starts<br>with a little curiosity.</h1>
        <p>We make it easier to discover the places, stories and experiences that make Bangladesh unforgettable.</p>
        <a class="btn btn-primary" href="<?=url('destinations.php')?>">Explore destinations <span aria-hidden="true">→</span></a>
    </div>
</section>
<section class="about-story">
    <div class="about-story-image">
        <img src="<?=url('assets/images/bangladesh-map.png')?>" alt="Illustrated district and divisional map of Bangladesh" loading="lazy">
        <div class="about-image-note">
            <span aria-hidden="true">⌖</span>
            <span><b>One beautiful country</b><small>64 districts, countless places to explore</small></span>
        </div>
    </div>
    <div class="about-story-copy">
        <span class="about-section-label">A little about us</span>
        <h2>See Bangladesh with a traveller’s eye.</h2>
        <p>Bangla Travel Spot is a destination discovery and trip-planning platform created to help you find your next favourite place—from beaches and green hills to forests, heritage sites and local experiences.</p>
        <p>Find practical destination guides, get ideas for where to stay and what to do, and keep your favourite places and trip plans together in one account.</p>
        <a class="about-text-link" href="<?=url('destinations.php')?>">Find your next destination <span aria-hidden="true">→</span></a>
    </div>
</section>
<section class="about-benefits">
    <div class="about-benefits-inner">
        <div class="about-benefits-heading">
            <span class="about-section-label">Made for your next trip</span>
            <h2>From the first idea to the journey home.</h2>
            <p>Everything you need to start planning your Bangladesh adventure.</p>
        </div>
        <div class="about-card-grid">
            <article class="about-card"><span class="about-card-icon" aria-hidden="true">⌕</span><h3>Discover</h3><p>Browse places across Bangladesh and find the experience that feels right for you.</p></article>
            <article class="about-card"><span class="about-card-icon" aria-hidden="true">◇</span><h3>Plan</h3><p>Keep dates, travel companions and budgets organised in your trip plans.</p></article>
            <article class="about-card"><span class="about-card-icon" aria-hidden="true">♡</span><h3>Share</h3><p>Save favourite destinations and share your experience through traveller reviews.</p></article>
        </div>
    </div>
</section>
<section class="about-cta">
    <div><span class="about-section-label">Your next story is out there</span><h2>Ready to explore Bangladesh?</h2><p>Find a place you love and start planning your next trip.</p></div>
    <a class="btn btn-white" href="<?=url('destinations.php')?>">Browse destinations <span aria-hidden="true">→</span></a>
</section>
<?php require 'includes/footer.php';?>
