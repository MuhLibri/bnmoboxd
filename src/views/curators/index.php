<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

function curatorList($data) {
    $str = "";
    $curators = $data['curators'];
    if (!empty($curators)) {
        foreach ($curators as $curator) {
            $id = $curator['id'];
            $name = "Lizaaaa";
            $reviewCount = 5;
            $subscriber = $curator['count'];
            $status = $curator['status'];
            $profileImg = '/assets/users/blank.jpeg';
            $html = <<<EOT
            <a href="/curators/$id" class="curator-container" id="cc1">
                <div class="user-profile">
                    <img alt="curator's profile" src="$profileImg">
                </div>
                <div class="curator-details">
                    <h6>$name</h6>
                    <h6 class="curator-info">$reviewCount review</h6>
                    <h6 class="curator-info">$subscriber subscriber</h6>
                </div>
                <div class="status-section">
                    <h6 class="status-text">$status</h6>
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


?>

<div class="base-container">
    <h5 class="section-title">CURATORS</h5>
    <div class="curator-list">
        <?php
            echo curatorList($data);
        ?>
    </div>
</div>

<script defer src="/js/curators.js"></script>