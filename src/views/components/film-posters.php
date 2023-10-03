<?php

use app\core\Application;

if (!empty($data['films'])) {
    $filmsPerPage = 10; // Number of films per page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($currentPage - 1) * $filmsPerPage;
    $end = $start + $filmsPerPage;
    $str = '';
    foreach ($data['films'] as $film) {
        $id = $film['id'];
        $image_path = '/assets/films/' . $film['image_path'];
        $title = strlen($film['title']) > 18 ? substr($film['title'], 0, 18) . '...' : $film['title'];
        $year = $film['release_year'];
        $rating = number_format($film['rating'], 2);
        $html = <<<EOT
            <a href="/film/$id" class="film-poster-card">
                <img src="$image_path" alt="dummy" class="poster-image">
                <h5 class="film-poster-title">$title</h5>
                <div class="review-stars-container">
                    <p class="text-disabled">$year</p>
                    <div class="stars-container">
                       <img class="stars-img" src="/assets/app/star.png" alt="star">
                       <p class="text-secondary">$rating</p>
                    </div>
                </div>
            </a>
EOT;
        $str .= $html;
    }
    echo $str;

    if (isset($data['count']) && isset($data['currentPage'])) {
        include Application::$BASE_DIR . '/src/views/components/pagination.php';
    }

}
