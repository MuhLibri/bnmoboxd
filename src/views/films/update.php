<?php

use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function filmUpdateForm($data){
    $newFilm = !isset($data['film']);

    $title = '';
    $releaseYear = '';
    $director = '';
    $description = '';
    $genre = '';
    $imagePath = '/assets/films/';
    $videoPath = '/assets/films/';

    if(!$newFilm){
        $film = $data['film'];

        $title = $film['title'];
        $releaseYear = $film['release_year'];
        $director = $film['director'];
        $description = $film['description'];
        $genre = $film['genre'];
        $imagePath = $imagePath . $film['image_path'];
        $videoPath = $videoPath . $film['video_path'];
    }

    $html = <<<"EOT"
        <div class="film-poster-col">
            <img src="$imagePath" class="poster-image">
        </div>
        <div class="film-details-col">
            <form class="form-container" id="film-form">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" formnovalidate value="$title">
                    <label class="form-error" id="title-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="release-year">Release Year</label>
                    <input type="text" id="release-year" name="release-year" formnovalidate value="$releaseYear">
                    <label class="form-error" id="release-year-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="director">Director(s)</label>
                    <input type="text" id="director" name="director" formnovalidate value="$director">
                    <label class="form-error" id="director-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" formnovalidate>$description</textarea>
                    <label class="form-error" id="description-form-error"></label>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <select type="text" id="genre" name="genre" formnovalidate value="$genre">
                        <option value="Action">Action</option>
                        <option value="Comedy">Comedy</option>
                        <option value="Drama">Drama</option>
                        <option value="Sci-Fi">Sci-Fi</option>
                        <option value="Horror">Horror</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="film-poster">Poster</label>
                    <input type="file" id="film-poster" name="film-poster" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="film-trailer">Trailer</label>
                    <input type="file" id="film-trailer" name="film-trailer" accept="video/*">
                </div>
                <div class="btn-group">
                    <button class="btn-primary" type="button" id="save-btn">Save</button>
                    <button class="btn-primary" type="button" id="cancel-btn">Cancel</button>
                    {{button-delete}}
                </div>
                <div class="modal-container" id="confirm-save-modal">
                    <div class="confirmation-modal">
                        <h2>Are you sure you want to save this film?</h2>
                        <div class="btn-group">
                            <button class="btn-primary" type="button" id="confirm-save-btn">Yes</button>
                            <button class="btn-danger" type="button" onclick="handleClose('#confirm-save-modal')">Cancel</button>
                        </div>
                     </div>
                </div>
                <div class="modal-container" id="confirm-delete-modal">
                    <div class="confirmation-modal">
                        <h2>Are you sure you want to delete this film?</h2>
                        <div class="btn-group">
                            <button class="btn-primary" type="button" id="confirm-delete-btn">Yes</button>
                            <button class="btn-danger" type="button" onclick="handleClose('#confirm-delete-modal')">Cancel</button>
                        </div>
                     </div>
                </div>
            </form>
        </div>
    EOT;

    $html = str_replace(
        '{{button-delete}}',
        $newFilm ? '' : '<button class="btn-danger" type="button" id="delete-btn">Delete</button>',
        $html
    );

    return $html;
}
?>
<div class="base-container display-grid">
    <h2><?php echo isset($data['film']) ? 'Edit Film' : 'New Film'; ?></h2>
    <div class="film-page-container">
        <?php echo filmUpdateForm($data); ?>
    </div>
</div>
<script defer src="/js/confirmation-modal.js"></script>
<script defer src="/js/form-handler.js"></script>
<script defer src="/js/film-update.js"></script>
