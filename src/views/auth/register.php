<div class="form-cardr">
    <h2>Register</h2>
    <form class="form-container" id="register-form">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first-name" name="first_name" formnovalidate>
            <label class="form-error" id="first-name-form-error"></label>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name <span class="text-disabled"> (optional) </span></label>
            <input type="text" id="last_name" name="last_name" formnovalidate>
            <label class="form-error" id="last_name-form-error"></label>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" formnovalidate>
            <label class="form-error" id="email-form-error"></label>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" formnovalidate>
            <label class="form-error" id="username-form-error"></label>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" formnovalidate>
            <label class="form-error" id="password-form-error"></label>
        </div>
        <div>
            <p class="text-white">Have an account? <a href="/login" class="text-primary font-bold">Login</a> </p>
        </div>
        <label class="form-error" id="auth-form-error"></label>
        <button type="submit" class="btn-primary font-bold">Register</button>
    </form>
</div>
<script defer src="/js/form-handler.js"></script>
<script defer src="/js/register.js"></script>