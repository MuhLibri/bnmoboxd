<?php
function filmCard($data){
    $str = "";
    if (!empty($data)){
        foreach($data as $film){
            $title = strlen($film['title']) > 30 ? substr($film['title'],0, 30) . '...'  : $film['title'];
            $imagePath = '/assets/films/' . $film['image_path'];
            $releaseYear = $film['release_year'];
            $name = $film['first_name'] . ' ' . $film['last_name'];
            $profilePicturePath = '/assets/users/' . $film['profile_picture_path'];
            $review = strlen($film['review']) > 100 ? substr($film['review'],0, 100) . '...'  : $film['review'];
            $rating = $film['rating'];
            // Loop to add star images based on the rating value
            $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star" class="stars-img">', $rating);
            $html = <<<"EOT"
            <a href="#" class="film-container">
                <img src="$imagePath" alt="$imagePath" class="poster-image">
                <div class="film-details-container">
                    <h5 class="film-title">$title<span class="release-year"> $releaseYear </span></h5>
                    <div class="review-container">
                        <div class="profile-picture">
                            <img alt="profile-picture" src="$profilePicturePath">
                        </div>
                        <div class="review-details">
                            <h6>$name</h6>
                            <p>$review</p>
                            <div class="review-stars-container">$starsHtml</div>
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

