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
        <div class="subscribe-section">
        <div class="inner-subscribe">
            <h6 class="status-text">$status</h6>
    EOT;

    if ($status == "Not Subscribed") {
        $html = $html . <<<EOT
                    <button type="button" class="btn-subscribe" id="subscribe">Subscribe</button>
                </div>
            </div>
            <div class="modal-container" id="confirm-subscribe-modal">
                <div class="confirmation-modal">
                    <h2>Are you sure you want to Subscribe?</h2>
                    <div class="btn-group">
                        <button type="button" class="btn-primary" id="confirm-subscribe-btn">Yes</button>
                        <button type="button" class="btn-danger" onclick="handleClose('#confirm-subscribe-modal')">No</button>
                    </div>
                </div>
            </div>
        </div>
        EOT;
    }
    else {
        $html = $html . <<<EOT
                </div>
            </div>
        </div>
        EOT;
    }

    return $html;
}

function showCuratorReviews($data) {
    $str = "";
    $subscribed = $data['status'] == 'Accepted';
    if ($subscribed) {
        if (!empty($data['reviews'])) {
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
            $str = '<p class="empty-text">No reviews.</p>';
        }
    }
    else {
        $str = '<h6>You have not subscribed</h6>';
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
            if (isset($data['count']) && isset($data['currentPage']) && $data['status'] == 'ACCEPTED') {
                include Application::$BASE_DIR . '/src/views/components/pagination.php';
            }
        ?>
    </div>
</div>


<script defer src="/js/curators.js"></script>
<script defer src="/js/confirmation-modal.js"></script>
<script defer src="/js/form-handler.js"></script>
<script defer src="/js/reviews.js"></script>