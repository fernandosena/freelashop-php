<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html lang="pt-br" class="ie ie6"> <![endif]-->
<!--[if IE 7 ]>	<html lang="pt-br" class="ie ie7"> <![endif]-->
<!--[if IE 8 ]>	<html lang="pt-br" class="ie ie8"> <![endif]-->
<!--[if IE 9 ]>	<html lang="pt-br" class="ie ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="pt-br"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="<?= CONF_SITE_NAME ?>">
    <?= $head ?>
    <link rel="icon" type="image/png" href="<?= url("/storage/images/favicon.png"); ?>">
    <link href="<?= theme("/assets/style.css")?>" rel="stylesheet">
</head>

<body id="home">
    <?= $v->section("content"); ?>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8647856942422335"
            crossorigin="anonymous"></script>
    <script src="<?= theme("/assets/scripts.js") ?>"></script>
    <?= $v->section("scripts"); ?>
</body>
</html>
