<?php

use app\core\Application;

$str = '';
if(!empty($data['reviews'])){
    $reviews = $data['reviews'];
    foreach($reviews as $review) {
        $name = $review['title'];
        $id = $review['id'];
        $filmPosterPath = '/assets/films/' . $review['image_path'];
        $reviewText = $review['review'];
        $rating = $review['rating'];
        // $dtCreate = new DateTime($review['updated_at'] ?? $review['created_at']);
        $dtCreate = new DateTime($review['created_at']);
        $dtUpdate = new DateTime($review['updated_at']);
        $dateCreate = $dtCreate->format('M d, Y');
        $dateUpdate = $dtCreate != $dtUpdate ? ' • Updated on ' . $dtUpdate->format('M d, Y') : '';

        $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
        $html = <<<EOT
<a href="/my-reviews/$id" class="review-container" id="review-container-flex">                                                                                                                                     
    <img src="$filmPosterPath" class="poster-image">
    <div class="review-details">
        <h6>
            $name
            <span class="review-date">
                $dateCreate
                $dateUpdate
            </span>
        </h6>
        <div class="review-stars-container">$starsHtml</div>
        <p>$reviewText</p>
    </div>
</a>
EOT;
        $str = $str . $html;
    }
    echo $str;
}
else {
    echo '<p class="empty-text">No reviews.</p>';
}

if (isset($data['count']) && isset($data['currentPage'])) {
    include Application::$BASE_DIR . '/src/views/components/pagination.php';
}