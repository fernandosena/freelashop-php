<?php $v->layout("_theme") ?>
<section class="main">
    <div id="Content" class="wrapper topSection">
        <div id="Header">
            <div class="wrapper">
                <div class="logo"><h1>FreelaShop</h1></div>
            </div>
        </div>
        <h2>Estamos chegando em breve!!!</h2>
        <div class="countdown styled"></div>
    </div>
</section>
<section class="subscribe spacing">
    <div class="container">
        <div id="subscribe">
            <h3>Digite o seu e-mail para ser notificado quando o site estiver online</h3>
            <form class="auth_form" action="<?= url("/newsletter"); ?>" method="post" data-toggle="validator" data-focus="false">
                <div class="form-email">
                    <span class="ajax_response"><?= flash(); ?></span>
                    <?= csrf_input(); ?>
                    <input name="email" placeholder="Seu melhor e-mail" type="text" id=""/>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</section>