<?php

namespace app\repositories;

use app\core\Repository;

class FilmReviewRepository extends Repository
{
    public function getByFilmId($id){
        $query = 'SELECT
                    fr.id AS id,
                    fr.film_id AS film_id,
                    fr.user_id AS user_id,
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

    public function getByUserId($userId, $options = [])
    {
        $params = ['userId' => (int)$userId];
        $selectQuery = 'SELECT f.*, fr.* ';
        $countQuery = 'SELECT COUNT(*) AS reviews_count ';
        $query = 'FROM film_reviews AS fr 
                INNER JOIN films AS f ON fr.film_id = f.id
                WHERE fr.user_id = :userId' ;
        $countQuery .= $query;
        $selectQuery .= $this->buildPaginationQuery($query, $options);
        $reviews = $this->findAll($selectQuery, $params);
        $count = $this->findOne($countQuery, $params);
        return ['reviews' => $reviews, 'count' => $count['reviews_count']];
    }

    public function getByReviewId(int $reviewId)
    {
        $query = 'SELECT
                    f.*, fr.*
                FROM
                    film_reviews AS fr
                    INNER JOIN films AS f ON fr.film_id = f.id
                WHERE fr.id = :reviewId';
        $params = ['reviewId' => $reviewId];
        return $this->findOne($query, $params);
    }

    public function addReview($filmId, $userId, $review, $rating)
    {
        $query = 'INSERT INTO film_reviews (film_id, user_id, rating, review) VALUES (:filmId, :userId, :review, :rating)';
        $params = [
            'filmd_id' => $filmId,
            'user_id' => $userId,
            'rating' => $rating,
            'review' => $review
        ];
        return $this->save($query, $params);
    }

    public function editReview($reviewId, $review, $rating)
    {
        $dtUpdate = new \DateTime(date_default_timezone_get());
        $timestamp = $dtUpdate->format('Y-m-d h:i:s');

        $query = 'UPDATE film_reviews
              SET review = :review, 
                  rating = :rating,
                  updated_at = :updated_at
              WHERE id = :reviewId';
        $params = [
            'review' => $review,
            'rating' => $rating,
            'updated_at' => $timestamp,
            'reviewId' => $reviewId
        ];
        return $this->save($query, $params);
    }

    public function deleteReview(int $id)
    {
        $query = 'DELETE from film_reviews WHERE id = :id';
        $params = [
            'id' => $id
        ];
        $this->save($query, $params);
    }
}