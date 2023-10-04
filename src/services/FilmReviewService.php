<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
use app\repositories\FilmRepository;
use app\repositories\FilmReviewRepository;

class FilmReviewService extends Service
{
    private FilmReviewRepository $filmReviewRepository;
    public function __construct()
    {
        require_once Application::$BASE_DIR . '/src/repositories/FilmReviewRepository.php';
        $this->filmReviewRepository = new FilmReviewRepository();
    }

    public function getLatestReviews($options) {
        return $this->filmReviewRepository->getLatestReviews($options);
    }

    public function getReviewsWithFilmId($id){
        return $this->filmReviewRepository->getByFilmId($id);
    }

    public function getUserReviews(int $userId, $options= []): array
    {
        return $this->filmReviewRepository->getByUserId($userId, $options);
    }

    /**
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function getReview(int $reviewId, int $userId)
    {
        $review = $this->filmReviewRepository->getByReviewId($reviewId);
        if (!$review) {
            throw new NotFoundException(true);
        }
        if ($review['user_id'] != $userId) {
            throw new ForbiddenException(true);
        }
        return $review;
    }

    /**
     * @throws BadRequestException
     */
    public function create(array $reviewData, $userId)
    {
        $errors = $this->validateRequired($reviewData, ['film_id', 'review', 'rating']);
        $this->handleValidationErrors($errors);
        $this->filmReviewRepository->addReview((int) $reviewData['film_id'], (int) $userId, $reviewData['review'], (int) $reviewData['rating']);
    }

    /**
     * @throws BadRequestException
     * @throws NotFoundException
     * @throws ForbiddenException
     */
    public function edit(array $reviewData, int $userId, int $reviewId) {
        $errors = $this->validateRequired($reviewData, ['film_id', 'review', 'rating']);
        $this->handleValidationErrors($errors);
        $review = $this->getReview($reviewId, $userId);
        $this->filmReviewRepository->editReview($review['id'], $reviewData['review'], $reviewData['rating']);
    }

    /**
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function delete($reviewId, $userId)
    {
        $review = $this->getReview($reviewId, $userId);
        $this->filmReviewRepository->deleteReview($review['id']);
    }
}