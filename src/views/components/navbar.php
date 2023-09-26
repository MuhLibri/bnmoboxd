<?php
// Get the current page URL
$currentUrl = $_SERVER['REQUEST_URI'];
$authenticated = !empty($_SESSION['username']);

// Define an array of navigation links and their corresponding URLs
$navLinks = [
    'HOME' => '/',
    'FILMS' => '/films',
];

if ($authenticated) {
    $navLinks['MY REVIEWS'] = '#my-reviews';
    $navLinks['WATCH LIST'] = '#watch-list';
}

function isNavLinkActive($currentUrl, $link_url) {
    return strpos($currentUrl, $link_url) !== false;
}
?>

<div class="topnav" id="myTopnav">
    <div class="nav-items">
        <?php
        foreach ($navLinks as $text => $url) {
            $activeClass = isNavLinkActive($currentUrl, $url) ? 'active' : '';
            echo '<a href="' . $url . '" class="' . $activeClass . '">' . $text . '</a>';
        }
        ?>
    </div>
    <div class="dropdown account">
        <button class="dropbtn">Dropdown
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="#">View Profile</a>
            <button id="logoutButton">Logout</button>
        </div>
    </div>
</div>
<script defer src="/js/navbar.js"></script>