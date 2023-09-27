<?php

namespace app\repositories;

use app\core\Repository;

class FilmReviewRepository extends Repository
{
    public function getAll() {
        $query = 'SELECT f.*, fr.*, u.first_name, u.last_name, u.profile_picture_path
                FROM film_reviews AS fr 
                INNER JOIN films AS f ON f.id = fr.film_id
                INNER JOIN users u ON fr.user_id = u.id
                INNER JOIN (
                    SELECT film_id, MAX(created_at) AS max_review_date
                    FROM film_reviews fr1
                    GROUP BY film_id
                ) AS latest_reviews
                ON f.id = latest_reviews.film_id AND latest_reviews.max_review_date = fr.created_at;
                ';
        $res = $this->findAll($query, []);
        return $res;
    }
}