<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="author" content="<?= CONF_SITE_NAME ?>">
        <?= $head ?>
        <!-- Favicon  -->
        <link rel="icon" type="image/png" href="<?= url("/storage/images/favicon.png"); ?>">
        <link href="<?= theme("/assets/style.css")?>" rel="stylesheet">
    </head>
    <body data-spy="scroll" data-target=".fixed-top" onKeyDown="AnalizaTeclas()">

        <!-- Preloader -->
        <div class="spinner-wrapper">
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
        <!-- end of preloader -->

        <!-- Header -->
        <?php if(empty($noHeader)): ?>
            <?= $v->insert("views/header"); ?>
        <?php endif; ?>
        <!-- end of header -->

        <!-- Content -->
        <?= $v->section("content"); ?>
        <!-- end of content -->

        <!-- end of footer -->
        <script src="https://kit.fontawesome.com/4ece22f5cd.js" crossorigin="anonymous"></script>
        <script src="<?= theme("/assets/scripts.js") ?>"></script>
        <?= $v->section("scripts"); ?>
    </body>
</html>