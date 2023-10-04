<?php
use app\core\Application;
include_once Application::$BASE_DIR . '/src/views/components/navbar.php';
?>

<div class="base-container" id="reviews-page-container">
    <h5 class="section-title" id="t1">MY REVIEWS</h5>
    <div class="review-list" id="rl1">
        <?php
        include Application::$BASE_DIR . '/src/views/components/review-list.php';
        ?>
    </div>
</div>

<script defer src="/js/reviews.js"></script>