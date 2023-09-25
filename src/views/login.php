<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/login.css">
    <title>Login Form</title>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="/login" method="POST">
        <div class="form-group">
            <label for="email">Username</label>
            <input type="text" id="username" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>
</body>
</html>
