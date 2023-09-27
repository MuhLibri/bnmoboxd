<?php
    include __DIR__ . '/components/navbar.php';
    include __DIR__ . '/components/dashboard/film-card.php';
    include __DIR__ . '/components/dashboard/film-posters.php';
?>
<div class="dashboard-content">
    <div>
        <h5 class="section-title">MUST WATCH!</h5>
        <div class="film-poster-list">
            <?php
            echo filmPosters($data["films"])
            ?>
        </div>
    </div>
    <div>
        <h5 class="section-title">CHECK OUT THE LATEST REVIEWS!</h5>
        <div class="review-list">
            <?php
            echo filmCard($data["filmReviews"])
            ?>
        </div>
    </div>
</div>


