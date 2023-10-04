<?php
$currentUrl = $_SERVER['REQUEST_URI'];

$navLinks = [
    'HOME' => '/',
    'FILMS' => '/films',
];

if (!empty($_SESSION['username'])) {
    $navLinks['MY REVIEWS'] = '/my-reviews';
}

function isNavLinkActive($currentUrl, $linkUrl) {
    return $currentUrl === $linkUrl;
}
?>

<div class="topnav" id="myTopnav">
    <div class="logo=container">
        <img class="nav-logo" src="/assets/logo.png" alt="Logo">
    </div>
    <div class="nav-items">
        <?php
        foreach ($navLinks as $text => $url) {
            $activeClass = isNavLinkActive($currentUrl, $url) ? 'nav-item active' : 'nav-item';
            echo '<a href="' . $url . '" class="' . $activeClass . '">' . $text . '</a>';
        }
        ?>
    </div>
    <?php
    if (!empty($_SESSION['username'])) {
        $profilfe_picture_path = $_SESSION['profile_picture_path'] ? '/assets/users/' . $_SESSION['profile_picture_path'] : '/assets/app/profile.png';
        $html = <<<"EOT"
            <div class="dropdown account">
                <button class="dropbtn">
                    <img src="$profilfe_picture_path" alt="profile-icon" class="profile-icon">
                </button>
                <div class="dropdown-content">
                    <a class="profile-link" href="/profile">VIEW PROFILE</a>
                    <button class="logout-btn" id="logoutButton">LOGOUT</button>
                </div>
            </div>
    EOT;
    } else {
        $html = <<<"EOT"
            <a href="/login">
                <button class="nav-login-btn">Login</button>
            </a>
    EOT;
    }
    echo $html;
    ?>
    <a href="javascript:void(0);" class="icon" onclick="onClick()">&#9776;</a>
</div>
<script defer src="/js/navbar.js"></script>