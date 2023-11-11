<?php
use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';
?>

<div class="base-container">
    <h5 class="section-title">CURATORS</h5>
    <div class="curator-list" id="cl">
        <?php
        include Application::$BASE_DIR . '/src/views/components/curator-list.php';
        ?>
    </div>
</div>

<script defer src="/js/curators.js"></script>