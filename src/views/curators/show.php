<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function showCuratorProfile($data) {
    $name = "Lizaaa";
    $reviewCount = 5;
    $subscriber = $data['subscriber'];
    $profileImg = '/assets/users/blank.jpeg';
    $status = $data['status'];
    $html = <<<EOT
    <div class="curator-container" id="cc2">
        <div class="user-profile">
            <img alt="curator's profile" src="$profileImg">
        </div>
        <div class="curator-details">
            <h6>$name</h6>
            <h6 class="curator-info">$reviewCount review</h6>
            <h6 class="curator-info">$subscriber subscriber</h6>
        </div>
        <div class="btn-group">
            <button type="button" class="btn-subscribe" id="subscribe">$status</button>
        </div>
    </div>
    EOT;

    return $html;
}

function showCuratorReviews($data) {
    $str = "";
    $subscribed = $data['status'] == 'ACCEPTED';
    if ($subscribed) {
        $reviews = $data['reviews'];
        foreach($reviews as $review) {
            $name = $review['title'];
            $id = $review['id'];
            $filmPosterPath = '/assets/films/' . $review['image_path'];
            $reviewText = $review['review'];
            $rating = $review['rating'];
            $dtCreate = new DateTime($review['created_at']);
            $dtUpdate = new DateTime($review['updated_at']);
            $dateCreate = $dtCreate->format('M d, Y');
            $dateUpdate = $dtCreate != $dtUpdate ? ' • Updated on ' . $dtUpdate->format('M d, Y') : '';

            $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
            $html = <<<EOT
            <div class="review-container" id="review-container-flex">                                                                                                                                     
                <img alt="film poster" src="$filmPosterPath" class="poster-image">
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
            </div>
            EOT;
            $str = $str . $html;
        }
    }
    else {
        $str = <<<EOT
            <h6>You have not subscribed</h6>
        EOT;
    }

    return $str;
}

?>

<div class="base-container">
    <?php
        echo showCuratorProfile($data);
    ?>
    <h5 class="section-title">REVIEWS</h5>

    <div class="review-list" id="rl1">
        <?php
            echo showCuratorReviews($data);
        ?>
    </div>
</div>

<script defer src="/js/curators.js"></script>