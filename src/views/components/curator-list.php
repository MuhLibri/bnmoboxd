<?php
use app\core\Application;
function curatorList($data) {
    $str = "";
    $curators = $data['curators'];
    if (!empty($curators)) {
        foreach ($curators as $curator => $detail) {
            $username = $curator;
            $name = $detail['name'];
            $reviewCount = $detail['reviewCount'];
//            $subscriber = $curator['count'];
            $status = $detail['status'];
            $statusLabelId = 'not-subscribed-label';
            if ($status == 'SUBSCRIBED') {
                $statusLabelId = 'subscribed-label';
            }
            if ($status == 'REJECTED') {
                $statusLabelId = 'rejected-label';
            }
            if ($status == 'PENDING') {
                $statusLabelId = 'pending-label';
            }
            $profileImg = '/assets/users/blank.jpeg';
            if (isset($detail['profileImage'])  && $detail['profileImage']!='') {
                $profileImg = Application::$config['REST_CLIENT_API_URL'] . '/static/images/' . $detail['profileImage'];
            }
            $bio = $detail['bio'];
            $html = <<<EOT
            <a href="/curators/$username" class="curator-container" id="cc1">
                <div class="curator-info"> 
                    <div class="user-profile">
                        <img alt="curator's profile" src="$profileImg">
                    </div>
                    <div class="curator-details">
                        <h5 class="curator-name">$name</h5>
                        <h6 class="curator-info">$reviewCount review</h6>
                        <p>$bio</p>
                    </div>
                </div>
                <div class="status-section">
                    <h6 class="status-text" id="$statusLabelId">$status</h6>
                </div>
            </a>
            EOT;
            $str = $str . $html;
        }
    }

    if (empty($str)) {
        return <<<"EOT"
            <p class="empty-text">No curators</p>
        EOT;
    }

    return $str;
}

echo curatorList($data);
if (isset($data['count']) && isset($data['currentPage'])) {
    include Application::$BASE_DIR . '/src/views/components/pagination.php';
}
?>