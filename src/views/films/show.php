<?php

use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function filmPosterImage($film){
    $title = $film['title'];
    $path = '/assets/films/' . $film['image_path'];

    return "<img src=\"$path\" alt=\"$title\" class=\"poster-image\">";
}

function filmDetailsHead($film){
    $title = $film['title'];
    $year = $film['release_year'];
    $genre = $film['genre'];

    return <<<"EOT"
        <h5 class="section-title">$title</h5>
        <h6 class="film-subtitle">
            <span class="release-year">$year</span>
            • $genre
        </h6>
    EOT;
}
?>
<div class="base-container">
    <div class="film-show-container">
        <div class="film-poster-col">
            <?php echo filmPosterImage($data); ?>
        </div>

        <div class="film-details-col">
            <?php echo filmDetailsHead($data); ?>

            <p class="text-white">
                <?php echo $data['description']; ?>
            </p>
        </div>
    </div>
</div>
