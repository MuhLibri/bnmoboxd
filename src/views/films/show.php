<?php

use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function filmPosterImage($film){
    $title = $film['title'];
    $path = '/assets/films/' . $film['image_path'];

    return "<img src=\"$path\" alt=\"$title\" class=\"poster-image\">";
}

function filmInfo($film){
    $title = $film['title'];
    $year = $film['release_year'];
    $genre = $film['genre'];
    $description = $film['description'];

    return <<<"EOT"
        <div class="film-title-description">
            <h5 class="section-title film-title">$title</h5>
            <h6 class="film-subtitle">
                <span class="release-year">$year</span>
                •
                <span class="film-genre">$genre</span>
            </h6>
            <p class="text-white">$description</p>
        </div>
    EOT;
}

function reviewList($reviews){
    $str = "";
    if(!empty($reviews)){
        foreach($reviews as $review){
            $name = $review['first_name'] . ' ' . $review['last_name'];
            $profilePicturePath = '/assets/users/' . $review['profile_picture_path'];
            $reviewText = $review['review'];
            $rating = $review['rating'];
            $dtCreate = new DateTime($review['created_at']);
            $dtUpdate = new DateTime($review['updated_at']);
            $dateCreate = $dtCreate->format('M d, Y');
            $dateUpdate = $dtCreate != $dtUpdate ? ' • Updated on ' . $dtUpdate->format('M d, Y') : '';

            // Loop to add star images based on the rating value
            $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
            $html = <<<"EOT"
                <div class="review-container">
                    <div class="profile-picture">
                        <img src="$profilePicturePath">
                    </div>
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
    if(empty($str)){
        return <<<"EOT"
            <p class="review-empty-text">No reviews.</p>
        EOT;
    }
    return $str;
}
?>
<div class="base-container display-grid">
    <div class="film-page-container">
        <div class="film-poster-col">
            <?php
                echo filmPosterImage($data['film']);
                if($data['admin']){
                    $id = $data['film']['id'];
                    echo <<<"EOT"
                        <a href="/film/$id/edit">
                            <button class="btn-primary" type="button">Edit</button>
                        </a>
                    EOT;
                }
                if(isset($data['film']['video_path'])) {
                    echo '<button class="btn-primary" id="watch-trailer-btn">Watch Trailer</button>';
                }
            ?>
        </div>

        <div class="film-details-col">
            <div class="film-title-description">
                <?php echo filmInfo($data['film']); ?>
            </div>
            <div class="film-reviews">
                <h5 class="section-title">Reviews</h5>
                <?php echo reviewList($data['reviews']); ?>
            </div>
        </div>
        <div class="trailer-container" id="trailer-container">
            <?php
            if (isset($data['film']['video_path'])) {
                $videoPath = '/assets/videos/' . $data['film']['video_path'];
                echo <<<"EOT"
                            <video controls class="video-player" id="video-player"><source src="$videoPath" type="video/mp4"></video>
                        EOT;
            }
            ?>
            <button class="btn-danger" id="close-trailer-btn">Close</button>
        </div>
    </div>
</div>
<script defer src="/js/film-detail.js"></script>
