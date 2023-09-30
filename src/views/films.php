<?php
include __DIR__ . '/components/navbar.php';
include __DIR__ . '/components/dashboard/film-card.php';
?>
<div class="base-container">
    <h5 class="section-title">🎥 Films 🎥</h5>
    <div class="film-list">
        <div class="filter-container">
            <input type="string" value="" name="search" id="searchInput" placeholder="Search by title/director">
            <select id="genreFilter">
                <option value="" disabled selected>Genre</option>
                <option value="all">All</option>
                <option value="action">Action</option>
            </select>
            <select id="ratingFilter">
                <option value="" disabled selected>Rating</option>
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
            include __DIR__ . '/components/film-posters.php';
            ?>
        </div>
    </div>
    <script defer src="/js/films.js"></script>
</div>


