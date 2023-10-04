<?php

use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';
?>

<div class="base-container">
    <div>
        <h5 class="section-title">FILMS</h5>
        <div class="film-list">
            <div class="filter-container">
                <div class="search-container">
                    <input type="string" value="" name="search" id="searchInput" placeholder="Search by title/director" class="search-bar">
                    <img src="/assets/app/search-icon.png" alt="Search Icon" class="search-icon">
                </div>
                <select id="genreFilter">
                    <option value="" disabled selected>Genre</option>
                    <option value="all">All</option>
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                    <option value="Horror">Horror</option>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Fantasy">Other</option>
                </select>
                <select id="ratingFilter">
                    <option value="" disabled selected>Rating</option>
                    <option value="all">All</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <select id="sortFilter">
                    <option value="" disabled selected>Sort</option>
                    <option value="year_desc">Latest</option>
                    <option value="year_asc">Oldest</option>
                    <option value="rating_desc">Highest Rated</option>
                    <option value="rating_asc">Lowest Rated</option>
                    <option value="title_asc">Title (A-Z)</option>
                    <option value="title_desc">Title (Z-A)</option>
                </select>
            </div>
            <div class="film-poster-list" id="film-poster-list">
                <?php
                include Application::$BASE_DIR . '/src/views/components/film-posters.php';
                ?>
            </div>
        </div>
    </div>
    <script defer src="/js/films.js"></script>
</div>


