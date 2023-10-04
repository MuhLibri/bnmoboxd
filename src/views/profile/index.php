<?php

use app\core\Application;

include_once Application::$BASE_DIR . '/src/views/components/navbar.php';

$username = $data['profile']['username'];
$email = $data['profile']['email'];
$firstName = $data['profile']['firstName'];
$lastName = $data['profile']['lastName'];
$profilePicturePath = $data['profile']['profilePicturePath'] ? '/assets/users/' . $data['profile']['profilePicturePath'] : '/assets/users/blank.jpeg';
$html = <<<EOT
<div class="base-container">
    <div class="form-card">
        <h2>Profile</h2>
        <div class="user-profile">
            <img src="$profilePicturePath">
        </div>
        <form class="form-container" id="profile-form">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first-name" name="first_name" formnovalidate value="$firstName">
                <label class="form-error" id="first-name-form-error"></label>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" formnovalidate value="$lastName">
                <label class="form-error" id="last-name-form-error"></label>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" formnovalidate value="$email">
                <label class="form-error" id="email-form-error"></label>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" formnovalidate value="$username">
                <label class="form-error" id="username-form-error"></label>
            </div>
             <div class="form-group">
                <label for="profile-picture">Profile Picture</label>
                <input type="file" id="profile-picture" name="profile_picture" accept="image/*">
            </div>
            <div class="btn-group">
                <button class="btn-primary" id="save-btn">Save Changes</button>
                <button class = "btn-danger" id="delete-btn"">Delete Account</button>
            </div>
            <div class="modal-container" id="confirm-edit-modal">
                <div class="confirmation-modal">
                    <h2>Are you sure you want to edit your profile?</h2>
                    <div class="btn-group">
                        <button class="btn-primary" id="confirm-edit-btn">Yes</button>
                        <button class="btn-danger" onclick="handleClose('#confirm-edit-modal')">Cancel</button>
                    </div>
                 </div>
            </div>
            <div class="modal-container" id="confirm-delete-modal">
                <div class="confirmation-modal">
                    <h2>Are you sure you want to delete your account?</h2>
                    <div class="btn-group">
                        <button class="btn-primary" id="confirm-delete-btn">Yes</button>
                        <button class="btn-danger" onclick="handleClose('#confirm-delete-modal')">Cancel</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>
    <script defer src="/js/confirmation-modal.js"></script>   
    <script defer src="/js/profile.js"></script>
    <script defer src="/js/form-handler.js"></script>
</div>
EOT;

echo $html;