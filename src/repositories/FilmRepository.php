<?php

namespace app\repositories;

use app\core\Repository;

class FilmRepository extends Repository
{
    public function getAll() {
        $query = 'SELECT f.*, fr.*
                FROM films AS f
                INNER JOIN (
                    SELECT film_id, MAX(created_at) AS max_review_date
                    FROM film_reviews
                    GROUP BY film_id
                ) AS latest_reviews
                ON f.id = latest_reviews.film_id
                LEFT JOIN film_reviews AS fr
                ON f.id = fr.film_id AND latest_reviews.max_review_date = fr.created_at;
                ';
        $res = $this->findAll($query, []);
        return $res;
    }
}