<?php
function filmPosters($data){
    $str = "";
    if (!empty($data)){
        foreach($data as $film){
            $image_path = '/assets/films/' . $film['image_path'];
            $title = $film['title'];
            $rating = $film['rating'];
            // Loop to add star images based on the rating value
            $starsHtml = str_repeat('<img src="/assets/app/star.png" alt="star">', $rating);
            $html = <<<"EOT"
            <a href="#" class="film-poster-card">
                <img src="$image_path" alt="dummy" class="poster-image">
                <h5 class="film-poster-title">$title</h5>
                <div>$starsHtml</div>
            </a>
    EOT;
            $str = $str . $html;
        }
    }
    return $str;
}
