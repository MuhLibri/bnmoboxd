<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/global.css">
    <link rel="stylesheet" href="/css/error.css">
    <title>BNMOBOXD | Error</title>
</head>
<body>
<div class="error-page">
    <h2><?php echo $errorCode . ' | ' . $data['message']; ?></h2>
</div>
</body>
</html>