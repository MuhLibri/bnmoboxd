<?php

namespace app\services;

use app\core\Application;
use app\core\Service;
use app\exceptions\BadRequestException;
use app\exceptions\ForbiddenException;
use app\exceptions\NotFoundException;
use app\repositories\CuratorsRepository;

class CuratorsService extends Service {
    private CuratorsRepository $curatorsRepository;

    public function __construct() {
        require_once Application::$BASE_DIR . '/src/repositories/CuratorsRepository.php';
        $this->curatorsRepository = new CuratorsRepository();
    }

    public function getSubscriptionStatus($curator_id, $subscriber_id) {
        $status = $this->curatorsRepository->getSubscriptionStatus($curator_id, $subscriber_id);
        if (empty($status)) {
            return "Not Subscribed";
        }
        return ucwords(strtolower($status[0]));
    }

    public function getSubscriber($curator_id) {
        return $this->curatorsRepository->getSubscriberCount($curator_id)[0];
    }
}