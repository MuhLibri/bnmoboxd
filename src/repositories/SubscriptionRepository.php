<?php

namespace app\repositories;

use app\core\Repository;

class SubscriptionRepository extends Repository {
    public function getSubscriptionStatus($curatorUsername, $subscriberUsername) {
        $query = 'SELECT status FROM subscriptions WHERE curator_username = :curatorUsername AND subscriber_username = :subscriberUsername';
        $params = [
            'curatorUsername' => $curatorUsername,
            'subscriberUsername' => $subscriberUsername
        ];

        return $this->findOne($query, $params);
    }

    public function getSubscriberCount($curator_id) {
        $query = "SELECT COUNT(*) FROM subscriptions WHERE curator_id = :curator_id AND status = 'ACCEPTED'";
        $params = [
            'curator_id' => $curator_id
        ];

        return $this->findOne($query, $params);
    }

    public function getSubscriptions($curatorUsernames, $subscriberUsername)
    {
        $query = 'SELECT * FROM subscriptions WHERE curator_username IN ('. $curatorUsernames . ') AND subscriber_username = :subscriber_username';
        $params = [
            'subscriber_username' => $subscriberUsername
        ];
        return $this->findAll($query, $params);
    }

    public function addSubscription($curatorUsername, $subscriberUsername)
    {
        $query = 'INSERT INTO subscriptions (curator_username, subscriber_username) VALUES (:curatorUsername, :subscriberUsername)';
        $params = [
            'curatorUsername' => $curatorUsername,
            'subscriberUsername' => $subscriberUsername,
        ];
        return $this->save($query, $params);
    }

    public function updateSubscription($curatorUsername, $subscriberUsername, $status)
    {
        $query = 'UPDATE subscriptions
              SET status =:status
              WHERE curatorUsername = :curatorUsername AND subscriberUsername = :subscriberUsername';
        $params = [
            'curatorUsername' => $curatorUsername,
            'subscriberUsername' => $subscriberUsername,
            'status' => $status
        ];
        return $this->save($query, $params);
    }
}