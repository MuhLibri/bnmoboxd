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
    public function getAll($options = []) {
        $params = [];
        $query = 'SELECT f.*, avg_rating.rating
                FROM films AS f 
                LEFT JOIN (
                    SELECT film_id, AVG(rating) AS rating
                    FROM film_reviews AS fr
                    GROUP BY film_id
                ) AS avg_rating
                ON f.id = avg_rating.film_id
                ';
        $isFilterOn = false;
        if (isset($options['search']) || (isset($options['genre']) && $options['genre'] != 'all') || isset($options['rating'])) {
            $query .= ' WHERE ';
            if (isset($options['search'])) {
                $search = '%'. $options['search'] . '%';
                $query .= ' title LIKE :search ';
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
        if (isset($options['orderBy'])) {
            // Check for security because we're appending the options to the query
            if (in_array(strtolower($options['orderBy']), ['rating', 'release_year', 'name'])) {
                $query .= ' ORDER BY ' . $options['orderBy'];
                if ($options['sort'] === true) {
                    $query .= ' ASC ';
                } else {
                    $query .= ' DESC ';
                }
            }
        }
        $pageSize = 10; // DEFAULT PAGE SIZE

        if (isset($options['take']) && is_numeric($options['take'])) {
            $pageSize = $options['take'];
        }

        $query .= " LIMIT $pageSize";

        if (isset($options['page']) && is_numeric($options['page'])) {
            $page = (int)$options['page'];

            if ($page < 1) {
                $page = 1;
            }

            $offset = ($page - 1) * $pageSize;

            $query .= " OFFSET $offset";
        }
        return $this->findAll($query,$params);
    }
}