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
        <link href="<?= theme("/assets/boot.css")?>" rel="stylesheet">
        <link href="<?= theme("/assets/style.css")?>" rel="stylesheet">
    </head>
    <body data-spy="scroll" data-target=".fixed-top">

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

        <?php if(empty($_COOKIE["lgpd"])): ?>
        <div id="cookie" class="tada animated">
            <div class="centro">
                <div>
                    <p class="my-auto"><strong>Cookies: </strong>A <?= CONF_SITE_NAME ?> utiliza cookies em seu dispositivo para melhorar
                        a sua experiência na navegação no site e ajudar
                        nas nossas iniciativas de marketing. Ao continuar navegando você concorda com a nossa
                        <a href="<?= url("/politica-de-privacidade")?>" >Política de Privacidade.</a></p>
                </div>
                <div>
                    <div class="grupo-btn">
                        <button type="button" class="no-link btn-cookie">CONCORDAR</button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
        <!-- MODAL DE SUPORTE -->
        <?php
            if(user()){
                echo $v->insert("views/modal", ["id"=>"moda-support","modal"=>"support"]);
            }
        ?>
        <!-- Footer -->
        <?php if(empty($noFooter)): ?>
            <?= $v->insert("views/footer"); ?>
        <?php endif; ?>
        <!-- end of footer -->
        <script> PERCENTSITE = <?= CONF_SITE_PERCENTAGE ?></script>
        <script src="https://kit.fontawesome.com/4ece22f5cd.js" crossorigin="anonymous"></script>
        <script src="<?= theme("/assets/scripts.js") ?>"></script>
        <?= $v->section("scripts"); ?>
    </body>
</html>