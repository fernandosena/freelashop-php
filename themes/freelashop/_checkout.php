<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="<?= CONF_SITE_NAME ?>">
    <?= $head ?>
    <!-- Favicon  -->
    <link rel="icon" type="image/png" href="<?= url("/storage/images/favicon.png"); ?>">
    <link href="<?= theme("/assets/style.css")?>" rel="stylesheet">
    <script src="<?= theme("/js/jquery.min.js")?>"></script>
    <script src="<?= theme("/js/highcharts.js")?>"></script>
    <script src="<?= theme("/js/data.js")?>"></script>
</head>
<body>
<?php if(empty($noHeader)): ?>
    <?= $v->insert("views/header"); ?>
<?php endif; ?>
<!-- Content -->
<?= $v->section("content"); ?>
<!-- end of content -->
</body>
</html>