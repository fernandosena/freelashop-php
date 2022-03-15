<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="<?= CONF_SITE_NAME ?>">
        <?= $head ?>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5J6Q7GS2B7"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-5J6Q7GS2B7');
        </script>
        <!-- Favicon  -->
        <link rel="icon" type="image/png" href="<?= url("/storage/images/favicon.png"); ?>">
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

        <!-- Navigation -->
        <?= $v->insert("views/navbar"); ?>
        <!-- end of navigation -->

        <!-- Content -->
        <?= $v->section("content"); ?>
        <!-- end of content -->

        <?php if(empty($_COOKIE["lgpd"])): ?>
        <div class="cookie tada animated">
            <div class="container-flex">
                <div class="row">
                    <div class="col-md-10 align-middle">
                        <p class="my-auto"><strong>Cookies: </strong>A <?= CONF_SITE_NAME ?> utiliza cookies em seu dispositivo para melhorar
                            a sua experiência na navegação no site e ajudar
                            nas nossas iniciativas de marketing. Ao continuar navegando você concorda com a nossa
                            <a href="<?= url("/politica-de-privacidade")?>" >Política de Privacidade.</a></p>
                    </div>
                    <div class="col-md-2 my-auto">
                        <button type="button" class="btn btn-light text-dark me-2 btn-cadastrar btn-cookie">CONCORDAR</button>
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
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5J6Q7GS2B7"></script>
        <script> PERCENTSITE = <?= CONF_SITE_PERCENTAGE ?></script>
        <script src="<?= theme("/assets/scripts.js") ?>"></script>
        <?= $v->section("scripts"); ?>
        <?php if(user()): ?>
            <script>
                (function($) {
                    function notificationsCount() {
                        var center = $(".notification_center_open");
                        $.post(center.data("count"), function (response) {
                            if (response.count) {
                                center.find("span").html(response.count);
                            } else {
                                center.find("span").html("0");
                            }
                        }, "json");
                    }

                    notificationsCount();

                    setInterval(function () {
                        notificationsCount();
                    }, 1000 * 50);
                })(jQuery);
            </script>
        <?php endif; ?>
    </body>
</html>