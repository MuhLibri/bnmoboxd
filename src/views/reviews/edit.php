<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function showReview($review){
    $filmId = $review['film_id'];
    $title = $review['title'];
    $posterImagePath = '/assets/films/' . $review['image_path'];
    $reviewText = $review['review'];
    $rating = $review['rating'];
    $dtCreate = new DateTime($review['created_at']);
    $dtUpdate = new DateTime($review['updated_at']);
    $dateCreate = $dtCreate->format('M d, Y');
    $dateUpdate = $dtCreate != $dtUpdate ? ' • Updated on ' . $dtUpdate->format('M d, Y') : '';

    // Loop to add star images based on the rating value
    $html = <<<"EOT"
        <div class="edit-review-container">
            <form class="review-upper-section" id="review-form">
                <input type="hidden" id="film_id" name="film_id" value="$filmId">
                <img class="film-poster-edit" src="$posterImagePath">
                <div class="review-details">
                    <h6 class="film-title" id="ftr1">$title</h6>
                    <h6>
                        <span class="review-date">
                            $dateCreate
                            $dateUpdate
                        </span>
                    </h6>
                    <div class="edit-star">
                        {{star_radio}}
                    </div>
                    <div class="edit-text-box">
                        <textarea class="edit-textarea" id="review" name="review">$reviewText</textarea>
                    </div>
                </div>
            </form>
            <div class="btn-group">
                <button type="button" class="btn-primary" id="save">Save</button>
                <button type="button" class="btn-danger" id="delete">Delete</button>
                <!-- <button src="/assets/app/edit.png" class="review-button">Edit</button> -->
                <!-- <button class="review-button">Delete</button> -->
            </div>
        </div>
    EOT;

    $starsHtml = '<img src="/assets/app/star.png" alt="star" class="stars-img">';
    $starRadioHtml = '';
    for($i = 1; $i <= 5; $i++){
        $checked = $i == $rating ? ' checked' : '';
        $starRadioHtml .= <<<"EOT"
            <input type="radio" id="star$i" name="rating" value="$i" $checked class="review-radio">
            <label class="star-label" for="star$i">
                <div class="review-stars-container">$starsHtml $i</div>
            </label>
        EOT;
    }
    $html = str_replace('{{star_radio}}', $starRadioHtml, $html);

    return $html;
}

?>

<div class="base-container">
    <div class="edit-review">
        <div>
            <?php echo showReview($data['review']); ?>
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

<div class="modal-container" id="confirm-cancel-modal">
    <div class="confirmation-modal">
        <h2>Are you sure you want to cancel?</h2>
        <div class="btn-group">
            <button class="btn-primary" id="confirm-cancel-btn">Yes</button>
            <button class="btn-danger" onclick="handleClose('#confirm-cancel-modal')">Cancel</button>
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