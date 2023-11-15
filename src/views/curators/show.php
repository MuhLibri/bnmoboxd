<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function showCuratorProfile($data) {
    $curatorDetails = $data['curatorDetails'];
    $username = $curatorDetails['username'];
    $name = $curatorDetails['firstName'] . ' ' . $curatorDetails['lastName'];
    $reviewCount = $curatorDetails['reviewCount'];
//    $subscriber = $data['subscriber'];
    $profileImg = '/assets/users/blank.jpeg';
    if (isset($curatorDetails['profileImage'])  && $curatorDetails['profileImage']!='') {
        $profileImg = Application::$config['REST_CLIENT_API_URL'] . '/static/images/' . $curatorDetails['profileImage'];
    }
    $bio = $curatorDetails['bio'];
    $status = $data['status'];
    $statusLabelId = 'not-subscribed-label';
    if ($status == 'SUBSCRIBED') {
        $statusLabelId = 'subscribed-label';
    }
    if ($status == 'REJECTED') {
        $statusLabelId = 'rejected-label';
    }
    if ($status == 'PENDING') {
        $statusLabelId = 'pending-label';
    }
    $html = <<<EOT
    <input type="hidden" id="curator_username" name="curator_username" value="$username">
    <div class="curator-container">
        <div class="curator-info"> 
            <div class="user-profile">
                <img alt="curator's profile" src="$profileImg">
            </div>
            <div class="curator-details">
                <h5 class="curator-name">$name</h5>
                <h6 class="curator-info">$reviewCount review</h6>
                <p>$bio</p>
            </div>
        </div>
        <div class="status-section">
    EOT;

    if ($status == "NOT SUBSCRIBED") {
        $html = $html . <<<EOT
                <button type="button" class="btn-subscribe" id="subscribe">SUBSCRIBE</button>
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
                <h6 class="status-text" id="$statusLabelId">$status</h6>
            </div>
        </div>
        EOT;
    }

    return $html;
}

function showCuratorReviews($data) {
    $str = "";
    $subscribed = $data['status'] == 'ACCEPTED';
    if ($subscribed) {
        $reviews = $data['curatorDetails']['Review'];
        if (!empty($reviews)) {
            foreach($reviews as $review) {
                $name = $review['title'];
                $filmPosterPath = '/assets/films/' . $review['imagePath'];
                $reviewText = $review['review'];
                $rating = $review['rating'];
                $dtCreate = new DateTime($review['createdAt']);
                $dtUpdate = new DateTime($review['updatedAt']);
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
    <div>
        <h5 class="section-title">REVIEWS</h5>
    </div>
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
