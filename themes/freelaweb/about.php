<?php $v->layout("_theme"); ?>
<section class="about_page">
    <div class="about_page_content content container">
        <div class="cards-2 mt-7">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <header class="about_header">
                            <h1>É simples, fácil e rápido!</h1>
                            <p>Com o <?= CONF_SITE_NAME ?> você consegue contratar um especialista para tirar seu projeto
                                do papel e realizar seu sonho, ou caso queira ganhar uma graninha prestando serviços aos
                                nossos clientes.</p>
                        </header>
                    </div> <!-- end of col -->
                </div> <!-- end of row -->
            </div>
        </div>

        <!--FEATURES-->
        <div class="about_page_steps">
            <article class="radius">
                <header>
                    <span class="icon icon-notext icon-bg"><i class="far fa-check-circle"></i></span>
                    <h3>Cadastre-se para começar</h3>
                    <p>Basta informar seus dados e confirmar seu cadastro para começar a usar os
                        recursos do <?= CONF_SITE_NAME ?>.</p>
                </header>
            </article>

            <article class="radius">
                <header>
                    <span class="icon icon-notext icon-bg"><i class="fa-solid fa-users"></i></span>
                    <h3>Vários Freelancers</h3>
                    <p>Aqui você pode criar projetos ilimitados e escolher o freelancer de sua preferência, comece agora
                    e crie seu primeiro projeto.</p>
                </header>
            </article>

            <article class="radius">
                <header>
                    <span class="icon icon-notext icon-bg"><i class="fa-solid fa-briefcase"></i></span>
                    <h3>Vários Projetos</h3>
                    <p>No <?= CONF_SITE_NAME ?> você encontrará centenas de projetos a sua disposição, contrate um plano para
                        ter acesso a enviar várias propostas.</p>
                </header>
            </article>
        </div>
    </div>
    <?php
        if(!empty($video)):
    ?>
    <div class="about_page_media">
        <div class="about_media_video">
            <div class="embed">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?= $video; ?>?rel=0&amp;showinfo=0" frameborder="0"
                        allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <?php
        endif;
    ?>

    <aside class="about_page_cta">
        <div class="about_page_cta_content container content">
            <h2>Ainda não está usando o <?= CONF_SITE_NAME ?> ?</h2>
            <p>Com ele você tem todos os recursos necessários para tirar o seu projeto do papel. Crie sua conta e comece a
                agora mesmo! É simples, fácil e rápido.</p>
            <a href="<?= url("/cadastrar"); ?>" title="Cadastre-se"
               class="about_page_cta_btn">Quero me cadastrar</a>
        </div>
    </aside>
</section>

