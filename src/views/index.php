<?php

use app\core\Application;
include Application::$BASE_DIR . '/src/views/components/navbar.php';
include_once Application::$BASE_DIR .  '/src/views/components/dashboard/film-card.php';
?>
<div class="base-container">
    <div>
        <h5 class="section-title">🎥 MUST WATCH! 🎥</h5>
        <div class="film-poster-list">
            <?php
            include Application::$BASE_DIR . '/src/views/components/film-posters.php';
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


