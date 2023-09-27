<?php
function filmCard($data){
    $str = "";
    if (!empty($data)){
        foreach($data as $film){
            $title = $film['title'];
            $image_path = '/assets/films/' . $film['image_path'];
            $release_year = $film['release_year'];
            $name = $film['first_name'] . ' ' . $film['last_name'];
            $profile_picture_path = '/assets/users/' . $film['profile_picture_path'];
            $review = strlen($film['review']) > 100 ? substr($film['review'],0, 100) . '...'  : $film['review'];
            $rating = $film['rating'];
            // Loop to add star images based on the rating value
            $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star">', $rating);
            $html = <<<"EOT"
            <a href="#" class="film-container">
                <img src="$image_path" alt="dummy" class="poster-image">
                <div class="film-details-container">
                    <h5 class="film-title">$title<span class="release-year"> $release_year </span></h5>
                    <div class="review-container">
                        <div class="profile-picture">
                            <img src="$profile_picture_path">
                        </div>
                        <div class="review-details">
                            <h6>$name</h6>
                            <p>$review</p>
                            <div>$starsHtml</div>
                        </div>
                    </div>
                </div>
            </a>
    EOT;
            $str = $str . $html;
        }
    }
    return $str;
}
