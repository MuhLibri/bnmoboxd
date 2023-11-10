<?php

namespace app\repositories;

use app\core\Repository;

class FilmRepository extends Repository
{
    /**
     * options = [
     *      'rderBy'=> [rating, release_year, name]
     *      'earch'=> string,
     *      'sc'=> bool,
     *      'genre'=> filter,
     * ]
     *
    **/
    public function getById($id) {
        $query = 'SELECT * FROM films WHERE id = :id';
        $params = [
            'id' => $id
        ];
        return $this->findOne($query, $params);
    }

    public function getAll($options = []): array
    {
        $params = [];
        $selectFilmsQuery = 'SELECT f.*, avg_rating.rating ';
        $selectCountQuery = 'SELECT COUNT(*) film_count ';
        $query = 'FROM films AS f 
                LEFT JOIN (
                    SELECT film_id, AVG(rating) AS rating
                    FROM film_reviews AS fr
                    GROUP BY film_id
                ) AS avg_rating
                ON f.id = avg_rating.film_id
                ';
        $isFilterOn = false;
        if (isset($options['search']) || isset($options['genre']) || isset($options['rating'])) {
            $query .= ' WHERE ';
            if (isset($options['search'])) {
                $search = '%'. $options['search'] . '%';
                $query .= ' (title LIKE :search OR director LIKE :search)';
                $params = array_merge($params, ['search' => $search]);
                $isFilterOn = true;
            }
            if (isset($options['genre']) && $options['genre'] != 'all' && $options['genre'] != '') {
                if ($isFilterOn) {
                    $query .= ' AND ';
                }
                $genre = $options['genre'];
                $query .= ' genre = :genre ';
                $params = array_merge($params, ['genre' => $genre]);
                $isFilterOn = true;
            }
            if (isset($options['rating']) && is_numeric($options['rating'])) {
                if ($isFilterOn) {
                    $query .= ' AND ';
                }
                $rating = $options['rating'];
                $query .= ' FLOOR(rating) = :rating ';
                $params = array_merge($params, ['rating' => $rating]);
            }
        }

        $selectCountQuery .= $query;

        if (isset($options['orderBy'])) {
            // Check for security because we're appending the options to the query
            if (in_array(strtolower($options['orderBy']), ['rating', 'year', 'title'])) {
                if ($options['orderBy'] == 'year') {
                    $options['orderBy'] = 'release_year';
                }
                $query .= ' ORDER BY ' . $options['orderBy'];
                if ($options['sort'] === 'asc') {
                    $query .= ' ASC ';
                } else {
                    $query .= ' DESC ';
                }
            }
        }
        $query = $this->buildPaginationQuery($query, $options);
        $selectFilmsQuery .= $query;
        $films = $this->findAll($selectFilmsQuery,$params);
        $count = $this->findOne($selectCountQuery, $params);
        return ['films' => $films, 'count' => $count['film_count']];
    }

    /**
     * @return int ID of the newly added film.
     */
    public function addFilm(
        string $title,
        int $releaseYear,
        string $director,
        string $genre,
        string $description = null,
        string $posterImagePath = null,
        string $trailerVideoPath = null
    ){
        // Insert a new tuple into table
        $queryInsert = 'INSERT INTO films
            SET
                title = :title,
                release_year = :release_year,
                director = :director,
                genre = :genre,
                description = :description
        ';
        $params = [
            'title' => $title,
            'release_year' => $releaseYear,
            'director' => $director,
            'genre' => $genre,
            'description' => $description
        ];

        if($posterImagePath){
            $params['image_path'] = $posterImagePath;
            $queryInsert = $queryInsert . ', image_path = :image_path';
        }
        if($trailerVideoPath){
            $params['video_path'] = $trailerVideoPath;
            $queryInsert = $queryInsert . ', video_path = :video_path';
        }
        $this->save($queryInsert, $params);

        // Get the new tuple's ID (will always be the largest ID in the table thanks to AUTO INCREMENT)
        $queryGetId = 'SELECT MAX(id) AS id FROM films';
        $id = $this->findOne($queryGetId, []);
        return (int)$id['id'];
    }

    public function updateFilm(
        int $id,
        string $title,
        int $releaseYear,
        string $director,
        string $genre,
        string $description = null,
        string $posterImagePath = null,
        string $trailerVideoPath = null
    ){
        $dtUpdate = new \DateTime(date_default_timezone_get());
        $timestamp = $dtUpdate->format('Y-m-d h:i:s');

        $query = 'UPDATE films
            SET
                updated_at = :updated_at,
                title = :title,
                release_year = :release_year,
                director = :director,
                genre = :genre,
                description = :description
        ';

        $params = [
            'updated_at' => $timestamp,
            'id' => $id,
            'title' => $title,
            'release_year' => $releaseYear,
            'director' => $director,
            'genre' => $genre,
            'description' => $description
        ];

        if($posterImagePath){
            $params['image_path'] = $posterImagePath;
            $query = $query . ', image_path = :image_path';
        }
        if($trailerVideoPath){
            $params['video_path'] = $trailerVideoPath;
            $query = $query . ', video_path = :video_path';
        }

        $query = $query . ' WHERE id = :id';
        $this->save($query, $params);
    }

    public function deleteFilm(int $id){
        $query = 'DELETE FROM films WHERE id = :id';
        $params = ['id' => $id];
        $this->save($query, $params);
    }

    public function getFilmTitles($options) {
        $params = [];
        $selectFilmsQuery = 'SELECT f.id, f.title ';
        $selectCountQuery = 'SELECT COUNT(*) film_count ';
        $query = 'FROM films AS f';
        $isFilterOn = false;
        if (isset($options['search'])) {
            $query .= ' WHERE title LIKE :search';
            $search = '%'. $options['search'] . '%';
            $params = array_merge($params, ['search' => $search]);
            $isFilterOn = true;
        }
        if (isset($options['filmIds'])) {
            if ($isFilterOn) {
                $query .= ' AND';
            }
            else {
                $query .= ' WHERE';
            };
            $query .= ' f.id in ('.$options['filmIds'].')';
        }
        $selectCountQuery .= $query;
        $query = $this->buildPaginationQuery($query, $options);
        $selectFilmsQuery .= $query;
        $films = $this->findAll($selectFilmsQuery, $params);
        $count = $this->findOne($selectCountQuery, $params);
        return ['films' => $films, 'count' => $count['film_count']];
    }
}
