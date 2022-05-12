<?php $v->layout("_theme"); ?>
<section id="cadastro">
    <div class="box-cadastro">
        <h2><a href="<?= url() ?>"><?= CONF_SITE_NAME ?></a></h2>
        <div class="container-cadastro">
            <div class="cadastro-btn">
                <div>
                    <h2>Você quer contratar um freelancer?</h2>
                    <div class="grupo-btn">
                        <button class="link"><a href="<?= url("/criar-projeto")?>">contrate um freelancer</a></button>
                    </div>
                </div>
                <div>
                    <h2>Você quer trabalhar como freelancer?</h2>
                    <div class="grupo-btn">
                        <button class="link"><a href="<?= url("/cadastrar")?>">trabalhe como um freelancer</a></button>
                    </div>
                </div>
            </div>
            <div class="info">
                <p>Você já está registrado na <?= CONF_SITE_NAME ?>? <a href="<?= url("/entrar")?>">Logar</a></p>
            </div>
        </div>
    </div>
</section>
