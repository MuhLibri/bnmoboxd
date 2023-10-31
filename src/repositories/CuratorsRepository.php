<?php

namespace app\repositories;

use app\core\Repository;

class CuratorsRepository extends Repository {
    public function getSubscriptionStatus($curator_id, $subscriber_id) {
        $query = 'SELECT status FROM subscriptions WHERE curator_id = :curator_id AND subscriber_id = :subscriber_id';
        $params = [
            'curator_id' => $curator_id,
            'subscriber_id' => $subscriber_id
        ];

        return $this->findOne($query, $params);
    }

    public function getSubscriberCount($curator_id) {
        $query = 'SELECT COUNT(*) FROM subscriptions WHERE curator_id = :curator_id';
        $params = [
            'curator_id' => $curator_id
        ];

        return $this->findOne($query, $params);
    }
}