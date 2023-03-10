<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Document</title>
</head>

<style>
    body {
        font-size: 16px;
        display: flex;
        height: 100vh;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 30px;
    }
</style>
<body>


<div class="alert alert-danger" role="alert">

    <?= $message ?>
</div>

<div class="alert alert-secondary" role="alert">
    <pre><?= $trace ?></pre>
</div>
</body>
</html>