<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function reviewList($reviews){
    $str = "";
    $reviews = array(1,2, 3);
    if(!empty($reviews)){
        foreach($reviews as $review) {
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
                <a href="/my-reviews/:id/edit">
                    <div class="review-container">
                        <div class="film-poster">
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
                </a>
            EOT;
            $str = $str . $html;
        }
    }
    if(empty($str)){
        return <<<"EOT"
            <p class="empty-text">No reviews.</p>
        EOT;
    }
    return $str;
}
?>

<div class="base-container">
    <div>
        <h5 class="section-title" id="t1">My Reviews</h5>
        <div class="review-list" id="rl1">
            <?php echo reviewList(1); ?>
        </div>
    </div>
</div>

<script defer src="/js/reviews.js"></script>