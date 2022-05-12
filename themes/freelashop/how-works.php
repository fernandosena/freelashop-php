<?php $v->layout("_theme"); ?>
<section id="como-funciona">
    <div class="centro">
        <div class="grupo-titulo-subtitulo">
            <div class="subtitulo">
                <div class="borda"></div>
                <h3><?= ucfirst($title) ?></h3>
            </div>
            <div class="titulo">
                <h3>Como o <?= CONF_SITE_DOMAIN ?> funciona?</h3>
            </div>
        </div>
        <div class="video">
            <figure>
                <img src="<?= theme("/assets/img/{$video["thumb"]}")?>" alt="user1" title="user1">
                <figcaption>
                    <i class="fas fa-play-circle"></i>
                </figcaption>
            </figure>
        </div>
    </div>
</section>
<section id="dados">
    <div class="centro">
        <div class="informacao">
            <?php foreach($dados as $dado): ?>
            <div class="item">
                <div class="imagem">
                    <img src="<?= theme("/assets/img/{$dado["icon"]}")?>" alt="user1" title="user1">
                </div>
                <div class="conteudo">
                    <h3><?= $dado["title"] ?></h3>
                    <p><?= $dado["description"] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="image">
            <img src="<?= theme("/assets/img/{$image}")?>" alt="user1" title="user1">
        </div>
    </div>
</section>
