<?php
    include __DIR__ . '/components/navbar.php';
    include __DIR__ . '/components/dashboard/film-card.php';

?>
<div class="base-container">
    <div>
        <h5 class="section-title">🎥 MUST WATCH! 🎥</h5>
        <div class="film-poster-list">
            <?php
            include __DIR__ . '/components/film-posters.php';
            ?>
        </div>
    </div>
    <div>
        <h5 class="section-title">🙌 CHECK OUT THE LATEST REVIEWS! 🙌</h5>
        <div class="review-list">
            <?php
            echo filmCard($data["filmReviews"])
            ?>
        </div>
    </div>
</div>


