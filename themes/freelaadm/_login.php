<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <?= $head; ?>

    <link rel="stylesheet" href="<?= theme("/assets/css/boot.css", CONF_VIEW_ADMIN); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/message.css", CONF_VIEW_ADMIN); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/styles.css", CONF_VIEW_ADMIN); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/style.css", CONF_VIEW_ADMIN); ?>"/>
    <link rel="stylesheet" href="<?= theme("/assets/css/login.css", CONF_VIEW_ADMIN); ?>"/>

    <link rel="icon" type="image/png" href="<?= url("/storage/images/favicon.png"); ?>">
</head>
<body>

<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>

<?= $v->section("content"); ?>

<script src="<?= url("/shared/scripts/jquery.min.js"); ?>"></script>
<script src="<?= url("/shared/scripts/jquery-ui.js"); ?>"></script>
<script src="<?= theme("/assets/js/login.js", CONF_VIEW_ADMIN); ?>"></script>

</body>
</html>
