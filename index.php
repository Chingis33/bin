<?php

require_once 'config.php';
require_once 'Model.php';
require_once 'Url.php';

$dsn = DRIVER . ':host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME . ';charset=' . CHARSET;
$pdo = new PDO($dsn, USERNAME, USERPASSWORD, $options);
$obUrl = new Url($pdo);

if ($obUrl->isRoute()) {
    header( 'Location: ' . $obUrl->route, true, 301);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_REQUEST['url'])) {

    $url = $obUrl->validate($_REQUEST['url']);

    if ($url) {
        $hash = $obUrl->getHash($url);
        $obUrl->findOrCreate($url, array(
            'hash' => $hash,
        ));
    }  else {
        echo 'enter valid url please ';
    }
}

function showUrl($hash) {
    echo 'Короткая ссылка: http://' . $_SERVER['SERVER_NAME'] . '/' . $hash;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Сокращение ссылок</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<main>
    <div class="container">
        <form method="POST">
            <div class="form-group">
                <label for="input-url">Cсылка, которую Вы хотите сократить:</label>
                <input type="text" class="form-control" id="input-url" aria-describedby="help-url" placeholder="http://..." name="url" required>
                <small id="help-url" class="form-text text-muted">На этой странице Вы можете сделать из длинной и сложной ссылки простую. Такие ссылки удобнее использовать в Ваших записях и сообщениях.</small>
            </div>
            <button type="submit" class="btn btn-primary">Сократить</button>
        </form>
    </div>
    <div class="container">
        <?=isset($hash) ? showUrl($hash) : ''?>
    </div>
</main>
</body>
</html>
