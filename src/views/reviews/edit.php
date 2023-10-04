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
    $name = "Star Wars a New Hope";
    $profilePicturePath = '/assets/films/star-wars-a-new-hope.jpeg';
    $reviewText = "suka baliik";
    $rating = 1;
    $dtCreate = new DateTime(date_default_timezone_get());
    $dtUpdate = new DateTime(date_default_timezone_get());
    $dateCreate = $dtCreate->format('M d, Y');
    $dateUpdate = '';

    // Loop to add star images based on the rating value
    $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
    $html = <<<"EOT"
        <div class="edit-review-container">
            <div class="review-upper-section">
                <img class="film-poster-edit" src="$profilePicturePath">
                <div class="review-details">
                <h6 class="film-title" id="ftr1">$name</h6>
                <h6>
                    <span class="review-date">
                        $dateCreate
                        $dateUpdate
                    </span>
                </h6>
                <div class="edit-star">
                    <input type="radio" name="star" id="star1" value="1">
                    <label class="star-label" for="star1">
                        <div class="review-stars-container">$starsHtml 1</div>
                    </label>

                    <input type="radio" name="star" id="star2" value="2">
                    <label class="star-label" for="star2">
                        <div class="review-stars-container">$starsHtml 2</div>
                    </label>

                    <input type="radio" name="star" id="star3" value="3">
                    <label class="star-label" for="star3">
                        <div class="review-stars-container">$starsHtml 3</div>
                    </label>

                    <input type="radio" name="star" id="star4" value="4">
                    <label class="star-label" for="star4">
                        <div class="review-stars-container">$starsHtml 4</div>                    
                    </label>

                    <input type="radio" name="star" id="star5" value="5" checked>
                    <label class="star-label" for="star5">
                        <div class="review-stars-container">$starsHtml 5</div>
                    </label>
                </div>
                <div class="edit-text-box">
                    <textarea class="edit-textarea">$reviewText</textarea>
                </div>
            </div>
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
            <?php echo showReview(1) ?>
        </div>
        <div class="review-button-container">
            <input type="image" class="review-button" id="save" src="/assets/app/save-review.png" name="Save"/>
            <input type="image" class="review-button" id="delete" src="/assets/app/delete.png" name="Delete"/>
            <!-- <button src="/assets/app/edit.png" class="review-button">Edit</button> -->
            <!-- <button class="review-button">Delete</button> -->
        </div>
    </div>
</div>

<div class="modal-container" id="confirm-edit-modal">
    <div class="confirmation-modal">
        <h2>Are you sure you want to edit your review?</h2>
        <div class="btn-group">
            <button class="btn-primary" id="confirm-edit-btn">Yes</button>
            <button class="btn-danger" onclick="handleClose('#confirm-edit-modal')">Cancel</button>
        </div>
    </div>
</div>

<div class="modal-container" id="confirm-delete-modal">
    <div class="confirmation-modal">
        <h2>Are you sure you want to delete your review?</h2>
        <div class="btn-group">
            <button class="btn-primary" id="confirm-delete-btn">Yes</button>
            <button class="btn-danger" onclick="handleClose('#confirm-delete-modal')">Cancel</button>
        </div>
    </div>
</div>

<script defer src="/js/reviews.js"></script>
<script defer src="/js/confirmation-modal.js"></script>   
<script defer src="/js/form-handler.js"></script>