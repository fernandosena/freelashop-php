<?php $v->layout("_theme"); ?>

<!-- Privacy Content -->
<div class="ex-basic-2 mt-7">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="image-container-small optin_page_content">
                    <img class="img-fluid" title="<?= $error->title; ?>" src="<?= image(theme("/assets/images/erro.jpg"), 500) ?>" alt="<?= $error->title; ?>">
                </div> <!-- end of image-container-large -->
                <div class="text-container last">
                    <h1>&bull; ERRO <?= $error->code ?> &bull;</h1>
                    <h3><?= $error->title; ?></h3>
                    <p><?= $error->message; ?></p>
                </div> <!-- end of text-container -->

                <?php if ($error->link): ?>
                    <a class="btn-outline-reg" href="<?= $error->link; ?>" title="<?= $error->linkTitle; ?>"><?= $error->linkTitle; ?></a>
                <?php endif; ?>
            </div> <!-- end of col-->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of ex-basic-2 -->
<!-- end of privacy content -->