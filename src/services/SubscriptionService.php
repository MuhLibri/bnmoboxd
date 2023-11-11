<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\repositories\SubscriptionRepository;

class SubscriptionService extends Service {
    private SubscriptionRepository $subscriptionRepository;

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/repositories/SubscriptionRepository.php';
        $this->subscriptionRepository = new SubscriptionRepository();
    }

    /**
     * @throws BadRequestException
     */
    public function updateSubscription($subscriptionData) {
        $errors = $this->validateRequired($subscriptionData, ['curatorUsername', 'subscriberUsername', 'status']);
        $this->handleValidationErrors($errors);
        $this->subscriptionRepository->updateSubscription($subscriptionData['curatorUsername'], $subscriptionData['subscriberUsername'], $subscriptionData['status']);
    }
}