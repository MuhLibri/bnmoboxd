<?php

namespace app\services;

use app\clients\RestApi;
use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\exceptions\BaseException;
use app\repositories\SubscriptionRepository;

class CuratorsService extends Service {
    private SubscriptionRepository $subscriptionRepository;
    private FilmService  $filmService;
    private RestApi $restApi;

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/repositories/SubscriptionRepository.php';
        require_once Application::$BASE_DIR . '/src/clients/RestApi.php';
        require_once Application::$BASE_DIR . '/src/services/FilmService.php';
        $this->subscriptionRepository = new SubscriptionRepository();
        $this->restApi = new RestApi();
        $this->filmService = new FilmService();
    }

    /**
     * @throws BaseException
     * @throws BadRequestException
     */
    public function getCurators($options): array
    {
        $data = $this->restApi->getCurators($options);
        $curators = $data['curators'];
        $curatorsMap = $this->mapCuratorsWithSubscriptionStatus($curators);

        return ['curators' => $curatorsMap, 'count' => $data['count']];
    }

    public function getCuratorDetail($curatorUsername): array
    {
        $subscriberUsername = $_SESSION['username'];
        $statusData = ($this->getSubscriptionStatus($curatorUsername, $subscriberUsername));
        if (!$statusData) {
            $status = 'NOT SUBSCRIBED';
        } else {
            $status = $statusData['status'];
        }
        $curatorDetails = $this->restApi->getCuratorDetails($curatorUsername, $status);
        if (!empty($curatorDetails['Review'])) {
            $reviews = $curatorDetails['Review'];
            $curatorDetails['Review'] = $this->mapReviewsWithFilms($reviews);
        }
        return ['curatorDetails' => $curatorDetails, 'status' => $status];
    }

    private function mapReviewsWithFilms($reviews) {
        $filmIds = '';
        foreach ($reviews as $review) {
            $filmIds .=  $review['filmId'] . ',';
        }
        $filmIds = rtrim($filmIds, ',');
        $films = ($this->filmService->getFilmTitles(['filmIds' => $filmIds]))['films'];
        $filmMap = [];
        foreach ($films as $film) {
            $filmMap[$film['id']] = ['title' => $film['title'], 'imagePath' => $film['image_path']];
        }
        foreach ($reviews as &$review) {
            $review['title'] = $filmMap[$review['filmId']]['title'];
            $review['imagePath'] = $filmMap[$review['filmId']]['imagePath'];
        }
        return $reviews;
    }

    private function mapCuratorsWithSubscriptionStatus($curators) {
        $subscriberUsername = $_SESSION['username'];
        $curatorUsernames = '';
        $curatorsMap = [];
        foreach ($curators as $curator) {
            $curatorUsernames .= '\''. $curator['username'] . '\',';
            $curatorsMap[$curator['username']] = [
                'status' => 'NOT SUBSCRIBED',
                'reviewCount' => $curator['reviewCount'],
                'name' => $curator['firstName'] . ' ' . $curator['lastName']
            ];
        }
        $curatorUsernames = rtrim($curatorUsernames, ',');
        $subscriptions = $this->subscriptionRepository->getSubscriptions($curatorUsernames, $subscriberUsername);
        foreach ($subscriptions as $sub) {
            $status = $sub['status'];
            if ($status == 'ACCEPTED') {
                $curatorsMap[$sub['curator_username']]['status'] = 'SUBSCRIBED';
            } else {
                $curatorsMap[$sub['curator_username']]['status'] = $status;
            }
        }
        return $curatorsMap;
    }

    public function createSubscription($curatorUsername, $subscriberUsername) {
        $this->subscriptionRepository->addSubscription($curatorUsername, $subscriberUsername);
    }

    public function getSubscriptionStatus($curatorUsername, $subscriberUsername) {
        return $this->subscriptionRepository->getSubscriptionStatus($curatorUsername, $subscriberUsername);
    }

    public function getSubscriber($curator_id) {
        return $this->subscriptionRepository->getSubscriberCount($curator_id)[0];
    }
}