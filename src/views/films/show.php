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
    $director = $film['director'];
    $description = $film['description'];

    $html = <<<"EOT"
        <h5 class="section-title film-title">$title</h5>
        <h6 class="film-subtitle">
            <span class="release-year">$year</span>
            •
            <span class="film-genre-director">$genre</span>
            •
            <span class="film-genre-director">Directed by $director</span>
        </h6>
    EOT;
    $html .= ($description ? "<p class=\"text-white\">$description</p>" : '<p class="empty-text">No description.</p>');
    
    return $html;
}

function createReviewModal($filmId) {
    return <<<"EOT"
        <div class="modal-container" id="create-review-modal">
            <h2>Add Review</h2>
            <div class="form-card">
                <form class="form-container" id="create-review-form">
                    <input type="hidden" value="$filmId" name="film_id">
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select id="rating" name="rating">
                            <option value="" disabled selected>Rating</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <label class="form-error" id="rating-form-error"></label>
                    </div>
                    <div class="form-group">
                        <label for="">Review</label>
                        <textarea id="review" name="review" rows="8"></textarea>
                        <label class="form-error" id="review-form-error"></label>
                    </div>
                    <div class="btn-group">
                        <button class="btn-primary" id="create-review-btn">Add</button>
                        <button class="btn-danger" id="cancel-add-review-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        EOT;
}

function reviewList($reviews){
    $str = "";
    if(!empty($reviews)){
        foreach($reviews as $review){
            $name = $review['first_name'] . ' ' . $review['last_name'];
            $profilePicturePath = '/assets/users/' . ($review['profile_picture_path'] ?? 'blank.jpeg');
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
        return '<p class="empty-text">No reviews.</p>';
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
                if(isset($_SESSION['username'])) {
                    echo <<<"EOT"
                        <button class="btn-primary" type="button" id="add-review-btn">Add Review</button>
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
        <div class="modal-container" id="trailer-container">
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
        <?php echo createReviewModal($data['film']['id']) ?>
    </div>
</div>
<script defer src="/js/form-handler.js"></script>
<script defer src="/js/confirmation-modal.js"></script>
<script defer src="/js/film-detail.js"></script>
