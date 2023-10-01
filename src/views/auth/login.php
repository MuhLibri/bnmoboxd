<div class="form-card">
    <h2>Login</h2>
    <form class="form-container" id="login-form">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" novalidate>
            <label class="form-error" id="username-form-error"></label>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" novalidate>
            <label class="form-error" id="password-form-error"></label>
        </div>
        <label class="form-error" id="auth-form-error"></label>
        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>
<script defer src="/js/form-handler.js"></script>
<script defer src="/js/login.js"></script>