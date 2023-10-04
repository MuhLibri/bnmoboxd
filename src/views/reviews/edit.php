<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function showReview($review){
    $str = "";
    // $name = $review['first_name'] . ' ' . $review['last_name'];
    // $profilePicturePath = '/assets/users/' . $review['profile_picture_path'];
    // $reviewText = $review['review'];
    // $rating = $review['rating'];
    // $dtCreate = new DateTime($review['created_at']);
    // $dtUpdate = new DateTime($review['updated_at']);
    // $dateCreate = $dtCreate->format('M d, Y');
    // $dateUpdate = $dtCreate != $dtUpdate ? ' • Updated on ' . $dtUpdate->format('M d, Y') : '';
    $name = $review['title'];
    $filmPosterPath = '/assets/films/' . $review['image_path'];
    $reviewText = $review['review'];
    $rating = $review['rating'];
    $dtCreate = new DateTime($review['updated_at'] ?? $review['created_at']);
    $dateCreate = $dtCreate->format('M d, Y');

    $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
    $html = <<<"EOT"
        <div class="edit-review-container">
            <div class="film-poster">
                <img src="$filmPosterPath">
            </div>
            <div class="review-details">
                <h6>
                    $name
                    <span class="review-date">
                        $dateCreate
                    </span>
                </h6>
                <div class="review-stars-container">$starsHtml</div>
                <p>$reviewText</p>
            </div>
        </div>
    EOT;
    $str = $str . $html;
    return $str;
}

?>

<div class="base-container">
    <div class="edit-review">
        <div>
            <?php echo showReview($data['reviewData']) ?>
        </div>
        <div class="review-button-container">
            <input type="image" class="review-button" src="/assets/app/edit.png" name="Edit"/>
            <input type="image" class="review-button" src="/assets/app/delete.png" name="Edit"/>
            <!-- <button src="/assets/app/edit.png" class="review-button">Edit</button> -->
            <!-- <button class="review-button">Delete</button> -->
        </div>
    </div>
</div>

<script defer src="/js/reviews.js"></script>