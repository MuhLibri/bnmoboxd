<?php

namespace app\repositories;

use app\core\Repository;

class FilmReviewRepository extends Repository
{
    public function getByFilmId($id){
        $query = 'SELECT
                    fr.rating AS rating,
                    fr.review AS review,
                    fr.created_at AS created_at,
                    fr.updated_at AS updated_at,
                    u.first_name AS first_name,
                    u.last_name AS last_name,
                    u.profile_picture_path AS profile_picture_path
                FROM
                    film_reviews AS fr
                    INNER JOIN users AS u ON fr.user_id = u.id
                WHERE film_id = :id
                ORDER BY fr.created_at DESC
                ';
        $params = [
            'id' => $id
        ];
        return $this->findAll($query, $params);
    }

    public function getLatestReviews($options) {
        $params = [];
        $query = 'SELECT f.*, fr.*, u.first_name, u.last_name, u.profile_picture_path
                FROM film_reviews AS fr 
                INNER JOIN films AS f ON f.id = fr.film_id
                INNER JOIN users u ON fr.user_id = u.id
                INNER JOIN (
                    SELECT film_id, MAX(created_at) AS max_review_date
                    FROM film_reviews fr1
                    GROUP BY film_id
                ) AS latest_reviews
                ON f.id = latest_reviews.film_id AND latest_reviews.max_review_date = fr.created_at
                ';
        if ($options['take']) {
            $query .= ' LIMIT :take';
            $params = array_merge($params, ['take' => $options['take']]);
        }

        return $this->findAll($query, $params);
    }
}